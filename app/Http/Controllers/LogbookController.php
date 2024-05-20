<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Logbook;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    // Student functions
    public function index_student()
    {
        $student = Auth::user();
        $entries = Logbook::where('stuId', $student->stuId)->get();
        return view('student.logbook.index', compact('entries'));
    }

    public function create_student()
    {
        return view('student.logbook.create');
    }

    public function store_student(Request $request)
    {
        $data = $request->validate([
            'week' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,public_holiday,annual_leave,medical_leave',
            'proof' => 'nullable|mimes:pdf,doc,docx,pptx|max:5120',
            'daily_activities' => 'required',
            'knowledge_skill' => 'required',
            'problem_comment' => 'required',
            'status' => 'required|in:pending,approved',
        ], [
            'proof.max' => 'The resume cannot exceed 5mb.',
        ]);

        // Get the authenticated student
        $student = Auth::user();

        // Encode attendance array to JSON
        $attendance = json_encode($data['attendance']);

        $fileName = null;
        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('proof'), $fileName);
        }

        // $file = $request->file('proof');
        // $fileName = time() . '.' . $file->getClientOriginalExtension();
        // $file->move(public_path('proof'), $fileName);

        // Create a new Logbook instance
        $logbook = new Logbook([
            'stuId' => $student->stuId,
            'week' => $data['week'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'attendance' => $attendance,
            'proof' => $fileName,
            'daily_activities' => $data['daily_activities'],
            'knowledge_skill' => $data['knowledge_skill'],
            'problem_comment' => $data['problem_comment'],
            'status' => $data['status'],
        ]);

        // Save the Logbook instance to the database
        $logbook->save();

        // Redirect with success message
        return redirect()->route('student.logbooks.index')->with('success', 'Logbook created successfully.');
    }

    public function edit_student($logId)
    {
        $entry = Logbook::findOrFail($logId);
        return view('student.logbook.edit', compact('entry'));
    }

    public function update_student(Request $request, $logId)
    {
        $data = $request->validate([
            'week' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'attendance' => 'required|array',
            'attendance.*' => 'required|in:present,public_holiday,annual_leave,medical_leave',
            'proof' => 'nullable|mimes:pdf,doc,docx,pptx|max:5120',
            'daily_activities' => 'required',
            'knowledge_skill' => 'required',
            'problem_comment' => 'required',
            'status' => 'required|in:pending,approved',
        ], [
            'proof.max' => 'The resume cannot exceed 5mb.',
        ]);

        // Encode attendance array to JSON
        $attendance = json_encode($data['attendance']);

        // Find the Logbook instance by logId
        $entry = Logbook::findOrFail($logId);

        if ($request->hasFile('proof')) {
            // Handle file upload
            $file = $request->file('proof');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('proof'), $fileName);

            // Delete old file
            if (file_exists(public_path('proof/' . $entry->proof))) {
                unlink(public_path('proof/' . $entry->proof));
            }

            Logbook::where('stuId', $entry->stuId)->update([
                'proof' => $fileName,
            ]);
        }

        // Update all fields
        $entry->week = $data['week'];
        $entry->start_date = $data['start_date'];
        $entry->end_date = $data['end_date'];
        $entry->attendance = $attendance;
        $entry->daily_activities = $data['daily_activities'];
        $entry->knowledge_skill = $data['knowledge_skill'];
        $entry->problem_comment = $data['problem_comment'];
        $entry->status = $data['status'];

        // Save the updated Logbook instance
        $entry->save();

        // Redirect with success message
        return redirect()->route('student.logbooks.index')->with('success', 'Logbook updated successfully.');
    }

    // Coach functions
    public function index_coach(Request $request)
    {
        // Get the authenticated coach
        $coach = Auth::user();

        // Retrieve all students associated with the coach
        $students = $coach->students;

        // Initialize entries to an empty collection
        $entries = collect();

        // Check if a student is selected
        if ($request->has('stuId')) {
            // Get the selected student ID
            $selectedStudentId = $request->stuId;

            // Check if the selected student is associated with the coach
            if ($students->where('stuId', $selectedStudentId)->isNotEmpty()) {
                // Retrieve logbook entries for the selected student
                $entries = Logbook::where('stuId', $selectedStudentId)->get();
            }
        }

        return view('coach.logbook.index', compact('entries', 'students'));
    }

    public function update_coach(Request $request, $logId)
    {
        $logbook = Logbook::findOrFail($logId);
        $logbook->update(['status' => $request->status]);

        // Get the student ID associated with the updated logbook
        $studentId = $logbook->stuId;

        // Redirect to the logbook index page of the coach
        return redirect()->route('coaches.logbooks.index', ['stuId' => $studentId])
            ->with('success', 'Logbook status updated successfully.');
    }
}
