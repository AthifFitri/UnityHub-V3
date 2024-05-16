<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\Industry;
use App\Models\Student;
use App\Models\UniversityStaff;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // Student Profile
    public function index_student()
    {
        $student = auth('student')->user();
        return view('student.profile.index', compact('student'));
    }

    public function edit_student()
    {
        $student = auth()->user();
        return view('student.profile.edit', compact('student'));
    }

    public function update_student(Request $request)
    {
        // Retrieve the authenticated student
        $student = auth('student')->user();

        // Check if the authenticated user is indeed an instance of Student
        if (!$student instanceof Student) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Validate the request data
        $request->validate([
            'stuName' => 'required|string|max:255',
            'stuPhone' => 'required|string|max:20',
        ]);

        // Update the student's information
        $student->update([
            'stuName' => $request->stuName,
            'stuPhone' => $request->stuPhone,
        ]);

        return redirect()->route('students.profile.index')->with('success', 'Profile updated successfully.');
    }

    // Supervisor Profile
    public function index_supervisor()
    {
        $supervisor = auth('staff')->user();
        $position = $supervisor->position->posName;
        return view('supervisor.profile.index', compact('supervisor', 'position'));
    }

    public function edit_supervisor()
    {
        $supervisor = auth()->user();
        return view('supervisor.profile.edit', compact('supervisor'));
    }

    public function update_supervisor(Request $request)
    {
        // Retrieve the authenticated supervisor
        $supervisor = auth('staff')->user();

        // Check if the authenticated user is indeed an instance of Supervisor
        if (!$supervisor instanceof UniversityStaff) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Validate the request data
        $request->validate([
            'staffName' => 'required|string|max:255',
            'staffPhone' => 'required|string|max:20',
        ]);

        // Update the supervisor's information
        $supervisor->update([
            'staffName' => $request->staffName,
            'staffPhone' => $request->staffPhone,
        ]);

        return redirect()->route('supervisors.profile.index')->with('success', 'Profile updated successfully.');
    }

    // Coordinator Profile
    public function index_coordinator()
    {
        $coordinator = auth('staff')->user();
        $position = $coordinator->position->posName;
        return view('coordinator.profile.index', compact('coordinator', 'position'));
    }

    public function edit_coordinator()
    {
        $coordinator = auth()->user();
        return view('coordinator.profile.edit', compact('coordinator'));
    }

    public function update_coordinator(Request $request)
    {
        // Retrieve the authenticated coordinator
        $coordinator = auth('staff')->user();

        // Check if the authenticated user is indeed an instance of Coordinator
        if (!$coordinator instanceof UniversityStaff) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Validate the request data
        $request->validate([
            'staffName' => 'required|string|max:255',
            'staffPhone' => 'required|string|max:20',
        ]);

        // Update the coordinator's information
        $coordinator->update([
            'staffName' => $request->staffName,
            'staffPhone' => $request->staffPhone,
        ]);

        return redirect()->route('coordinators.profile.index')->with('success', 'Profile updated successfully.');
    }

    // Hop Profile
    public function index_hop()
    {
        $hop = auth('staff')->user();
        $position = $hop->position->posName;
        return view('hop.profile.index', compact('hop', 'position'));
    }

    public function edit_hop()
    {
        $hop = auth()->user();
        return view('hop.profile.edit', compact('hop'));
    }

    public function update_hop(Request $request)
    {
        // Retrieve the authenticated Hop
        $hop = auth('staff')->user();

        // Check if the authenticated user is indeed an instance of Hop
        if (!$hop instanceof UniversityStaff) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Validate the request data
        $request->validate([
            'staffName' => 'required|string|max:255',
            'staffPhone' => 'required|string|max:20',
        ]);

        // Update the hop's information
        $hop->update([
            'staffName' => $request->staffName,
            'staffPhone' => $request->staffPhone,
        ]);

        return redirect()->route('hop.profile.index')->with('success', 'Profile updated successfully.');
    }

    // Coach Profile
    public function index_coach()
    {
        $coach = auth('coach')->user();
        return view('coach.profile.index', compact('coach'));
    }

    public function edit_coach()
    {
        $coach = auth()->user();
        $industries = Industry::all();
        return view('coach.profile.edit', compact('coach', 'industries'));
    }

    public function update_coach(Request $request)
    {
        // Retrieve the authenticated student
        $coach = auth('coach')->user();

        // Check if the authenticated user is indeed an instance of Student
        if (!$coach instanceof Coach) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Validate the request data
        $request->validate([
            'coachName' => 'required|string|max:255',
            'coachPhone' => 'required|string|max:20',
        ]);

        // Update the coach's information
        $coach->update([
            'coachName' => $request->coachName,
            'coachPhone' => $request->coachPhone,
            'indId' => $request->indId,
        ]);

        return redirect()->route('coaches.profile.index')->with('success', 'Profile updated successfully.');
    }
}
