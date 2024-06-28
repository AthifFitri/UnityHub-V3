<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentInformationController extends Controller
{
    public function index_coordinator()
    {
        $students = Student::all();
        return view('coordinator.studentInformation.index', compact('students'));
    }

    public function assignCoach_coordinator($stuId)
    {
        $student = Student::findOrFail($stuId);
        $coaches = Coach::all();
        return view('coordinator.studentInformation.assignCoach', compact('student', 'coaches'));
    }

    public function updateCoach_coordinator(Request $request, $stuId)
    {
        $student = Student::findOrFail($stuId);
        $student->coachId = $request->input('coachId');
        $student->save();

        return redirect()->route('coordinators.infos.index')->with('success', 'Coach assigned successfully.');
    }
}
