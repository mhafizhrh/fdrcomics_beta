<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitorCount extends Model
{
    use HasFactory;

    public function chapter()
    {
    	return $this->belongsTo(Chapter::class);
    }

    public function totalVisitor()
    {
    	$from_date = date('Y-m-d', strtotime('-1 week')) . ' 00:00:00';
    	$to_date = date('Y-m-d') . ' 23:59:59';

    	return $this->hasMany(VisitorCount::class, 'chapter_id', 'chapter_id')
       			->whereBetween('updated_at', [$from_date, $to_date])
       			->where('chapter_id', $this->chapter_id)
       			->sum('count');
    }
}
