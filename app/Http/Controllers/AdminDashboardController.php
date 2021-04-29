<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\ChapterContent;
use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\Visitor;

class AdminDashboardController extends Controller
{
    protected function dashboard()
    {
    	$comments = Comment::all();
    	$bookmarks = Bookmark::all();
    	$chapterContents = ChapterContent::all();
    	$users = User::all();
    	$comics = Comic::all();
    	$chapters = Chapter::all();
    	$visitors = Visitor::all()->sum('count');

    	return view('admin.dashboard', compact('comments', 'bookmarks', 'chapterContents','users', 'comics', 'chapters', 'visitors'));
    }
}
