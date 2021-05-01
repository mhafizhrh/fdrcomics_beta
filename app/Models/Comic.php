<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Comic extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function authors()
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }

    public function languages()
    {
        return $this->hasOne(Language::class, 'id', 'language_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class)->selectRaw('SUM(rating)/COUNT(*) AS rating, COUNT(*) AS users')->first();
    }
    
    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('updated_at', 'DESC');
    }

    public function bookmark()
    {
        return $this->hasOne(Bookmark::class)->where('user_id', Auth::user()->id);
    }

    public function userBookmarks()
    {
        // return $this->belongsToMany(Comic::class, 'bookmarkss', 'comic_id', 'comic_id')->where('bookmarks.user_id', Auth::user()->id);
        return $this->hasMany(Bookmark::class, 'comic_id')->where('user_id', Auth::user()->id);
    }

    public function chapterEachLang($language = null)
    {
        return $this->hasMany(Chapter::class)->where('language', $language)->orderByRaw('created_at DESC, chapter DESC');
    }

    public function chapter()
    {
    	return $this->hasMany(Chapter::class)->orderByRaw('created_at DESC, chapter DESC');
    }

    public function comicGenre()
    {
    	return $this->hasMany(ComicGenre::class);
    }

    public function totalChapter()
    {
    	return $this->hasMany(Chapter::class, 'comic_id')->count();
    }

    public function language()
    {
    	return $this->hasMany(Chapter::class)->select('language')->distinct();
    }

    // public function genre()
    // {
    // 	return $this->hasMany(Genre::class);
    // }
}
