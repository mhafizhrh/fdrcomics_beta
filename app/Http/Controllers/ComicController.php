<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Comic;
use App\Models\Genre;
use App\Models\Chapter;
use App\Models\ChapterContent;
use App\Models\ComicGenre;
use App\Models\Bookmark;
use App\Models\Rating;

class ComicController extends Controller
{
	protected function index($comic_id)
	{
		$comic = Comic::find($comic_id);
        if (Auth::check()) {
            $bookmark = Bookmark::where('comic_id', $comic_id)
                    ->where('user_id', Auth::user()->id)
                    ->first();
            $rating = Rating::where('comic_id', $comic_id)
                    ->where('user_id', Auth::user()->id)
                    ->first();
        } else {

            $bookmark = null;
            $rating = null;
        }

		return view('comics.index', compact('comic', 'bookmark', 'rating'));
	}

    protected function bookmark($comic_id)
    {
        $cek = Bookmark::where('comic_id', $comic_id)
                ->where('user_id', Auth::user()->id)
                ->first();

        if (!$cek) {

            $bookmark = new Bookmark();
            $bookmark->comic_id = $comic_id;
            $bookmark->user_id = Auth::user()->id;
            $bookmark->save();
        } else {

            Bookmark::where('comic_id', $comic_id)
                ->where('user_id', Auth::user()->id)
                ->delete();
        }

        return redirect()->route('comics', $comic_id);
    }

    protected function rating(Request $request, $comic_id)
    {
        $cek = Rating::where('comic_id', $comic_id)
                ->where('user_id', Auth::user()->id)
                ->first();

        if (!$cek) {

            $rating = new Rating();
            $rating->comic_id = $comic_id;
            $rating->user_id = Auth::user()->id;
            $rating->rating = $request->input('rating');
            $rating->save();
        } else {

            if ($request->input('rating') == 'unrate') {

                Rating::where('comic_id', $comic_id)
                    ->where('user_id', Auth::user()->id)
                    ->delete();
            } else {

                $cek->rating = $request->input('rating');
                $cek->save();
            }
        }

        return redirect()->route('comics', $comic_id);
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
