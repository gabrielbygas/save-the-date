<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Photos\Models\Photo;
use Modules\Photos\Models\Album;
use Modules\Photos\Models\UploadToken;
use Modules\Photos\Models\AlbumAccessLog;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class PhotoController extends Controller
{


    /**
     * Stocke une ou plusieurs photos dans un album (propriétaire ou invité).
     */
    public function store(Request $request, $slug)
    {
        $request->validate([
            'photos'      => 'required|array',
            'photos.*'    => 'image|max:10240',
            'category'    => 'nullable|in:civil,religieux,coutumier,reception,autre',
            'exif_json'   => 'nullable|json',
        ]);

        $album = Album::where('slug', $slug)->firstOrFail();
        $directory = "albums/{$album->slug}";

        // Vérifie si l'album est encore actif / espace dispo
        $this->checkActiveAlbumStorage($album);

        // Créer le dossier s'il n'existe pas
        if (!Storage::disk('private')->exists($directory)) {
            Storage::disk('private')->makeDirectory($directory);
        }

        $successCount = 0;

        foreach ($request->file('photos') as $file) {
            DB::beginTransaction();
            try {
                // Nom unique
                $fileName = $this->makeUniqueFileName($file, $album->slug);
                $path     = $file->storeAs($directory, $fileName, 'private');

                if (!Storage::disk('private')->exists($path)) {
                    throw new \Exception("Le fichier n'a pas été stocké.");
                }

                // Miniature
                $thumbPath = $this->createThumbnail($path, $album->slug);

                // Données pour insertion
                $photoData = [
                    'original_path' => $directory . '/' . $fileName,
                    'file_name'     => $fileName,
                    'thumb_path'    => $thumbPath,
                    'size_bytes'    => $file->getSize(),
                    'mime'          => $file->getMimeType(),
                    'category'      => $request->category ?? 'autre',
                    'exif_json'     => $request->exif_json,
                    'uploaded_ip'   => $request->ip(),
                ];

                $photo = $album->photos()->create($photoData);

                // Journaliser qui a fait l’upload
                AlbumAccessLog::create([
                    'album_id'   => $album->id,
                    'photo_id'   => $photo->id,
                    'visitor_ip' => $request->ip(),
                    'action'     => 'upload',
                    'user_agent' => $request->userAgent(),
                ]);

                DB::commit();
                $successCount++;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Erreur lors de l'upload de {$file->getClientOriginalName()} : " . $e->getMessage());
            }
        }

        // Retour utilisateur
        if ($successCount > 0) {
            return redirect()
                ->route('photos.index', [
                    'slug'        => $album->slug,
                    'owner_token' => $album->owner_token,
                ])
                ->with('success', "{$successCount} photo(s) ajoutée(s) avec succès.");
        }

        return back()->with('error', 'Aucune photo n\'a pu être ajoutée. Vérifiez les fichiers et réessayez.');
    }
}
