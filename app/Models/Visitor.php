<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function chapter()
    {
    	return $this->belongsTo(Chapter::class, 'chapter_id', 'id');
    }

    public function popularComics()
    {
    	return $this->hasMany(Chapter::class);
    }
}
