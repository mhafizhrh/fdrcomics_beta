<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Comic;
use App\Models\Genre;
use App\Models\Chapter;
use App\Models\ChapterContent;
use App\Models\ComicGenre;

class ComicController extends Controller
{
	protected function show($comic_id)
	{
		$comic = Comic::find($comic_id);

        // dd($comic->language);
        
		abort_if(!$comic, 404);

		// dd($comic->chapter->count());

		return view('comic.show', compact('comic'));
	}

    protected function create()
    {
        $genres = Genre::all();
    	return view('comic.create', compact('genres'));
    }

    protected function edit($comic_id)
    {
        $comic = Comic::find($comic_id);
        $genres = Genre::all();
        return view('comic.edit', compact('comic', 'genres'));
    }

    protected function store(Request $request)
    {
    	// dd(Genre::find(1));

    	$request->validate([
    		'cover_img_url' => 'required|image',
    		'type' => 'required',
    		'title' => 'required',
    		'author' => 'required',
    		'synopsis' => 'required',
    		'rating' => 'required|max:10',
    		'status' => 'required',
    	]);

    	$title = Str::lower(Str::of($request->input('title'))->replace(' ', '-'));
    	$type = $request->input('type');

    	$request->file('cover_img_url')->storeAs(
    		'comic/' . $type . '/' . $title . '/cover',
    		$request->file('cover_img_url')->getClientOriginalName(),
    		'public'
    	);

    	$cover_img_url = 'comic/' . $type . '/' . $title . '/cover/' . $request->file('cover_img_url')->getClientOriginalName();

    	$comic = new Comic();
    	$comic->type = $request->input('type');
    	$comic->title = $request->input('title');
    	$comic->author = $request->input('author');
    	$comic->synopsis = $request->input('synopsis');
    	$comic->rating = $request->input('rating');
    	$comic->cover_img_url = $cover_img_url;
    	$comic->status = $request->input('status');
    	$comic->save();

        foreach ($request->input('genre') as $key => $value) {
            if (!Genre::find($value)) {
                
                $genre = new Genre();
                $genre->genre = $value;
                $genre->save();

                $comicGenre = new ComicGenre();
                $comicGenre->comic_id = $comic->id;
                $comicGenre->genre_id = $genre->id;
                $comicGenre->save();
            } else {

                $comicGenre = new ComicGenre();
                $comicGenre->comic_id = $comic->id;
                $comicGenre->genre_id = $value;
                $comicGenre->save();
            }
        }

    	return redirect(route('comic.show', [
                'comic_id' => $comic->id,
                'title' => $title
        ]));
    }
}
