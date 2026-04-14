<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private function authorizeAdmin(Request $request): void
    {
        if (!$request->user()?->isAdmin()) abort(403);
    }

    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $news = News::withTrashed()
            ->with('author')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.news.index', compact('news'));
    }

    public function create(Request $request)
    {
        $this->authorizeAdmin($request);
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:200'],
            'category'     => ['required', 'in:announcement,activity,welfare,other'],
            'excerpt'      => ['nullable', 'string', 'max:300'],
            'content'      => ['required', 'string'],
            'is_published' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $validated['user_id']      = $request->user()->id;
        $validated['is_published'] = $request->boolean('is_published');
        if ($validated['is_published'] && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        News::create($validated);

        return redirect()->route('admin.news.index')->with('success', '消息已建立。');
    }

    public function edit(Request $request, News $news)
    {
        $this->authorizeAdmin($request);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:200'],
            'category'     => ['required', 'in:announcement,activity,welfare,other'],
            'excerpt'      => ['nullable', 'string', 'max:300'],
            'content'      => ['required', 'string'],
            'is_published' => ['sometimes', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        if ($validated['is_published'] && empty($news->published_at) && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', '消息已更新。');
    }

    public function destroy(Request $request, News $news)
    {
        $this->authorizeAdmin($request);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', '消息已刪除。');
    }
}
