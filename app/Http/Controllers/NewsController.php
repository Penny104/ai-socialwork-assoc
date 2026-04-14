<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::published()
            ->when(request('category'), fn($q, $cat) => $q->where('category', $cat))
            ->paginate(9);

        return view('news.index', compact('news'));
    }

    public function show(News $news)
    {
        abort_unless($news->is_published, 404);

        $news->increment('view_count');

        $related = News::published()
            ->where('id', '!=', $news->id)
            ->where('category', $news->category)
            ->limit(3)
            ->get();

        return view('news.show', compact('news', 'related'));
    }
}
