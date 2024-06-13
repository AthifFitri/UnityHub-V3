<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Session;
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
        $sessions = Session::all();
        return view('coordinator.course.create', compact('sessions'));
    }

    public function store_coordinator(Request $request)
    {
        $request->validate([
            'session' => 'required|exists:sessions,sessionId',
            'courseCode' => 'required|string|max:10',
            'courseName' => 'required|string|max:255',
        ]);

        Course::create([
            'sessionId' => $request->input('session'),
            'courseCode' => $request->input('courseCode'),
            'courseName' => $request->input('courseName'),
        ]);

        return redirect()->route('coordinators.courses.index')->with('success', 'Course created successfully!');
    }

    public function edit_coordinator($courseId)
    {
        $course = Course::with('session')->findOrFail($courseId);
        $sessions = Session::all();
        return view('coordinator.course.edit', compact('course', 'sessions'));
    }

    public function update_coordinator(Request $request, $courseId)
    {
        $request->validate([
            'session' => 'required|exists:sessions,sessionId',
            'courseCode' => 'required|string|max:10',
            'courseName' => 'required|string|max:255',
        ]);

        $course = Course::findOrFail($courseId);
        $course->update([
            'sessionId' => $request->input('session'),
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
