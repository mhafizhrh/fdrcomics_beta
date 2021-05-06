<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sitemap;
use App\Models\Comic;
use App\Models\Chapter;

class SitemapController extends Controller
{
    public function index()
    {
    	$comics = Comic::all();

    	foreach ($comics as $key) {
    		Sitemap::addTag(route('comics', $key->id), $key->updated_at, 'daily', '0.8');

    		foreach ($key->chapters as $key) {
    			Sitemap::addTag(route('read', $key->id), $key->updated_at, 'daily', '0.8');
    		}
    	}

    	return Sitemap::render();
    }
}

