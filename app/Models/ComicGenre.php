<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComicGenre extends Model
{
    use HasFactory;

    public function comic()
    {
    	return $this->belongsTo(Comic::class);
    }

    public function genre()
    {
    	return $this->belongsTo(Genre::class);
    }

    public function totalComicEachGenre()
    {
        $this->hasMany(Comic::class)->count();
    }
}
