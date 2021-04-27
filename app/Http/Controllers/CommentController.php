<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Chapter;
use App\Models\Comment;

class CommentController extends Controller
{
    protected function store(Request $request, $chapter_id)
    {
    	$request->validate([
    		'comment' => 'required|max:500',
    	]);

    	$chapter = Chapter::find($chapter_id);

        // dd($chapter);

    	abort_if(!$chapter, 404);

    	$comment = new Comment();
    	$comment->user_id = Auth::user()->id;
    	$comment->chapter_id = $chapter->id;
    	$comment->comment = nl2br($request->input('comment'));
    	$comment->save();

    	return redirect(route('chapter.read', $chapter->id) . '#comment');
    }
}
