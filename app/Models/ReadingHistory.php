<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadingHistory extends Model
{
    use HasFactory;

    protected $table = 'reading_history';

    public function chapter()
    {
    	return $this->belongsTo(Chapter::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
