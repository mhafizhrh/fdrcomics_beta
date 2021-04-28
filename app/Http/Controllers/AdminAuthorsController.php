<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AdminAuthorsController extends Controller
{
    protected function index()
    {
    	$authors = Author::all();
    	return view('admin.authors.index', compact('authors'));
    }

    protected function new()
    {
    	return view('admin.authors.new');
    }

    protected function store(Request $request)
    {
    	$request->validate([
    		'name' => 'required',
    	]);

    	$authors = new Author();
    	$authors->name = $request->input('name');
    	$authors->save();

    	return redirect()->route('admin.authors.new')->with('success', 'New Author has been added.');
    }
}
