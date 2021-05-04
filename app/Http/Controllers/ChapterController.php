<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\ChapterContent;
use App\Models\VisitorCount;
use App\Models\ReadingHistory;

class ChapterController extends Controller
{
	protected function read($chapter_id)
	{
		$chapter = Chapter::find($chapter_id);
        $chapters = Chapter::where('comic_id', $chapter->comic_id)
                ->orderByRaw('created_at DESC, chapter DESC')->get();

        // dd($chapters);

        // $comic = Comic::find($chapter->comic->id);


        //////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////
		
		return view('chapter.read', compact('chapter', 'chapters'));
	}

    protected function create($comic_id)
    {
        $comic = Comic::find($comic_id);

        abort_if(!$comic, 404);

        return view('chapter.create', compact('comic'));
    }

    protected function store(Request $request, $comic_id)
    {
        $comic = Comic::find($comic_id);

        abort_if(!$comic, 404);

        $request->validate([
            'chapter' => 'required|integer',
            'image.*' => 'image',
            'language' => 'required',
        ]);

        $chapter = new Chapter();
        $chapter->comic_id = $comic->id;
        $chapter->chapter = $request->input('chapter');
        $chapter->chapter_title = $request->input('chapter_title');
        $chapter->language = $request->input('language');
        $chapter->save();

        $comicType = $chapter->comic->type;
        $comicTitle = $chapter->comic->title;


        foreach($request->file('image') as $image) {

            $image->storeAs(
                'images/' . $comicType . '/' . $chapter->comic->id . '/' . $chapter->chapter,
                $image->getClientOriginalName(),
                'public'
            );

            $imgOrder = ($chapter->chapterContent->count()) <= 0 ? '0' : ($chapter->chapterContent->first()->img_order + 1);

            $imgPath = 'images/' . $comicType . '/' . $chapter->comic->id . '/' . $chapter->chapter  . '/' . $image->getClientOriginalName();

            $chapterContent = new ChapterContent();
            $chapterContent->chapter_id = $chapter->id;
            $chapterContent->img_order = $imgOrder;
            $chapterContent->img_path = $imgPath;
            $chapterContent->save();
        }

        return redirect(route('comic.show', $comic->id))->with('status', 'A new chapter has been added.');
    }

    protected function edit($chapter_id)
    {
    	$chapter = Chapter::find($chapter_id);
    	$comic = Comic::find($chapter->comic->id);

        abort_if(!$chapter, 404);

    	return view('chapter.edit', compact('chapter', 'comic'));
    }

    protected function delete(Request $request)
    {
        $chapter = Chapter::find($request->input('chapter_id'));

        Chapter::destroy($request->input('chapter_id'));

        return redirect(route('comic.show', $chapter->comic->id));
    }
}
