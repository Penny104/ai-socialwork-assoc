<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::open()->paginate(9);

        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        abort_unless($course->status === 'open', 404);

        return view('courses.show', compact('course'));
    }
}
