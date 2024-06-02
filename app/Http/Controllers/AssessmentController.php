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
            'assessName' => 'required|string|max:255',
            'assessDescription' => 'nullable|string|max:255',
        ]);

        Assessment::create([
            'assessName' => $request->input('assessName'),
            'assessDescription' => $request->input('assessDescription'),
        ]);

        return redirect()->route('coordinators.assessments.index')->with('success', 'Assessment created successfully!');
    }

    public function edit_coordinator($assessId)
    {
        $assessment = Assessment::findOrFail($assessId);
        return view('coordinator.assessment.edit', compact('assessment'));
    }

    public function update_coordinator(Request $request, $assessId)
    {
        $request->validate([
            'assessName' => 'required|string|max:255',
            'assessDescription' => 'nullable|string|max:255',
        ]);

        $assessment = Assessment::findOrFail($assessId);
        $assessment->update([
            'assessName' => $request->input('assessName'),
            'assessDescription' => $request->input('assessDescription'),
        ]);

        return redirect()->route('coordinators.assessments.index')->with('success', 'Assessment updated successfully!');
    }

    public function destroy_coordinator($assessId)
    {
        $assessment = Assessment::findOrFail($assessId);
        $assessment->delete();

        return redirect()->route('coordinators.assessments.index')->with('success', 'Assessment deleted successfully!');
    }
}
