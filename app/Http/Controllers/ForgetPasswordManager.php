<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\UniversityStaff;
use App\Models\Industry;

class ForgetPasswordManager extends Controller
{
    function forgetPassword()
    {
        return view('forget-password');
    }

    function forgetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:password_reset_tokens,email',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'role' => $this->getUserRole($request->email), // Add this line to store user role in the tokens table
            'created_at' => Carbon::now()
        ]);

        Mail::send('emails.forget-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect()->to(route('forget.password'))->with('success', "The reset password email has been sent. Please check your email inbox!");
    }

    function resetPassword($token)
    {
        return view('new-password', compact('token'));
    }

    function resetPasswordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:password_reset_tokens,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')->where([
            'email' => $request->email,
            'token' => $request->token
        ])->first();

        if (!$updatePassword) {
            return redirect()->route('reset.password', $request->token)->with('error', 'Invalid');
        }

        // Adjust the model used based on the user role
        $userModel = $this->getUserModel($updatePassword->role, $request->email);

        if ($userModel) {
            $userModel->update([$this->getPasswordField($updatePassword->role) => Hash::make($request->password)]);
            DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

            return redirect()->route('login')->with('success', 'Password reset success');
        } else {
            return redirect()->route('reset.password', $request->token)->with('error', 'User not found');
        }
    }

    // Helper function to get user role based on email
    private function getUserRole($email)
    {
        if (Student::where('stuEmail', $email)->exists()) {
            return 'student';
        } elseif (UniversityStaff::where('staffEmail', $email)->exists()) {
            return 'staff';
        } elseif (Industry::where('coachEmail', $email)->exists()) {
            return 'coach';
        }

        return null;
    }

    // Helper function to get user model based on role and email
    private function getUserModel($role, $email)
    {
        switch ($role) {
            case 'student':
                return Student::where('stuEmail', $email)->first();
            case 'staff':
                return UniversityStaff::where('staffEmail', $email)->first();
            case 'coach':
                return Industry::where('coachEmail', $email)->first();
        }

        return null;
    }

    // Helper function to get the correct password field based on role
    private function getPasswordField($role)
    {
        switch ($role) {
            case 'student':
                return 'stuPassword';
            case 'staff':
                return 'staffPassword';
            case 'coach':
                return 'coachPassword';
        }

        return null;
    }
}
