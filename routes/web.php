<?php

use App\Http\Controllers\AssessmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EvaluateController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\StudentInformationController;

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
    Route::get('/student/logbook/index', [LogbookController::class, 'index_student'])->name('student.logbooks.index');
    Route::get('/student/logbook/create', [LogbookController::class, 'create_student'])->name('student.logbooks.create');
    Route::post('/student/logbook/index', [LogbookController::class, 'store_student'])->name('student.logbooks.store');
    Route::get('/student/logbook/{entry}/edit', [LogbookController::class, 'edit_student'])->name('student.logbooks.edit');
    Route::put('/student/logbook/{entry}', [LogbookController::class, 'update_student'])->name('student.logbooks.update');

    // Module Manage Documentation
    Route::get('/student/documentation/index', [DocumentController::class, 'index_student'])->name('student.documents.index');
    Route::get('/student/documentation/create', [DocumentController::class, 'create_student'])->name('student.documents.create');
    Route::post('/student/documentation/index', [DocumentController::class, 'store_student'])->name('student.documents.store');
    Route::get('/student/documentation/edit/{id}', [DocumentController::class, 'edit_student'])->name('student.documents.edit');
    Route::put('/student/documentation/update/{id}', [DocumentController::class, 'update_student'])->name('student.documents.update');
    Route::delete('/student/documentation/delete/{id}', [DocumentController::class, 'destroy_student'])->name('student.documents.destroy');

    // Module Manage Quiz
    Route::get('/student/quiz/index', [QuizController::class, 'index_student'])->name('students.quizes.index');
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

    // Module Manage Logbook for Supervisor
    Route::get('/supervisor/logbook/index', [LogbookController::class, 'index_supervisor'])->name('supervisors.logbooks.index');

    // Module Manage Documentation for Supervisor
    Route::get('/supervisor/documentation/index', [DocumentController::class, 'index_supervisor'])->name('supervisors.documents.index');

    // Module Manage Evaluation for Supervisor
    Route::get('/supervisor/evaluation/index', [EvaluateController::class, 'index_supervisor'])->name('supervisors.evaluations.index');
    Route::get('/supervisor/evaluation/documentEvaluate/stuId={stuId}', [EvaluateController::class, 'documentEvaluate_supervisor'])->name('supervisors.evaluations.documentEvaluate');
    Route::post('/supervisor/evaluation/documentEvaluate/stuId={stuId}', [EvaluateController::class, 'documentEvaluate_store_supervisor'])->name('supervisors.evaluations.documentEvaluate.store');
    Route::get('/supervisor/evaluation/logbookEvaluate/stuId={stuId}', [EvaluateController::class, 'logbookEvaluate_supervisor'])->name('supervisors.evaluations.logbookEvaluate');
    Route::post('/supervisor/evaluation/logbookEvaluate/stuId={stuId}', [EvaluateController::class, 'logbookEvaluate_store_supervisor'])->name('supervisors.evaluations.logbookEvaluate.store');
    Route::get('/supervisor/evaluation/presentationEvaluate', [EvaluateController::class, 'presentationEvaluate_supervisor'])->name('supervisors.evaluations.presentationEvaluate');
    Route::post('/supervisor/evaluation/presentationEvaluate', [EvaluateController::class, 'presentationEvaluate_store_supervisor'])->name('supervisors.evaluations.presentationEvaluate.store');
    Route::get('/supervisor/evaluation/projectOutputEvaluate', [EvaluateController::class, 'projectOutputEvaluate_supervisor'])->name('supervisors.evaluations.projectOutputEvaluate');
    Route::post('/supervisor/evaluation/projectOutputEvaluate', [EvaluateController::class, 'projectOutputEvaluate_store_supervisor'])->name('supervisors.evaluations.projectOutputEvaluate.store');


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

    // Module Manage Documentation for Supervisor
    Route::get('/coordinator/documentation/index', [DocumentController::class, 'index_coordinator'])->name('coordinators.documents.index');

    // Module Manage Quiz for Coordinator
    Route::get('/coordinator/quiz/index', [QuizController::class, 'index_coordinator'])->name('coordinators.quizes.index');
    Route::get('/coordinators/quizes/edit/{stuId}/{courseId}', [QuizController::class, 'edit_coordinator'])->name('coordinators.quizes.edit');
    Route::put('/coordinator/quiz/update/{stuId}/{courseId}', [QuizController::class, 'update_coordinator'])->name('coordinators.quizes.update');

    // Module Manage Evaluation for Coordinator
    Route::get('/coordinator/evaluation/index', [EvaluateController::class, 'index_coordinator'])->name('coordinators.evaluations.index');
    Route::get('/coordinator/evaluation/createUniversity', [EvaluateController::class, 'create_university_coordinator'])->name('coordinators.evaluations.createUniversity');
    Route::get('/coordinator/evaluation/createIndustry', [EvaluateController::class, 'create_industry_coordinator'])->name('coordinators.evaluations.createIndustry');
    Route::post('/coordinator/evaluation/index', [EvaluateController::class, 'store_coordinator'])->name('coordinators.evaluations.store');
    Route::get('/coordinator/evaluation/ploDetails/{evaId}', [EvaluateController::class, 'ploDetails_coordinator'])->name('coordinators.evaluations.ploDetails');
    Route::get('/coordinator/evaluation/editCriteria/{evaCriId}', [EvaluateController::class, 'editCriteria_coordinator'])->name('coordinators.evaluations.editCriteria');
    Route::put('/coordinator/evaluation/{evaCriId}', [EvaluateController::class, 'updateCriteria_coordinator'])->name('coordinators.evaluations.updateCriteria');
    Route::get('coordinators/evaluations/addCriteria/{evaId}', [EvaluateController::class, 'addCriteria_coordinator'])->name('coordinators.evaluations.addCriteria');
    Route::post('coordinators/evaluations/storeCriteria/{evaId}', [EvaluateController::class, 'storeCriteria_coordinator'])->name('coordinators.evaluations.storeCriteria');
    Route::delete('/coordinator/evaluation/destroyPlo/{evaId}', [EvaluateController::class, 'destroyPlo_coordinator'])->name('coordinators.evaluations.destroyPlo');
    Route::delete('/coordinator/evaluation/destroyCriteria/{evaCriId}', [EvaluateController::class, 'destroyCriteria_coordinator'])->name('coordinators.evaluations.destroyCriteria');
    Route::get('/coordinator/evaluation/studentEvaluateOverview', [EvaluateController::class, 'studentEvaluateOverview_coordinator'])->name('coordinators.evaluations.studentEvaluateOverview');
    Route::get('/coordinator/evaluation/studentEvaluateDetails/stuId={stuId}', [EvaluateController::class, 'studentEvaluateDetails_coordinator'])->name('coordinators.evaluations.studentEvaluateDetails');

    // Module Manage Session for Coordinator (features)
    Route::get('/coordinator/session/index', [SessionController::class, 'index_coordinator'])->name('coordinators.sessions.index');
    Route::get('/coordinator/session/create', [SessionController::class, 'create_coordinator'])->name('coordinators.sessions.create');
    Route::post('/coordinator/session/index', [SessionController::class, 'store_coordinator'])->name('coordinators.sessions.store');
    Route::get('/coordinator/session/edit/{id}', [SessionController::class, 'edit_coordinator'])->name('coordinators.sessions.edit');
    Route::put('/coordinator/session/update/{id}', [SessionController::class, 'update_coordinator'])->name('coordinators.sessions.update');
    Route::delete('/coordinator/session/delete/{id}', [SessionController::class, 'destroy_coordinator'])->name('coordinators.sessions.destroy');
    Route::get('/coordinator/session/studentSession', [SessionController::class, 'studentSessions_coordinator'])->name('coordinators.sessions.studentSession');
    Route::post('/coordinator/session/studentSession/update', [SessionController::class, 'update_studentSessions_coordinator'])->name('coordinators.sessions.studentSession.update');

    // Module Manage Course for Coordinator (features)
    Route::get('/coordinator/course/index', [CourseController::class, 'index_coordinator'])->name('coordinators.courses.index');
    Route::get('/coordinator/course/create', [CourseController::class, 'create_coordinator'])->name('coordinators.courses.create');
    Route::post('/coordinator/course/index', [CourseController::class, 'store_coordinator'])->name('coordinators.courses.store');
    Route::get('/coordinator/course/edit/{id}', [CourseController::class, 'edit_coordinator'])->name('coordinators.courses.edit');
    Route::put('/coordinator/course/update/{id}', [CourseController::class, 'update_coordinator'])->name('coordinators.courses.update');
    Route::delete('/coordinator/course/delete/{id}', [CourseController::class, 'destroy_coordinator'])->name('coordinators.courses.destroy');

    // Module Manage Assessment for Coordinator (features)
    Route::get('/coordinator/assessment/index', [AssessmentController::class, 'index_coordinator'])->name('coordinators.assessments.index');
    Route::get('/coordinator/assessment/create', [AssessmentController::class, 'create_coordinator'])->name('coordinators.assessments.create');
    Route::post('/coordinator/assessment/index', [AssessmentController::class, 'store_coordinator'])->name('coordinators.assessments.store');
    Route::get('/coordinator/assessment/edit/{assessmentId}', [AssessmentController::class, 'edit_coordinator'])->name('coordinators.assessments.edit');
    Route::put('/coordinator/assessment/update/{assessmentId}', [AssessmentController::class, 'update_coordinator'])->name('coordinators.assessments.update');
    Route::delete('/coordinator/assessment/delete/{assessmentId}', [AssessmentController::class, 'destroy_coordinator'])->name('coordinators.assessments.destroy');

    // Module Manage Student's Coach for Coordinator (features)
    Route::get('/coordinator/studentInformation/index', [StudentInformationController::class, 'index_coordinator'])->name('coordinators.infos.index');
    Route::get('/coordinator/studentInformation/assignCoach/{stuId}', [StudentInformationController::class, 'assignCoach_coordinator'])->name('coordinators.infos.assignCoach');
    Route::put('/coordinator/studentInformation/updateCoach/{stuId}', [StudentInformationController::class, 'updateCoach_coordinator'])->name('coordinators.infos.updateCoach');


    // Head of Program functions
    // Head of Program Dashboard
    Route::get('/hop/dashboard', function () {
        return view('hop.dashboard');
    })->name('hopDashboard');

    // Module Manage Account for Hop
    Route::get('/hop/profile/index', [ProfileController::class, 'index_hop'])->name('hop.profile.index');
    Route::get('/hop/profile/edit', [ProfileController::class, 'edit_hop'])->name('hop.profile.edit');
    Route::post('/hop/profile', [ProfileController::class, 'update_hop'])->name('hop.profile.update');

    // Module Manange Evaluation for Hop
    Route::get('/hop/evaluation/studentEvaluateOverview', [EvaluateController::class, 'studentEvaluateOverview_hop'])->name('hop.evaluations.studentEvaluateOverview');
    Route::get('/hop/evaluation/studentEvaluateDetails/stuId={stuId}', [EvaluateController::class, 'studentEvaluateDetails_hop'])->name('hop.evaluations.studentEvaluateDetails');
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

    // Module Manage Documentation
    Route::get('/coach/resume/index', [ResumeController::class, 'index_coach'])->name('coaches.resume.index');
    Route::get('/coach/resume/create', [ResumeController::class, 'create_coach'])->name('coaches.resume.create');
    Route::post('/coach/resume/store', [ResumeController::class, 'store_coach'])->name('coaches.resume.store');
    Route::get('/coach/resume/edit/{id}', [ResumeController::class, 'edit_coach'])->name('coaches.resume.edit');
    Route::put('/coach/resume/update/{id}', [ResumeController::class, 'update_coach'])->name('coaches.resume.update');
    Route::delete('/coach/resume/delete/{id}', [ResumeController::class, 'destroy_coach'])->name('coaches.resume.destroy');
    Route::get('/coach/documentation/index', [DocumentController::class, 'index_coach'])->name('coaches.documents.index');

    // Module Manage Evaluation
    Route::get('/coach/evaluation/index', [EvaluateController::class, 'index_coach'])->name('coaches.evaluations.index');
    Route::get('/coach/evaluation/documentEvaluate/stuId={stuId}', [EvaluateController::class, 'documentEvaluate_coach'])->name('coaches.evaluations.documentEvaluate');
    Route::post('/coach/evaluation/documentEvaluate/stuId={stuId}', [EvaluateController::class, 'documentEvaluate_store_coach'])->name('coaches.evaluations.documentEvaluate.store');
    Route::get('/coach/evaluation/observationEvaluate', [EvaluateController::class, 'observationEvaluate_coach'])->name('coaches.evaluations.observationEvaluate');
    Route::post('/coach/evaluation/observationEvaluate', [EvaluateController::class, 'observationEvaluate_store_coach'])->name('coaches.evaluations.observationEvaluate.store');
    Route::get('/coach/evaluation/progressPresentationEvaluate', [EvaluateController::class, 'progressPresentationEvaluate_coach'])->name('coaches.evaluations.progressPresentationEvaluate');
    Route::post('/coach/evaluation/progressPresentationEvaluate', [EvaluateController::class, 'progressPresentationEvaluate_store_coach'])->name('coaches.evaluations.progressPresentationEvaluate.store');
    Route::get('/coach/evaluation/finalPresentationEvaluate', [EvaluateController::class, 'finalPresentationEvaluate_coach'])->name('coaches.evaluations.finalPresentationEvaluate');
    Route::post('/coach/evaluation/finalPresentationEvaluate', [EvaluateController::class, 'finalPresentationEvaluate_store_coach'])->name('coaches.evaluations.finalPresentationEvaluate.store');
    Route::get('/coach/evaluation/projectOutputEvaluate', [EvaluateController::class, 'projectOutputEvaluate_coach'])->name('coaches.evaluations.projectOutputEvaluate');
    Route::post('/coach/evaluation/projectOutputEvaluate', [EvaluateController::class, 'projectOutputEvaluate_store_coach'])->name('coaches.evaluations.projectOutputEvaluate.store');
});
