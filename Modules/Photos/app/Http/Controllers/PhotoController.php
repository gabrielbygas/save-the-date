<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Photos\App\Models\Photo as Photo;


class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::all();
        return view('photos.photos.index', compact('photos'));
    }

    public function show($id)
    {
        $photo = Photo::findOrFail($id);
        return view('photos.photos.show', compact('photo'));
    }

    public function store(Request $request)
    {
        $photo = Photo::create($request->all());
        return redirect()->route('photos.index')->with('success', 'Photo ajoutée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);
        $photo->update($request->all());
        return redirect()->route('photos.show', $photo->id)->with('success', 'Photo mise à jour.');
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->delete();
        return redirect()->route('photos.index')->with('success', 'Photo supprimée.');
    }
}