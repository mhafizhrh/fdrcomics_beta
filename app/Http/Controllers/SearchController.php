<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comic;
use App\Models\Genre;
use App\Models\Bookmark;
use App\Models\Visitor;
use App\Models\Language;

class SearchController extends Controller
{
    protected function search(Request $request)
    {
        $comics = $this->search_comics($request)
                ->paginate(20)
                ->appends($request->input());

        $genres = Genre::all();
        $languages = Language::all();

        return view('search', compact('comics', 'genres', 'languages', 'request'));
    }

    protected function search_comics($request)
    {
        $genres = $request->genres == null ? [] : $request->genres;
        $title = $request->title;
        $bookmarks = $request->bookmarks;
        $language = $request->language;

        $comics = Comic::select('comics.*');
        $comics->join('comic_genres', 'comics.id', '=', 'comic_genres.comic_id');

        foreach ($genres as $key) {
            $comics->whereExists(function ($query) use ($key) {
                $query->from('comic_genres');
                $query->whereColumn('comic_genres.comic_id', 'comics.id');
                $query->where('comic_genres.genre_id', $key);
            });
        }

        if ($language) {

            $comics->where('language_id', $language);
        }

        if (Auth::check() && $bookmarks) {
            $comics->whereExists(function ($query) {
                $query->from('bookmarks');
                $query->where('bookmarks.user_id', Auth::user()->id);
                $query->whereColumn('bookmarks.comic_id', 'comics.id');
            }); 
        }

        $comics->where('comics.title', 'like', '%' . $title . '%');
        $comics->orderBy('comics.updated_at', 'DESC');
        $comics->groupBy('comics.id', 'comics.title', 'comics.title', 'comics.author_id', 'comics.language_id', 'comics.synopsis', 'comics.img_path', 'comics.status', 'comics.created_at', 'comics.updated_at', 'comics.deleted_at');
        // $comics = $comics;

        return $comics;
    }

    protected function filter(Request $request)
    {

    	$type = $request->input('type') == null ? '*' : $request->input('type');
    	$title = $request->input('title') == null ? '*' : $request->input('title');
    	$genre = $request->input('genre');
    	$genres = '';
    	$i = 1;

    	if ($genre) {

	    	foreach ($genre as $key => $value) {
	    		
	    		$genres .= $value;

	    		if (count($genre) != $i++) {
	    			
	    			$genres .= ',';
	    		}
	    	}
	    } else {

	    	$genres = '*';
	    }

    	// dd($request->input(), $genres);

    	return redirect()->route('search', ['title' => $title, 'type' => $type, 'genre' => $genres]);
    }
}
