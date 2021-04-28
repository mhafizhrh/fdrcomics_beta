<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Comic;
use App\Models\Chapter;
use App\Models\ChapterContent;
use App\Models\Language;

class AdminChaptersController extends Controller
{
    protected function new($comic_id)
    {
    	$comic = Comic::find($comic_id);
    	$languages = Language::all();

    	return view('admin.comics.chapters.new', compact('comic', 'languages'));
    }

    protected function store(Request $request, $comic_id)
    {
    	$request->validate([
    		'chapter' => 'required|numeric',
    	]);

    	$comic = Comic::find($comic_id);

    	$chapter = new Chapter();
    	$chapter->comic_id = $comic_id;
    	$chapter->chapter = $request->input('chapter');
    	$chapter->title = $request->input('title');
    	$chapter->language_id = $request->input('language_id');
    	$chapter->save();

    	if ($request->hasFile('img_path')) {
            
            $i = 1;

            foreach ($request->file('img_path') as $key) {

	            $path = $key->storeAs(
	                'images/' . $comic->authors->name . '/' . $comic->title . '/chapter-' . $request->input('chapter'),
	                $key->getClientOriginalName(),
	                'public'
	            );

	            $chapterContent = new ChapterContent();
            	$chapterContent->chapter_id = $chapter->id;
            	$chapterContent->img_path = $path;
            	$chapterContent->img_order = $i++;
            	$chapterContent->save();
	        }

        }

        return redirect()->route('admin.comics.chapters', $chapter->id);
    }
}
