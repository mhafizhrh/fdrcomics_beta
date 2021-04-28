<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    public function comics()
    {
    	return $this->belongsTo(Comic::class);
    }

    public function totalComics()
    {
    	return $this->hasMany(Comic::class)->count();
    }
}
