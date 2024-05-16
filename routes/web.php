<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\QuizController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. Thesea
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Homepage
Route::get('/', function () {
    return view('welcome');
})->name('homepage');

// Login, Forgot Password and Logout
Route::get('/login', [AuthManager::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthManager::class, 'login'])->name('loginPost');
Route::get('/forget-password', [AuthManager::class, 'showForgetPasswordForm'])->name('forget.password');
Route::post('/forget-password', [AuthManager::class, 'sendResetPasswordEmail'])->name('forget.password.post');
Route::get('/reset-password/{token}', [AuthManager::class, 'showResetForm'])->name('reset.password');
Route::post('/reset-password', [AuthManager::class, 'resetPassword'])->name('reset.password.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');


// Authenticated Routes for Student
Route::middleware('auth:student')->group(function () {
    // Dashboard
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('studentDashboard');

    // Module Manage Account
    Route::get('/student/profile/index', [ProfileController::class, 'index_student'])->name('students.profile.index');
    Route::get('/student/profile/edit', [ProfileController::class, 'edit_student'])->name('students.profile.edit');
    Route::post('/student/profile', [ProfileController::class, 'update_student'])->name('students.profile.update');

    // Module Manage Material
    Route::get('/student/material/index', [MaterialController::class, 'index_student'])->name('student.materials.index');

    // Module Manage Logbook
    Route::get('/student/logbook/index', [LogbookController::class, 'index'])->name('logbooks.index');
    Route::get('/student/logbook/create', [LogbookController::class, 'create'])->name('logbooks.create');
    Route::post('/student/logbook/index', [LogbookController::class, 'store'])->name('logbooks.store');
    Route::get('/student/logbook/{entry}/edit', [LogbookController::class, 'edit'])->name('logbooks.edit');
    Route::put('/student/logbook/{entry}', [LogbookController::class, 'update'])->name('logbooks.update');

    // Module Manage Documentation
    Route::get('/student/documentation/index', [DocumentController::class, 'index_student'])->name('student.documents.index');
    Route::get('/student/documentation/create', [DocumentController::class, 'create_student'])->name('student.documents.create');
    Route::post('/student/documentation/index', [DocumentController::class, 'store_student'])->name('student.documents.store');
    Route::get('/student/documentation/edit/{id}', [DocumentController::class, 'edit_student'])->name('student.documents.edit');
    Route::put('/student/documentation/update/{id}', [DocumentController::class, 'update_student'])->name('student.documents.update');
    Route::delete('/student/documentation/delete/{id}', [DocumentController::class, 'destroy_student'])->name('student.documents.destroy');
});

// Authenticated Routes for Staff
Route::middleware('auth:staff')->group(function () {

    // Supervisor functions
    // Supervisor Dashboard
    Route::get('/supervisor/dashboard', function () {
        return view('supervisor.dashboard');
    })->name('supervisorDashboard');

    // Module Manage Account for Supervisor
    Route::get('/supervisor/profile/index', [ProfileController::class, 'index_supervisor'])->name('supervisors.profile.index');
    Route::get('/supervisor/profile/edit', [ProfileController::class, 'edit_supervisor'])->name('supervisors.profile.edit');
    Route::post('/supervisor/profile', [ProfileController::class, 'update_supervisor'])->name('supervisors.profile.update');

    // Module Manage Material for Supervisor
    Route::get('/supervisor/material/index', [MaterialController::class, 'index_supervisor'])->name('supervisors.materials.index');


    // Coordinator functions
    // Coordinator Dashboard
    Route::get('/coordinator/dashboard', function () {
        return view('coordinator.dashboard');
    })->name('coordinatorDashboard');

    // Module Manage Account for Coordinator
    Route::get('/coordinator/profile/index', [ProfileController::class, 'index_coordinator'])->name('coordinators.profile.index');
    Route::get('/coordinator/profile/edit', [ProfileController::class, 'edit_coordinator'])->name('coordinators.profile.edit');
    Route::post('/coordinator/profile', [ProfileController::class, 'update_coordinator'])->name('coordinators.profile.update');

    Route::get('/coordinator/register/index', [RegistrationController::class, 'index'])->name('registers.index');
    Route::get('/coordinator/register/create', [RegistrationController::class, 'create'])->name('registers.create');
    Route::post('/coordinator/register/index', [RegistrationController::class, 'store'])->name('registers.store');

    // Module Manage Material for Coordinator
    Route::get('/coordinator/material/index', [MaterialController::class, 'index_coordinator'])->name('coordinators.materials.index');
    Route::get('/coordinator/material/create', [MaterialController::class, 'create_coordinator'])->name('coordinators.materials.create');
    Route::post('/coordinator/material/index', [MaterialController::class, 'store_coordinator'])->name('coordinators.materials.store');
    Route::get('/coordinator/material/edit/{id}', [MaterialController::class, 'edit_coordinator'])->name('coordinators.materials.edit');
    Route::put('/coordinator/material/update/{id}', [MaterialController::class, 'update_coordinator'])->name('coordinators.materials.update');
    Route::delete('/coordinator/material/delete/{id}', [MaterialController::class, 'destroy_coordinator'])->name('coordinators.materials.destroy');

    // Module Manage Quiz for Coordinator
    Route::get('/coordinator/quiz/index', [QuizController::class, 'index_coordinator'])->name('coordinators.quizes.index');
    Route::get('/coordinator/quiz/score/{id}', [QuizController::class, 'show_student_score'])->name('coordinators.quizes.score');
    Route::get('/coordinator/quiz/edit/{id}/{course}', [QuizController::class, 'edit_coordinator'])->name('coordinators.quizes.edit');
    Route::put('/coordinator/quiz/update/{id}/{course}', [QuizController::class, 'update_coordinator'])->name('coordinators.quizes.update');


    // Head of Program functions
    // Head of Program Dashboard
    Route::get('/hop/dashboard', function () {
        return view('hop.dashboard');
    })->name('hopDashboard');

    // Module Manage Account for Hop
    Route::get('/hop/profile/index', [ProfileController::class, 'index_hop'])->name('hop.profile.index');
    Route::get('/hop/profile/edit', [ProfileController::class, 'edit_hop'])->name('hop.profile.edit');
    Route::post('/hop/profile', [ProfileController::class, 'update_hop'])->name('hop.profile.update');
});


// Authenticated Routes for Coach
Route::middleware('auth:coach')->group(function () {
    Route::get('/coach/dashboard', function () {
        return view('coach.dashboard');
    })->name('coachDashboard');

    // Module Manage Account
    Route::get('/coach/profile/index', [ProfileController::class, 'index_coach'])->name('coaches.profile.index');
    Route::get('/coach/profile/edit', [ProfileController::class, 'edit_coach'])->name('coaches.profile.edit');
    Route::post('/coach/profile', [ProfileController::class, 'update_coach'])->name('coaches.profile.update');

    // Module Manage Material
    Route::get('/coach/material/index', [MaterialController::class, 'index_coach'])->name('coaches.materials.index');

    // Module Manage Logbook
    Route::get('/coach/logbook/index', [LogbookController::class, 'index_coach'])->name('coaches.logbooks.index');
    Route::put('/coach/logbooks/{logId}', [LogbookController::class, 'update_coach'])->name('coaches.logbooks.update');
});
