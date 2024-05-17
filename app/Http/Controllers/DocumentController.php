<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index_student()
    {
        $student = Auth::user();
        $documents = Document::where('stuId', $student->stuId)->get();
        $documentTypes = $this->getDocumentTypes();
        return view('student.documentation.index', compact('documents', 'documentTypes'));
    }

    private function getDocumentTypes()
    {
        $documentTypes = [
            'li01_report_duty_confirmation' => 'LI01 - Report Duty Confirmation',
            'li02_report_duty_confirmation' => 'LI02 - Planning Form',
            'li03_report_duty_confirmation' => 'LI03 - Progress Report',
            'csm4908_project_demo_slide' => 'CSM4908 - Project Demo Slide',
            'csm4908_final_project_report' => 'CSM4908 - Final Project Report',
            'csm4918_final_project_report' => 'CSM4918 - Final Project Report',
            'csm4928_project_demo_slide' => 'CSM4928 - Project Demo Slide',
            'csm4928_final_project_report' => 'CSM4928 - Final Project Report',
            'csm4938_final_project_report' => 'CSM4938 - Final Project Report',
        ];

        return $documentTypes;
    }

    public function create_student()
    {
        $student = Auth::user();
        $availableDocumentTypes = $this->getAvailableDocumentTypes($student);
        return view('student.documentation.create', compact('availableDocumentTypes'));
    }

    private function getAvailableDocumentTypes($student)
    {
        $documentTypes = [
            'li01_report_duty_confirmation' => 'LI01 - Report Duty Confirmation',
            'li02_report_duty_confirmation' => 'LI02 - Planning Form',
            'li03_report_duty_confirmation' => 'LI03 - Progress Report',
            'csm4908_project_demo_slide' => 'CSM4908 - Project Demo Slide',
            'csm4908_final_project_report' => 'CSM4908 - Final Project Report',
            'csm4918_final_project_report' => 'CSM4918 - Final Project Report',
            'csm4928_project_demo_slide' => 'CSM4928 - Project Demo Slide',
            'csm4928_final_project_report' => 'CSM4928 - Final Project Report',
            'csm4938_final_project_report' => 'CSM4938 - Final Project Report',
        ];

        // Filter out document types that are already uploaded by the student
        $uploadedDocumentTypes = Document::where('stuId', $student->stuId)->pluck('docType')->toArray();
        $availableDocumentTypes = array_diff_key($documentTypes, array_flip($uploadedDocumentTypes));

        return $availableDocumentTypes;
    }


    public function store_student(Request $request)
    {
        $request->validate([
            'docType' => 'required',
            'docTitle' => 'required|string|max:255',
            'docContent' => 'required|file|mimes:pdf,doc,docx,pptx|max:5120',
        ], [
            'docContent.max' => 'The document content cannot exceed 5mb.',
        ]);

        $file = $request->file('docContent');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('documents'), $fileName);

        // Get the authenticated student
        $student = Auth::user();

        Document::create([
            'stuId' => $student->stuId,
            'docType' => $request->input('docType'),
            'docTitle' => $request->input('docTitle'),
            'docContent' => $fileName,
        ]);

        return redirect()->route('student.documents.index')->with('success', 'Document uploaded successfully!');
    }

    public function edit_student($docId)
    {
        $document = Document::findOrFail($docId);
        $documentTypes = $this->getDocumentTypes();
        return view('student.documentation.edit', compact('document', 'documentTypes'));
    }


    public function update_student(Request $request, $docId)
    {
        $request->validate([
            'docTitle' => 'required|string|max:255',
            'docContent' => 'nullable|file|mimes:pdf,doc,docx,pptx|max:5120',
        ], [
            'docContent.max' => 'The document content cannot exceed 5mb.',
        ]);

        $document = Document::findOrFail($docId);

        if ($request->hasFile('docContent')) {
            // Handle file upload
            $file = $request->file('docContent');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('documents'), $fileName);

            // Delete old file
            if (file_exists(public_path('documents/' . $document->docContent))) {
                unlink(public_path('documents/' . $document->docContent));
            }

            $document->update([
                'docContent' => $fileName,
            ]);
        }

        $document->update([
            'docTitle' => $request->input('docTitle'),
        ]);

        return redirect()->route('student.documents.index')->with('success', 'Document updated successfully!');
    }

    public function destroy_student($docId)
    {
        $document = Document::findOrFail($docId);

        // Delete the file
        if (file_exists(public_path('documents/' . $document->docContent))) {
            unlink(public_path('documents/' . $document->docContent));
        }

        $document->delete();

        return redirect()->route('student.documents.index')->with('success', 'Document deleted successfully!');
    }
}
