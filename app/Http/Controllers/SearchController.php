<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Genre;
use App\Models\VisitorCount;

class SearchController extends Controller
{
    protected function search($title, $type, $genres)
    {

    	if ($title == '*') { $title = ''; }
    	if ($type == '*') { $type = ''; }
    	if ($genres == '*') { $genres = ''; }

    	$from_date = date('Y-m-d', strtotime('-1 week')) . ' 00:00:00';
    	$to_date = date('Y-m-d') . ' 23:59:59';

    	$popularChapter = VisitorCount::whereBetween('updated_at', [$from_date, $to_date])
        		->orderBy('count', 'DESC')
        		->limit(10)
        		->get()
        		->unique('chapter_id');

        $genresUnique = Genre::orderBy('genre', 'ASC')->get()->unique('genre');


    	$comics = Comic::whereHas('comicGenre', function (Builder $query) use ($genres) {
    		if ($genres != '') {
	    		$query->whereIn('comic_id', explode(',', $genres));
	    	}
    	})->where('type', $type)->where('title', 'like', '%'.$title.'%')->get();

    	// dd($comics);

    	return view('home', compact('comics', 'genresUnique', 'popularChapter'));
    }

    protected function filter(Request $request)
    {

    	$type = $request->input('type');
    	$title = $request->input('title');
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
