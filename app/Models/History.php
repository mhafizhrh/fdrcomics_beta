<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'history';

    public function chapter()
    {
    	return $this->belongsTo(Chapter::class, 'chapter_id', 'id');
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
