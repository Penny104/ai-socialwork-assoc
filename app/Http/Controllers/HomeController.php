<?php

namespace App\Http\Controllers;

use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = News::published()->limit(5)->get();
        return view('home.index', compact('latestNews'));
    }
}
