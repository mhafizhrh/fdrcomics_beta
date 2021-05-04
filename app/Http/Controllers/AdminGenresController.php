<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;
use App\Models\Genre;

class AdminGenresController extends Controller
{
    protected function index()
    {
    	$genres = Genre::all();
    	return view('admin.genres.index', compact('genres'));
    }

    protected function new()
    {
    	return view('admin.genres.new');
    }

    protected function store(Request $request)
    {
    	$request->validate([
    		'name' => 'required|unique:genres',
    	]);

    	$genres = new Genre();
    	$genres->name = $request->input('name');
    	$genres->save();

    	return redirect()->route('admin.genres.new')->with('success', 'New Genre has been added.');
    }
}
