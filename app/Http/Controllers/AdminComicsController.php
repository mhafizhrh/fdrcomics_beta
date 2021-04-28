<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Comic;
use App\Models\Genre;
use App\Models\ComicGenre;
use App\Models\Author;
use App\Models\Language;

class AdminComicsController extends Controller
{
    protected function index()
    {
    	$comics = Comic::all();
    	return view('admin.comics.index', compact('comics'));
    }

    protected function new()
    {
        $languages = Language::all();
        $genres = Genre::all();
        $authors = Author::all();
        return view('admin.comics.new', compact('languages', 'genres', 'authors'));
    }

    protected function store(Request $request)
    {
        dd($request->file());
        $request->validate([
            'title' => 'required',
            'author_id' => 'required|numeric',
            'language_id' => 'required|numeric',
        ]);

        $img_path = $request->file('img_path') == null ? 'images/sancomics_cover.png' : $request->file('img_path');

        $comics = new Comic();
        $comics->title = $request->input('title');
        $comics->author_id = $request->input('author_id');
        $comics->language_id = $request->input('language_id');
        $comics->synopsis = $request->input('synopsis');
        $comics->img_path = $img_path;
        $comics->status = $request->input('status');
        $comics->save();

        foreach ($request->genre_id as $key => $value) {

            $genres = new ComicGenre();
            $genres->genre_id = $value;
            $genres->comic_id = $comics->id;
            $genres->save();
        }

        return redirect()->route('admin.comics.new')->with('success', 'New Comic has been added.');
    }

    protected function edit($comic_id)
    {
        $comic = Comic::find($comic_id);
        $languages = Language::all();
        $genres = Genre::all();
        $authors = Author::all();

        return view('admin.comics.edit', compact('comic', 'languages', 'genres', 'authors'));
    }

    protected function update(Request $request, $comic_id)
    {
        // dd($request);
        $request->validate([
            'title' => 'required',
            'author_id' => 'required|numeric',
            'language_id' => 'required|numeric',
        ]);

        $img_path = $request->file('img_path') == null ? 'images/sancomics_cover.png' : $request->file('img_path');

        $comic = Comic::find($comic_id);
        $comic->title = $request->input('title');
        $comic->author_id = $request->input('author_id');
        $comic->language_id = $request->input('language_id');
        $comic->img_path = $img_path;

        if ($request->hasFile('img_path')) {

            $deleteFile = Storage::delete('public/' . $comic->img_path);
            
            $path = $request->file('img_path')->storeAs(
                'images/' . $comic->authors->name . '/' . $comic->title . '/cover',
                $request->file('img_path')->getClientOriginalName(),
                'public'
            );

            $comic->img_path = $path;
        }

        $comic->synopsis = $request->input('synopsis');
        $comic->status = $request->input('status');
        $comic->save();

        ComicGenre::where('comic_id', $comic_id)->delete();

        foreach ($request->genre_id as $key => $value) {

            $genres = new ComicGenre();
            $genres->genre_id = $value;
            $genres->comic_id = $comic->id;
            $genres->save();
        }

        return redirect()->route('admin.comics.edit', $comic_id)->with('success', 'Comic Updated.');
    }
}
