<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResumeController extends Controller
{
    public function index_coach()
    {
        $coach = Auth::user();
        return view('coach.resume.index', compact('coach'));
    }

    public function create_coach()
    {
        return view('coach.resume.create');
    }

    public function store_coach(Request $request)
    {
        $request->validate([
            'coachResume' => 'required|mimes:pdf,doc,docx,pptx|max:5120',
        ], [
            'coachResume.max' => 'The resume cannot exceed 5mb.',
        ]);

        $file = $request->file('coachResume');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('resume'), $fileName);

        $coach = Auth::user();
        
        Coach::where('coachId', $coach->coachId)->update([
            'coachResume' => $fileName,
        ]);

        return redirect()->route('coaches.resume.index')->with('success', 'Resume uploaded successfully.');
    }

    public function edit_coach($id)
    {
        $coach = Coach::findOrFail($id);
        $coach = Auth::user();
        return view('coach.resume.edit', compact('coach'));
    }

    public function update_coach(Request $request, $id)
    {
        $request->validate([
            'coachResume' => 'nullable|mimes:pdf,doc,docx,pptx|max:5120',
        ], [
            'coachResume.max' => 'The resume cannot exceed 5mb.',
        ]);

        $coach = Coach::findOrFail($id);

        if ($request->hasFile('coachResume')) {
            // Handle file upload
            $file = $request->file('coachResume');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('resume'), $fileName);

            // Delete old file
            if (file_exists(public_path('resume/' . $coach->coachResume))) {
                unlink(public_path('resume/' . $coach->coachResume));
            }

            Coach::where('coachId', $coach->coachId)->update([
                'coachResume' => $fileName,
            ]);
        }

        return redirect()->route('coaches.resume.index')->with('success', 'Resume updated successfully.');
    }

    public function destroy_coach($id)
    {
        $coach = Coach::findOrFail($id);

        // Delete the file
        if (file_exists(public_path('resume/' . $coach->coachResume))) {
            unlink(public_path('resume/' . $coach->coachResume));
        }

        Coach::where('coachId', $coach->coachId)->update([
            'coachResume' => null,
        ]);

        return redirect()->route('coaches.resume.index')->with('success', 'Resume deleted successfully.');
    }
}
