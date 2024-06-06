<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use Illuminate\Http\Request;

class AssessmentController extends Controller
{
    public function index_coordinator()
    {
        $assessments = Assessment::all();
        return view('coordinator.assessment.index', compact('assessments'));
    }

    public function create_coordinator()
    {
        return view('coordinator.assessment.create');
    }

    public function store_coordinator(Request $request)
    {
        $request->validate([
            'assessmentName' => 'required|string|max:255',
            'assessmentDescription' => 'nullable|string|max:255',
        ]);

        Assessment::create([
            'assessmentName' => $request->input('assessmentName'),
            'assessmentDescription' => $request->input('assessmentDescription'),
        ]);

        return redirect()->route('coordinators.assessments.index')->with('success', 'Assessment created successfully!');
    }

    public function edit_coordinator($assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);
        return view('coordinator.assessment.edit', compact('assessment'));
    }

    public function update_coordinator(Request $request, $assessmentId)
    {
        $request->validate([
            'assessmentName' => 'required|string|max:255',
            'assessmentDescription' => 'nullable|string|max:255',
        ]);

        $assessment = Assessment::findOrFail($assessmentId);
        $assessment->update([
            'assessmentName' => $request->input('assessmentName'),
            'assessmentDescription' => $request->input('assessmentDescription'),
        ]);

        return redirect()->route('coordinators.assessments.index')->with('success', 'Assessment updated successfully!');
    }

    public function destroy_coordinator($assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);
        $assessment->delete();

        return redirect()->route('coordinators.assessments.index')->with('success', 'Assessment deleted successfully!');
    }
}
