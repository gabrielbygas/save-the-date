<?php

namespace Modules\Photos\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Photos\Models\Album as Album;
use Illuminate\Http\Request;
// use Modules\Photos\Models\Album;

class AlbumController extends Controller
{   
    public function index()
    {
        $albums = Album::all();
        return view('photos::albums.index', compact('albums'));
    }

    public function show($slug) //affiche les photos d un album
    {
        $album = Album::where('slug', $slug)->with('photos')->firstOrFail();
        return view('photos::albums.show', compact('album'));
    }

    public function store(Request $request)
    {
        $album = Album::create($request->all());
        return redirect()->route('albums.index')->with('success', 'Album créé avec succès.');
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        $album->update($request->all());
        return redirect()->route('albums.show', $album->id)->with('success', 'Album mis à jour.');
    }

    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        $album->delete();
        return redirect()->route('albums.index')->with('success', 'Album supprimé.');
    }
}