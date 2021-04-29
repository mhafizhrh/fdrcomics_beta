<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

use App\Models\Chapter;
use App\Models\Comic;
use App\Models\Genre;
use App\Models\Visitor;
use App\Models\Bookmark;

class HomeController extends Controller
{
    protected function index()
    {
        $comics = Comic::orderBy('updated_at', 'DESC')->paginate(20);

        $oneWeekAgo = date('Y-m-d 00:00:00', strtotime('-1 week'));
        $currentDate = date('Y-m-d 23:59:59');

        $weeklyPopularChapters = Visitor::whereBetween('updated_at', [$oneWeekAgo, $currentDate])
        		->selectRaw('*, SUM(count) AS visitedCount')
        		->groupBy('chapter_id')
      			->limit(10)
      			->get();

        // By Visitor
      	// $popularComics = Visitor::join('chapters', 'visitors.chapter_id', '=', 'chapters.id')
      	// 		->join('comics', 'chapters.comic_id', '=', 'comics.id')
      	// 		->selectRaw('comics.*')
      	// 		->groupBy('comics.id')
      	// 		->get();

      	$popularComics = Bookmark::selectRaw('*, COUNT(*) AS userBookmarks')
      			->groupBy('comic_id')
      			->limit(10)
      			->get();

      	// dd($popularComicsByUsers);

        return view('home', compact('comics', 'weeklyPopularChapters', 'popularComics'));
    }
}
