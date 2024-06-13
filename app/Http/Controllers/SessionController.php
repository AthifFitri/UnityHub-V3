<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\Student;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index_coordinator()
    {
        $sessions = Session::all();
        return view('coordinator.session.index', compact('sessions'));
    }

    public function create_coordinator()
    {
        return view('coordinator.session.create');
    }

    public function store_coordinator(Request $request)
    {
        $request->validate([
            'sessionSemester' => 'required|string|max:10',
            'sessionYear' => 'required|string|max:255',
        ]);

        Session::create([
            'sessionSemester' => $request->input('sessionSemester'),
            'sessionYear' => $request->input('sessionYear'),
        ]);

        return redirect()->route('coordinators.sessions.index')->with('success', 'Session created successfully!');
    }

    public function edit_coordinator($sessionId)
    {
        $session = Session::findOrFail($sessionId);
        return view('coordinator.session.edit', compact('session'));
    }

    public function update_coordinator(Request $request, $sessionId)
    {
        $request->validate([
            'sessionSemester' => 'required|string|max:10',
            'sessionYear' => 'required|string|max:255',
        ]);

        $session = Session::findOrFail($sessionId);
        $session->update([
            'sessionSemester' => $request->input('sessionSemester'),
            'sessionYear' => $request->input('sessionYear'),
        ]);

        return redirect()->route('coordinators.sessions.index')->with('success', 'Session updated successfully!');
    }

    public function destroy_coordinator($sessionId)
    {
        $session = Session::findOrFail($sessionId);
        $session->delete();

        return redirect()->route('coordinators.sessions.index')->with('success', 'Session deleted successfully!');
    }

    public function studentSessions_coordinator(Request $request)
    {
        $sessions = Session::all();
        $selectedSessionId = $request->query('session');

        $students = $selectedSessionId
            ? Student::with('sessionDetails')->where('session', $selectedSessionId)->get()
            : Student::with('sessionDetails')->get();

        return view('coordinator.session.studentSession', compact('students', 'sessions', 'selectedSessionId'));
    }

    public function update_studentSessions_coordinator(Request $request)
    {
        $request->validate([
            'students' => 'required|array',
            'session' => 'required|exists:sessions,sessionId',
        ]);

        $students = Student::whereIn('stuId', $request->input('students'))->update(['session' => $request->input('session')]);

        return redirect()->route('coordinators.sessions.studentSession')->with('success', 'Student sessions updated successfully!');
    }
}
