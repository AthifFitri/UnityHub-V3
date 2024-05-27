<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Evaluation;
use App\Models\EvaluationCriteria;
use Illuminate\Http\Request;

class EvaluateController extends Controller
{
    public function index_coordinator()
    {
        // Fetch all courses
        $courses = Course::all();

        // Loop through courses and fetch evaluations for each course
        foreach ($courses as $course) {
            $course->evaluations = Evaluation::where('courseId', $course->courseId)->orderBy('plo')->get();
        }

        return view('coordinator.evaluation.index', compact('courses'));
    }

    public function create_university_coordinator()
    {
        $courses = Course::all();
        return view('coordinator.evaluation.createUniversity', compact('courses'));
    }

    public function create_industry_coordinator()
    {
        $courses = Course::all();
        return view('coordinator.evaluation.createIndustry', compact('courses'));
    }

    public function store_coordinator(Request $request)
    {
        $request->validate([
            'evaType' => 'required|in:University,Industry',
            'course' => 'required|exists:courses,courseId',
            'plo' => 'required|integer|min:1|max:9',
            'criteria.*' => 'required|string',
            'weight.*' => 'required|numeric|min:0|max:10',
        ]);

        $evaluation = Evaluation::create([
            'evaType' => $request->input('evaType'),
            'courseId' => $request->input('course'),
            'plo' => $request->input('plo'),
        ]);

        $criteria = $request->input('criteria');
        $weights = $request->input('weight');

        foreach ($criteria as $index => $criterion) {
            EvaluationCriteria::create([
                'evaId' => $evaluation->evaId,
                'criteria' => $criterion,
                'weight' => $weights[$index],
            ]);
        }

        return redirect()->route('coordinators.evaluations.index')->with('success', 'Evaluation created successfully');
    }

    public function ploDetails_coordinator($evaId)
    {
        // Load the evaluation along with its criteria and course
        $evaluation = Evaluation::with(['criteria', 'course'])->findOrFail($evaId);

        return view('coordinator.evaluation.ploDetails', compact('evaluation'));
    }

    public function editCriteria_coordinator($evaCriId)
    {
        $criteria = EvaluationCriteria::findOrFail($evaCriId);
        return view('coordinator.evaluation.editCriteria', compact('criteria'));
    }

    public function updateCriteria_coordinator(Request $request, $evaCriId)
    {
        $criteria = EvaluationCriteria::findOrFail($evaCriId);

        $request->validate([
            'criteria' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0|max:10',
        ]);

        $criteria->criteria = $request->input('criteria');
        $criteria->weight = $request->input('weight');
        $criteria->save();

        return redirect()->route('coordinators.evaluations.ploDetails', $criteria->evaId)
            ->with('success', 'Criteria updated successfully.');
    }

    public function addCriteria_coordinator($evaId)
    {
        $evaluation = Evaluation::with('criteria')->findOrFail($evaId);
        return view('coordinator.evaluation.addCriteria', compact('evaluation'));
    }

    public function storeCriteria_coordinator(Request $request, $evaId)
    {
        $request->validate([
            'criteria.*' => 'required|string|max:255',
            'weight.*' => 'required|numeric|min:0|max:10',
        ]);

        $evaluation = Evaluation::findOrFail($evaId);

        // Loop through new criteria and store them
        if ($request->has('criteria')) {
            foreach ($request->criteria as $index => $criteriaText) {
                EvaluationCriteria::create([
                    'criteria' => $criteriaText,
                    'weight' => $request->weight[$index],
                    'evaId' => $evaId,
                ]);
            }
        }

        return redirect()->route('coordinators.evaluations.ploDetails', $evaId)
            ->with('success', 'Criteria added successfully.');
    }

    public function destroyCriteria_coordinator($evaCriId)
    {
        $criteria = EvaluationCriteria::findOrFail($evaCriId);
        $criteria->delete();
        return redirect()->back()->with('success', 'Criteria deleted successfully');
    }
}
