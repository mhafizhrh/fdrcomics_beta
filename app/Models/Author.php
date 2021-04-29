<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function comics()
    {
    	return $this->belongsTo(Comic::class);
    }

    public function totalComics()
    {
    	return $this->hasMany(Comic::class)->count();
    }
}
