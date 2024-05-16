<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Student;
use App\Models\UniversityStaff;
use App\Models\StaffPosition;
use App\Models\Coach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthManager extends Controller
{
    public function showLoginForm()
    {
        // Fetch positions from the database
        $positions = StaffPosition::all();

        // Pass positions to the view
        return view('login', compact('positions'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|in:student,staff,coach',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $role = $request->role;

        switch ($role) {
            case 'student':
                $guard = 'student';
                $fieldEmail = 'stuEmail';
                $fieldPassword = 'stuPassword';
                $dashboardRoute = 'studentDashboard';
                break;
            case 'staff':
                $request->validate([
                    'position' => 'required|in:1,2,3',
                ]);
                $guard = 'staff';
                $fieldEmail = 'staffEmail';
                $fieldPassword = 'staffPassword';

                // Fetch the position based on the retrieved staff user
                $user = UniversityStaff::where($fieldEmail, $request->email)->first();
                if ($user) {
                    $position = $user->position->posId;
                    switch ($position) {
                        case 1:
                            $dashboardRoute = 'supervisorDashboard';
                            break;
                        case 2:
                            $dashboardRoute = 'coordinatorDashboard';
                            break;
                        case 3:
                            $dashboardRoute = 'hopDashboard';
                            break;
                        default:
                            $dashboardRoute = 'login';
                    }
                }

                if ($position != $request->position) {
                    return redirect(route('login'))->with("error", "Invalid position selected for staff role!");
                }
                break;
            case 'coach':
                $guard = 'coach';
                $fieldEmail = 'coachEmail';
                $fieldPassword = 'coachPassword';
                $dashboardRoute = 'coachDashboard';
                break;
        }

        // Attempt authentication
        $credentials = [
            $fieldEmail => $request->email,
        ];

        // Check if the role is student, staff, or coach
        if ($role == 'student') {
            $user = Student::where($fieldEmail, $request->email)->first();
        } elseif ($role == 'staff') {
            $user = UniversityStaff::where($fieldEmail, $request->email)->first();
        } else {
            $user = Coach::where($fieldEmail, $request->email)->first();
        }

        // If the user exists and the password matches
        if ($user && Hash::check($request->password, $user->{$fieldPassword})) {
            // Login the user
            Auth::guard($guard)->login($user, $request->filled('remember'));
            // Redirect to appropriate dashboard based on role
            return redirect()->intended(route($dashboardRoute));
        }

        // Authentication failed, redirect back with an error message
        return redirect(route('login'))->with("error", "Invalid credentials or role!");
    }

    // Logout function
    function logout()
    {
        Auth::guard('student')->logout();
        Auth::guard('staff')->logout();
        Auth::guard('coach')->logout();
        return redirect('login');
    }

    // Forget password function
    public function showForgetPasswordForm()
    {
        return view('forget-password');
    }

    public function sendResetPasswordEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'role' => 'required|in:student,staff,coach',
        ]);

        switch ($request->role) {
            case 'student':
                $user = Student::where('stuEmail', $request->email)->first();
                break;
            case 'staff':
                $user = UniversityStaff::where('staffEmail', $request->email)->first();
                break;
            case 'coach':
                $user = Coach::where('coachEmail', $request->email)->first();
                break;
        }

        if ($user) {
            $token = Str::random(60);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $token, 'role' => $request->role, 'created_at' => now()]
            );

            // Send the password reset link via email
            Mail::to($user->email)->send(new ResetPassword($token, $request->email, $request->role));

            // Return the view with success message
            return view('forget-password')->with(['success' => 'Password reset link sent successfully']);
        } else {
            return back()->withErrors(['email' => 'User not found']);
        }
    }


    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        $role = $request->query('role');
        return view('new-password', ['token' => $token, 'email' => $email, 'role' => $role]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|same:password',
        ], [
            'password.min' => 'The new password must be at least 6 characters long.',
            'password_confirmation.same' => 'The new password confirmation does not match.',
        ]);

        // Retrieve the user based on email and role
        $user = null;
        if ($request->has('role')) {
            switch ($request->role) {
                case 'student':
                    $user = Student::where('stuEmail', $request->email)->first();
                    break;
                case 'staff':
                    $user = UniversityStaff::where('staffEmail', $request->email)->first();
                    break;
                case 'coach':
                    $user = Coach::where('coachEmail', $request->email)->first();
                    break;
            }
        }

        if ($user) {
            // Update the password field based on the user type
            switch ($request->role) {
                case 'student':
                    $user->update(['stuPassword' => Hash::make($request->password)]);
                    break;
                case 'staff':
                    $user->update(['staffPassword' => Hash::make($request->password)]);
                    break;
                case 'coach':
                    $user->update(['coachPassword' => Hash::make($request->password)]);
                    break;
            }

            // Check if the password was updated successfully
            if ($user->save()) {
                return redirect()->route('login')->with('success', 'Password reset successfully. You can now login with your new password.');
            } else {
                return back()->withErrors(['error' => 'Failed to update password. Please try again.']);
            }
        } else {
            return back()->withErrors(['email' => 'User not found']);
        }
    }
}
