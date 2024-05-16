<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coach;
use App\Models\Industry;
use App\Mail\CoachRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $selectedIndustry = $request->input('industry');

        // Fetch coaches with their related industry
        $query = Coach::with('industry');

        // If a specific industry is selected, filter by that industry
        if ($selectedIndustry) {
            $query->where('indId', $selectedIndustry);
        }

        // Get the coaches based on the applied filters
        $coaches = $query->get();

        // Fetch all industries for the filter dropdown
        $industries = Industry::all();

        return view('coordinator.register.index', compact('coaches', 'industries', 'selectedIndustry'));
    }

    public function create()
    {
        $industries = Industry::all();
        return view('coordinator.register.create', compact('industries'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'coachName' => 'required|string|max:255',
            'coachPhone' => 'required|string|max:20',
            'coachEmail' => 'required|email|unique:coach',
            'coachPassword' => 'required|string|min:6',
            'indId' => 'required|exists:industry,indId',
        ], [
            'coachPassword.min' => 'The password must be at least 6 characters long.',
        ]);

        // Create a new coach
        $coach = Coach::create([
            'coachName' => $request->coachName,
            'coachPhone' => $request->coachPhone,
            'coachEmail' => $request->coachEmail,
            'coachPassword' => bcrypt($request->coachPassword),
            'indId' => $request->indId,
        ]);

        // Send email to the registered coach
        Mail::to($request->coachEmail)->send(new CoachRegistered($coach));

        // Redirect to index page with success message
        return redirect()->route('registers.index')->with('success', 'Coach registered successfully!');
    }
}
