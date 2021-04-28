<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorCount;
use App\Models\Chapter;
use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected function index(Request $request)
    {

    	// $from_date = date('Y-m-d', strtotime('-1 week')) . ' 00:00:00';
    	// $to_date = date('Y-m-d') . ' 23:59:59';

     //    $comics = Comic::all();
     //    $popularChapter = VisitorCount::whereBetween('updated_at', [$from_date, $to_date])
     //    		->orderBy('count', 'DESC')
     //    		->limit(10)
     //    		->get()
     //    		->unique('chapter_id');
     //    $genresUnique = Genre::orderBy('genre', 'ASC')->get()->unique('genre');

        return view('admin.dashboard');
    }
}
