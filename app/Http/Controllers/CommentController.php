<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Chapter;
use App\Models\Comment;

class CommentController extends Controller
{
    protected function index($chapter_id)
    {
        $comments = Comment::where('chapter_id', $chapter_id)->paginate(20);

        return view('comics.chapters.comments', compact('comments'));
    }

    protected function store(Request $request, $chapter_id)
    {
    	$request->validate([
    		'comment' => 'required|max:500',
    	]);

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->chapter_id = $chapter_id;
        $comment->comment = nl2br($request->input('comment'));
        $comment->save();

        return redirect(route('read', $chapter_id) . '#comment-card');
    }

    protected function delete($id)
    {
        $comment = Comment::find($id);

        abort_if(!$comment, 404);

        $comment->delete();

        return redirect(route('read', $comment->chapter_id) . '#comment-card');
    }
}
