<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Genre;
use App\Models\Bookmark;
use App\Models\Visitor;

class SearchController extends Controller
{
    protected function search(Request $request)
    {
        $genres = $request->genres == null ? [] : $request->genres;
        $title = $request->title;

        $comics = $this->search_comics($title, $genres);

        $oneWeekAgo = date('Y-m-d 00:00:00', strtotime('-1 week'));
        $currentDate = date('Y-m-d 23:59:59');

        $weeklyPopularChapters = Visitor::whereBetween('updated_at', [$oneWeekAgo, $currentDate])
                ->selectRaw('chapter_id, SUM(count) AS visitedCount')
                ->groupBy('chapter_id')
                ->limit(10)
                ->get();

        $popularComics = Bookmark::selectRaw('comic_id, COUNT(*) AS userBookmarks')
                ->groupBy('comic_id')
                ->limit(10)
                ->get();

        $genres = Genre::all();

        return view('search', compact('comics', 'weeklyPopularChapters', 'popularComics', 'genres', 'request'));
    }

    protected function search_comics($title = null, $genres = null)
    {
        $comics = Comic::select('comics.*');
        $comics->join('comic_genres', 'comics.id', '=', 'comic_genres.comic_id');
        foreach ($genres as $key) {
            $comics->whereExists(function ($query) use ($key) {
                $query->from('comic_genres');
                $query->whereColumn('comic_genres.comic_id', 'comics.id');
                $query->where('comic_genres.genre_id', $key);
            });
        }
        $comics->where('comics.title', 'like', '%' . $title . '%');
        $comics->orderBy('comics.updated_at', 'DESC');
        $comics->groupBy('comics.id', 'comics.title', 'comics.title', 'comics.author_id', 'comics.language_id', 'comics.synopsis', 'comics.img_path', 'comics.status', 'comics.created_at', 'comics.updated_at', 'comics.deleted_at');
        $comics = $comics->paginate(20)
                ->appends(['title' => $title, 'genres' => $genres]);

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
