<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    public function comic()
    {
    	return $this->belongsTo(Comic::class, 'comic_id', 'id');
    }
}
