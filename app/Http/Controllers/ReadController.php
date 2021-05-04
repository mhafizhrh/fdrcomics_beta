<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Visitor;
use App\Models\History;

class ReadController extends Controller
{
    protected function index($chapter_id)
	{
		$chapter = Chapter::find($chapter_id);

		abort_if(!$chapter, 404);
		
        $chapters = Chapter::where('comic_id', $chapter->comic_id)
                ->orderByRaw('created_at DESC, chapter DESC')->get();
        $comments = Comment::where('chapter_id', $chapter_id)->get();

        $this->visitorCount($chapter_id);
        $this->readHistory($chapter_id);
		
		return view('comics.chapters.read', compact('chapter', 'chapters', 'comments'));
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

	protected function readHistory($chapter_id)
	{
		if (Auth::check()) {
			
			// Delete this chapter history

			// History::where('chapter_id', $chapter_id)
			// 		->where('user_id', Auth::user()->id)
			// 		->delete();

			$chapter = Chapter::find($chapter_id);

			$thisHistory = History::where('chapter_id', $chapter_id)
					->where('user_id', Auth::user()->id)
					->orderBy('created_at', 'ASC')
					->first();

			$userHistory = History::where('user_id', Auth::user()->id)
					->orderBy('created_at', 'ASC')
					->get();

			if ($userHistory) {

				foreach ($userHistory as $key) {
					
					if ($key->chapter->comic->id == $chapter->comic->id) {

						History::destroy($key->id);
					}
				}
			}

			$store = new History();
			$store->chapter_id = $chapter_id;
			$store->user_id = Auth::user()->id;
			$store->save();

			if ($userHistory->count() >= 11) {

				// Delete last history

				History::where('chapter_id', $history->first()->id)
						->where('user_id', Auth::user()->id)
						->delete();
			}
		}
	}
}
