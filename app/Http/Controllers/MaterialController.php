<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Material;

class MaterialController extends Controller
{
    // Material function for coordinator
    public function index_coordinator(Request $request)
    {
        $selectedType = $request->input('matType');

        // Fetch materials with optional filtering by 'matType'
        $query = Material::query();

        if ($selectedType) {
            $query->where('matType', $selectedType);
        }

        $materials = $query->orderBy('matType')->get();

        return view('coordinator.material.index', compact('materials', 'selectedType'));
    }

    public function create_coordinator()
    {
        return view('coordinator.material.create');
    }

    public function store_coordinator(Request $request)
    {
        $request->validate([
            'matType' => 'required|in:rubric,guideline,others',
            'matTitle' => 'required|string|max:255',
            'matContent' => 'required|file|mimes:pdf,doc,docx,pptx|max:5120',
        ], [
            'matContent.max' => 'The material content cannot exceed 5mb.',
        ]);

        $file = $request->file('matContent');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('materials'), $fileName);

        Material::create([
            'matType' => $request->input('matType'),
            'matTitle' => $request->input('matTitle'),
            'matContent' => $fileName,
        ]);

        return redirect()->route('coordinators.materials.index')->with('success', 'Material created successfully!');
    }

    public function edit_coordinator($matId)
    {
        $material = Material::findOrFail($matId);
        return view('coordinator.material.edit', compact('material'));
    }

    public function update_coordinator(Request $request, $matId)
    {
        $request->validate([
            'matType' => 'required|in:rubric,guideline,others',
            'matTitle' => 'required|string|max:255',
            'matContent' => 'nullable|file|mimes:pdf,doc,docx,pptx|max:5120',
        ], [
            'matContent.max' => 'The material content cannot exceed 5mb.',
        ]);

        $material = Material::findOrFail($matId);

        if ($request->hasFile('matContent')) {
            // Handle file upload
            $file = $request->file('matContent');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('materials'), $fileName);

            // Delete old file
            if (file_exists(public_path('materials/' . $material->matContent))) {
                unlink(public_path('materials/' . $material->matContent));
            }

            $material->update([
                'matContent' => $fileName,
            ]);
        }

        $material->update([
            'matType' => $request->input('matType'),
            'matTitle' => $request->input('matTitle'),
        ]);

        return redirect()->route('coordinators.materials.index')->with('success', 'Material updated successfully!');
    }

    public function destroy_coordinator($matId)
    {
        $material = Material::findOrFail($matId);

        // Delete the file
        if (file_exists(public_path('materials/' . $material->matContent))) {
            unlink(public_path('materials/' . $material->matContent));
        }

        $material->delete();

        return redirect()->route('coordinators.materials.index')->with('success', 'Material deleted successfully!');
    }

    // Material function for student
    public function index_student(Request $request)
    {
        $selectedType = $request->input('matType');

        // Fetch materials with optional filtering by 'matType'
        $query = Material::query();

        if ($selectedType) {
            $query->where('matType', $selectedType);
        }

        $materials = $query->orderBy('matType')->get();

        return view('student.material.index', compact('materials', 'selectedType'));
    }

    // Material function for supervisor
    public function index_supervisor(Request $request)
    {
        $selectedType = $request->input('matType');

        // Fetch materials with optional filtering by 'matType'
        $query = Material::query();

        if ($selectedType) {
            $query->where('matType', $selectedType);
        }

        $materials = $query->orderBy('matType')->get();

        return view('supervisor.material.index', compact('materials', 'selectedType'));
    }

    // Material function for coach
    public function index_coach(Request $request)
    {
        $selectedType = $request->input('matType');

        // Fetch materials with optional filtering by 'matType'
        $query = Material::query();

        if ($selectedType) {
            $query->where('matType', $selectedType);
        }

        $materials = $query->orderBy('matType')->get();

        return view('coach.material.index', compact('materials', 'selectedType'));
    }
}
