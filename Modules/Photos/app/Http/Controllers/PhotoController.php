<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\Photos\Models\Photo as Photo;
use Modules\Photos\Models\Album;


class PhotoController extends Controller
{
    public function index($slug)  // afficher toutes les photos d'un album
    {
        $album = Album::where('slug', $slug)->firstOrFail(); // utilise le slug pour trouver l'album
        $photos = Photo::where('album_id', $album->id)->get();
        return view('photos::photos.index', compact('photos'));
    }

    public function show($slug) //afficher une photo. utilise le $slug d Album
    {
        //corriger ici pour utiliser le slug
        $photo = Photo::where('slug', $slug)->firstOrFail(); 
        return view('savethedatephotos::photos.show', compact('photo'));
    }

    public function store(Request $request, $slug) // utilise $slug au lieu de $albumId
    {
        $validated = $request->validate([
            'photo'        => 'required|image|max:10240', // max 10MB
            'thumb_path'   => 'nullable|string|max:255',
            'exif_json'    => 'nullable|json',
        ]);

        $album = Album::where('slug', $slug)->firstOrFail();

        // Upload photo
        $file = $request->file('photo');
        $path = $file->store("albums/{$album->id}", 'public');

        // Gather metadata
        $photoData = [
            'original_path' => $path,
            'thumb_path'    => $validated['thumb_path'] ?? null,
            'size_bytes'    => $file->getSize(),
            'mime'          => $file->getMimeType(),
            'exif_json'     => $validated['exif_json'] ?? null,
            'uploaded_ip'   => $request->ip(),
        ];

        $album->photos()->create($photoData);

        return redirect()->route('albums.show', $album->id)
            ->with('success', 'Photo ajoutée avec succès.');
    }

    /**
     * Update photo metadata.
     */
    public function update(Request $request, $albumId, $photoId)
    {
        $validated = $request->validate([
            'thumb_path'   => 'nullable|string|max:255',
            'exif_json'    => 'nullable|json',
        ]);

        $album = Album::findOrFail($albumId);
        $photo = $album->photos()->findOrFail($photoId);

        $photo->update([
            'thumb_path' => $validated['thumb_path'] ?? $photo->thumb_path,
            'exif_json'  => $validated['exif_json'] ?? $photo->exif_json,
        ]);

        return redirect()->route('albums.show', $albumId)
            ->with('success', 'Photo mise à jour avec succès.');
    }

    /**
     * Remove a photo from an album.
     */
    public function destroy($albumId, $photoId)
    {
        $album = Album::findOrFail($albumId);
        $photo = $album->photos()->findOrFail($photoId);

        // Delete file from storage
        if ($photo->original_path && Storage::disk('public')->exists($photo->original_path)) {
            Storage::disk('public')->delete($photo->original_path);
        }

        $photo->delete();

        return redirect()->route('albums.show', $albumId)
            ->with('success', 'Photo supprimée avec succès.');
    }
}