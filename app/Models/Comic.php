<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('chapter', 'DESC');
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
