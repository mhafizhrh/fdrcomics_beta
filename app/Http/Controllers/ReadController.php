<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Visitor;

class ReadController extends Controller
{
    protected function index($chapter_id)
	{
		$chapter = Chapter::find($chapter_id);
        $chapters = Chapter::where('comic_id', $chapter->comic_id)
                ->orderByRaw('created_at DESC, chapter DESC')->get();
        $comments = Comment::where('chapter_id', $chapter_id)->get();

        $this->visitorCount($chapter_id);
		
		return view('chapter.read', compact('chapter', 'chapters', 'comments'));
	}

	protected function visitorCount($chapter_id)
	{
		$visitorCheck = Visitor::where('chapter_id', $chapter_id)
				->where('ip', \Request::ip())
				->first();

		if ($visitorCheck) {
			
			$visitor = Visitor::where('chapter_id', $chapter_id)
					->where('ip', \Request::ip())
					->first();
			$visitor->count++;
			$visitor->save();
		} else {

			$visitor = new Visitor();
			$visitor->chapter_id = $chapter_id;
			$visitor->ip = \Request::ip();
			$visitor->count++;
			$visitor->save();
		}

	}
}
