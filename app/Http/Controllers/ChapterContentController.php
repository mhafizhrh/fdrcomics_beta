<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Comic;
use App\Models\Chapter;
use App\Models\ChapterContent;
use App\Models\VisitorCount;

class ChapterContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $chapter_id)
    {
        $request->validate([
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $chapter = Chapter::find($chapter_id);

        // dd($chapter->chapterContent->first());
        
        abort_if(!$chapter, 404);

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

        return redirect(route('chapter.edit', $chapter->id))->with('status', 'Image has been uploaded.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $comic_id, $title, $chapter)
    {
        $request->validate([
            'id.*' => 'required',
        ]);

        for ($i = 0; $i < count($request->input('id')); $i++) { 

            $chapterContent = ChapterContent::find($request->input('id')[$i]);
            $chapterContent->img_order = $i;
            $chapterContent->save();
        }

        $comic = Comic::find($comic_id);

        abort_if(
            !$chapter
            OR Str::lower(Str::of($comic->title)->replace(' ', '-')) != $title
        , 404);

        return redirect(
            route(
                'comic.chapter.edit',
                [
                    'comic_id' => $comic->id,
                    'title' => Str::lower(Str::of($comic->title)->replace(' ', '-')),
                    'chapter' => $chapter
                ]
            )
        )->with('status', 'Image reordered.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function delete($chapter_id, $chapter_content_id)
    {
        $chapterContent = ChapterContent::find($chapter_content_id);
        
        abort_if(!$chapterContent, 404);

        Storage::delete('public/' . $chapterContent->img_path);

        $chapterContent->destroy($chapter_content_id);

        return redirect(route('chapter.edit', $chapterContent->chapter->id))->with('status', 'All images have been deleted.');
    }

    protected function deleteAll($chapter_id)
    {
        $chapter = Chapter::find($chapter_id);
        
        abort_if(!$chapter, 404);

        Storage::delete('public/images/' . $chapter->comic->type . '/' . $chapter->comic->id . '/' . $chapter->chapter);

        $deleteContentAll = ChapterContent::where('chapter_id', $chapter->id)
                ->delete();

        return redirect(route('chapter.edit', $chapter->id))->with('status', 'All images have been deleted.');
    }
}
