<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ReadingHistory;

class UserController extends Controller
{
    protected function history()
    {
    	$history = ReadingHistory::where('user_id', Auth::user()->id)->get();

    	return view('user.history', compact('history'));
    }
}
