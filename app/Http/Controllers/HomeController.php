<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Comic;
use App\Models\Genre;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected function index()
    {
        $comics = Comic::paginate(20);

        return view('home', compact('comics'));
    }
}
