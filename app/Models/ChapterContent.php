<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChapterContent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'chapter_content';

    public function chapter()
    {
    	return $this->belongsTo(Chapter::class);
    }
}
