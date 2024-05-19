<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Student;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index_coordinator()
    {
        $students = Student::all();
        return view('coordinator.quiz.index', compact('students'));
    }

    public function show_student_score($id)
    {
        $student = Student::findOrFail($id);
        $courses = ['CSM4908', 'CSM4928'];
        $quizzes = Quiz::where('stuId', $id)->whereIn('course', $courses)->get()->keyBy('course');

        // Ensure all courses are included
        $courseScores = [];
        foreach ($courses as $course) {
            $courseScores[] = [
                'course' => $course,
                'score' => $quizzes->has($course) ? $quizzes[$course]->score : 0,
            ];
        }

        return view('coordinator.quiz.score', compact('student', 'courseScores'));
    }

    public function edit_coordinator($id, $course)
    {
        $student = Student::findOrFail($id);
        $quiz = Quiz::where('stuId', $id)->where('course', $course)->first();
        return view('coordinator.quiz.edit', compact('student', 'course', 'quiz'));
    }

    public function update_coordinator(Request $request, $id, $course)
    {
        $validatedData = $request->validate([
            'score' => 'required|numeric|min:0|max:10',
        ]);

        $quiz = Quiz::updateOrCreate(
            ['stuId' => $id, 'course' => $course],
            ['score' => $validatedData['score']]
        );

        return redirect()->route('coordinators.quizes.score', $id)->with('success', 'Quiz score updated successfully.');
    }
}
