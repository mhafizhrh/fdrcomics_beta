<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapter extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function languages()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

    public function comic()
    {
    	return $this->belongsTo(Comic::class, 'comic_id', 'id');
    }

    public function dataComic()
    {
        return $this->belongsTo(Comic::class, 'comic_id', 'id')->first();
    }

    public function comicGenre()
    {
    	return $this->hasMany(ComicGenre::class);
    }

    public function chapterContent()
    {
    	return $this->hasMany(ChapterContent::class)->orderBy('img_order', 'ASC');
    }

    public function comments()
    {
    	return $this->hasMany(Comment::class)->orderBy('created_at', 'DESC');
    }

    public function visitorCount()
    {
    	return $this->hasOne(VisitorCount::class);
    }

    public function nextChapter()
    {
        return Chapter::where('language', $this->language)
                ->where('comic_id', $this->comic_id)
                ->where('chapter', '>', $this->chapter)->orderBy('chapter')->limit(1)->first();
    }

    public function previousChapter()
    {
    	return Chapter::where('language', $this->language)
                ->where('comic_id', $this->comic_id)
                ->where('chapter', '<', $this->chapter)->orderBy('chapter')->limit(1)->first();
    }


    // public function comic()
    // {
    // 	return $this->hasOne(Comic::class, 'id', 'comic_id');
    // }

    // public function totalVisitor()
    // {
    // 	return $this->hasMany(VisitorCount::class);
    // }
}
