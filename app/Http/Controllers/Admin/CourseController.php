<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private function authorizeAdmin(Request $request): void
    {
        if (!$request->user()?->isAdmin()) abort(403);
    }

    public function index(Request $request)
    {
        $this->authorizeAdmin($request);

        $courses = Course::withTrashed()
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.courses.index', compact('courses'));
    }

    public function create(Request $request)
    {
        $this->authorizeAdmin($request);
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:200'],
            'description'      => ['nullable', 'string'],
            'instructor'       => ['nullable', 'string', 'max:100'],
            'location'         => ['nullable', 'string', 'max:200'],
            'start_at'         => ['required', 'date'],
            'end_at'           => ['required', 'date', 'after:start_at'],
            'max_participants' => ['required', 'integer', 'min:1'],
            'price'            => ['required', 'numeric', 'min:0'],
            'credit_hours'     => ['required', 'integer', 'min:0'],
            'status'           => ['required', 'in:draft,open,closed,cancelled'],
        ]);

        $validated['user_id'] = $request->user()->id;

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', '課程已建立。');
    }

    public function edit(Request $request, Course $course)
    {
        $this->authorizeAdmin($request);
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeAdmin($request);

        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:200'],
            'description'      => ['nullable', 'string'],
            'instructor'       => ['nullable', 'string', 'max:100'],
            'location'         => ['nullable', 'string', 'max:200'],
            'start_at'         => ['required', 'date'],
            'end_at'           => ['required', 'date', 'after:start_at'],
            'max_participants' => ['required', 'integer', 'min:1'],
            'price'            => ['required', 'numeric', 'min:0'],
            'credit_hours'     => ['required', 'integer', 'min:0'],
            'status'           => ['required', 'in:draft,open,closed,cancelled'],
            'cancel_reason'    => ['nullable', 'string'],
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', '課程已更新。');
    }

    public function destroy(Request $request, Course $course)
    {
        $this->authorizeAdmin($request);
        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', '課程已刪除。');
    }
}
