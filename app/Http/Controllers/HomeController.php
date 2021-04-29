<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

use App\Models\Chapter;
use App\Models\Comic;
use App\Models\Genre;
use App\Models\Visitor;

class HomeController extends Controller
{
    protected function index()
    {
        $comics = Comic::paginate(20);

        $visitors = Visitor::selectRaw('*, SUM(count) AS visitedCount')->groupBy('chapter_id')->get();

        // dd($visitors);

        return view('home', compact('comics', 'visitors'));
    }
}
