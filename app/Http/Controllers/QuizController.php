<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index_coordinator()
    {
        $students = Student::all();
        $courses = Course::whereIn('courseCode', ['CSM4908', 'CSM4928'])->get();

        return view('coordinator.quiz.index', compact('students', 'courses'));
    }

    public function edit_coordinator($stuId, $courseId)
    {
        $student = Student::findOrFail($stuId);
        $course = Course::findOrFail($courseId);
        $quiz = Quiz::where('stuId', $stuId)->where('courseId', $courseId)->first();
        return view('coordinator.quiz.edit', compact('student', 'course', 'quiz'));
    }

    public function update_coordinator(Request $request, $stuId, $courseId)
    {
        $validatedData = $request->validate([
            'score' => 'required|numeric|min:0|max:10',
        ]);

        Quiz::updateOrCreate(
            ['stuId' => $stuId, 'courseId' => $courseId],
            ['score' => $validatedData['score']]
        );

        return redirect()->route('coordinators.quizes.index', $stuId)->with('success', 'Quiz score updated successfully.');
    }

    public function index_student()
    {
        $student = Auth::user();
        $courses = Course::whereIn('courseCode', ['CSM4908', 'CSM4928'])->get();

        return view('student.quiz.index', compact('student', 'courses'));
    }
}
