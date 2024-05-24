<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index_coordinator()
    {
        $courses = Course::all();
        return view('coordinator.course.index', compact('courses'));
    }

    public function create_coordinator()
    {
        return view('coordinator.course.create');
    }

    public function store_coordinator(Request $request)
    {
        $request->validate([
            'courseCode' => 'required|string|max:10',
            'courseName' => 'required|string|max:255',
        ]);

        Course::create([
            'courseCode' => $request->input('courseCode'),
            'courseName' => $request->input('courseName'),
        ]);

        return redirect()->route('coordinators.courses.index')->with('success', 'Course created successfully!');
    }

    public function edit_coordinator($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('coordinator.course.edit', compact('course'));
    }

    public function update_coordinator(Request $request, $courseId)
    {
        $request->validate([
            'courseCode' => 'required|string|max:10',
            'courseName' => 'required|string|max:255',
        ]);

        $course = Course::findOrFail($courseId);
        $course->update([
            'courseCode' => $request->input('courseCode'),
            'courseName' => $request->input('courseName'),
        ]);

        return redirect()->route('coordinators.courses.index')->with('success', 'Course updated successfully!');
    }

    public function destroy_coordinator($courseId)
    {
        $course = Course::findOrFail($courseId);
        $course->delete();

        return redirect()->route('coordinators.courses.index')->with('success', 'Course deleted successfully!');
    }
}
