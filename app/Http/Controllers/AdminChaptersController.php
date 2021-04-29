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
            'img_path.*' => 'image|mimes:jpeg,png,jpg,gif,svg',
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

        $comic->touch();

        return redirect()->route('admin.comics.chapters.edit', $chapter->id);
    }

    protected function edit($chapter_id)
    {
        $chapter = Chapter::find($chapter_id);
        $languages = Language::all();

        return view('admin.comics.chapters.edit', compact('chapter', 'languages'));
    }

    protected function update(Request $request, $chapter_id)
    {
        $request->validate([
            'chapter' => 'required|numeric',
        ]);

        $chapter = Chapter::find($chapter_id);
        $chapter->chapter = $request->input('chapter');
        $chapter->title = $request->input('title');
        $chapter->save();

        return redirect()->route('admin.comics.chapters.edit', $chapter_id)->with('success', 'Chapter has been updated.');
    }

    protected function delete($chapter_id)
    {
        $chapter = Chapter::find($chapter_id);

        // Delete
        Chapter::destroy($chapter_id);

        return redirect()->route('admin.comics.edit', $chapter->comic->id)->with('success', 'Chapter has been deleted.');
    }

    protected function storeContent(Request $request, $chapter_id)
    {
        $request->validate([
            'img_path.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $chapter = Chapter::find($chapter_id);
        $comic = Comic::find($chapter->comic->id);

        if ($request->hasFile('img_path')) {

            $i = $chapter->chapterContent->max('img_order') == null ? 1 : $chapter->chapterContent->max('img_order');
            // $i = 1;

            foreach ($request->file('img_path') as $key) {

                $path = $key->storeAs(
                    'images/' . $chapter->comic->authors->name . '/' . $chapter->comic->title . '/chapter-' . $chapter->chapter,
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

        $chapter->touch();
        $comic->touch();

        return redirect()->route('admin.comics.chapters.edit', $chapter_id)->with('success', 'Image has been uploaded.');
    }

    protected function updateContent(Request $request, $chapter_id)
    {
        $request->validate([
            'id.*' => 'required'
        ]);

        $i = 1;

        foreach ($request->input('id') as $key) {
            
            $chapterContent = ChapterContent::find($key);
            $chapterContent->img_order = $i++;
            $chapterContent->save();
        }

        return redirect()->route('admin.comics.chapters.edit', $chapter_id)->with('success', 'Image reordered.');
    }

    protected function deleteContent($id)
    {
        $chapterContent = ChapterContent::find($id);

        $deleteFile = Storage::delete('public/' . $chapterContent->img_path);

        ChapterContent::destroy($id);

        return redirect()->route('admin.comics.chapters.edit', $chapterContent->chapter->id)->with('success', 'Image deleted.');
    }
}
