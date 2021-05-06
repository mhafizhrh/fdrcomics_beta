<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class AdminCommentsController extends Controller
{
    protected function index()
    {
    	$comments = Comment::paginate(20);

    	return view('admin.comments.index', compact('comments'));
    }
}
