<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function comicGenre()
    {
    	return $this->belongsTo(ComicGenre::class);
    }

    public function totalGenreUsed()
    {
    	return $this->hasMany(ComicGenre::class, 'genre_id');
    }

    public function totalComics()
    {
        return $this->hasMany(ComicGenre::class, 'genre_id')->count();
    }
}
