<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    protected function dashboard()
    {
    	return view('admin.dashboard');
    }
}
