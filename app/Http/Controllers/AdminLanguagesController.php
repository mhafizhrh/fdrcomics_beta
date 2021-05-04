<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;

class AdminLanguagesController extends Controller
{
    protected function index()
    {
    	$languages = Language::all();
    	return view('admin.languages.index', compact('languages'));
    }

    protected function new()
    {
    	return view('admin.languages.new');
    }

    protected function store(Request $request)
    {
    	$request->validate([
    		'flag_icon_code' => 'required',
    		'language' => 'required',
    	]);

    	$languages = new Language();
    	$languages->flag_icon_code = $request->input('flag_icon_code');
    	$languages->language = $request->input('language');
    	$languages->save();

    	return redirect()->route('admin.languages.new')->with('success', 'New languages have been added.');
    }
}
