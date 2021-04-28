<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\History;
use App\Models\Bookmark;

class UserController extends Controller
{
    protected function history()
    {
    	$history = History::where('user_id', Auth::user()->id)
    			->orderBy('created_at', 'DESC')
    			->get();

    	return view('user.history', compact('history'));
    }

    protected function bookmarks()
    {
    	$bookmarks = Bookmark::where('user_id', Auth::user()->id)
    			->get();

    	return view('user.bookmarks', compact('bookmarks'));
    }
}
