<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Course;
use App\Models\Evaluation;
use App\Models\EvaluationCriteria;
use App\Models\EvaluationScore;
use App\Models\Session;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EvaluateController extends Controller
{
    public function index_coordinator()
    {
        // Fetch all courses
        $courses = Course::all();

        // Loop through courses and fetch evaluations for each course
        foreach ($courses as $course) {
            $course->evaluations = Evaluation::where('courseId', $course->courseId)
                ->with(['assessment' => function ($query) {
                    $query->orderBy('assessmentName');
                }])
                ->orderBy('plo')
                ->get();
        }

        return view('coordinator.evaluation.index', compact('courses'));
    }


    public function create_university_coordinator()
    {
        $courses = Course::all();
        $assessments = Assessment::all();
        return view('coordinator.evaluation.createUniversity', compact('courses', 'assessments'));
    }

    public function create_industry_coordinator()
    {
        $courses = Course::all();
        $assessments = Assessment::all();
        return view('coordinator.evaluation.createIndustry', compact('courses', 'assessments'));
    }

    public function store_coordinator(Request $request)
    {
        $request->validate([
            'assessor' => 'required|in:University,Industry',
            'course' => 'required|exists:courses,courseId',
            'assessment' => 'required|exists:assessments,assessmentId',
            'plo' => 'required|integer|min:2|max:9',
            'criteria.*' => 'required|string',
            'weight.*' => 'required|numeric|min:0|max:10',
        ]);

        $evaluation = Evaluation::create([
            'assessor' => $request->input('assessor'),
            'courseId' => $request->input('course'),
            'assessmentId' => $request->input('assessment'),
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

    public function destroyPlo_coordinator($evaId)
    {
        $evaluation = Evaluation::findOrFail($evaId);
        $evaluation->criteria()->delete();
        $evaluation->delete();

        return redirect()->back()->with('success', 'PLO deleted successfully');
    }

    public function destroyCriteria_coordinator($evaCriId)
    {
        $criteria = EvaluationCriteria::findOrFail($evaCriId);
        $criteria->delete();
        return redirect()->back()->with('success', 'Criteria deleted successfully');
    }

    public function studentEvaluateOverview_coordinator(Request $request)
    {
        $sessions = Session::with(['students.supervisorDetails', 'students.coachDetails'])->get();
        return view('coordinator.evaluation.studentEvaluateOverview', compact('sessions'));
    }

    public function studentEvaluateDetails_coordinator($stuId)
    {
        $student = Student::with(['sessionDetails.courses.evaluations.assessment'])->findOrFail($stuId);
        $courses = $student->sessionDetails->courses;

        $evaluationScores = EvaluationScore::where('stuId', $stuId)
            ->with(['criteria.evaluation'])
            ->get();

        $marksByPloAndAssessor = [];
        $allPlosByCourse = [];
        $processedEvaluations = [];

        $ploNames = [
            1 => 'Knowledge and Understanding',
            2 => 'Practical Skills',
            3 => 'Cognitive Skills',
            4 => 'Communication Skills',
            5 => 'Interpersonal Skills',
            6 => 'Ethics and Professionalism',
            7 => 'Personal Skills',
            8 => 'Entrepreneurial Skills',
            9 => 'Leadership, Autonomy and Responsibility'
        ];

        foreach ($courses as $course) {
            $plos = $course->evaluations->pluck('plo')->unique();
            $sortedPlos = $plos->sort()->values()->all();
            $allPlosByCourse[$course->courseId] = $sortedPlos;

            foreach ($course->evaluations as $evaluation) {
                $plo = $evaluation->plo;
                $assessorType = $evaluation->assessor;
                $evaId = $evaluation->evaId;

                if (in_array($evaId, $processedEvaluations)) {
                    continue;
                }
                $processedEvaluations[] = $evaId;

                if (!isset($marksByPloAndAssessor[$course->courseId][$plo][$assessorType])) {
                    $marksByPloAndAssessor[$course->courseId][$plo][$assessorType] = 0;
                }

                $filteredScores = $evaluationScores->filter(function ($score) use ($evaId) {
                    return $score->criteria->evaluation->evaId == $evaId;
                });

                $totalScore = 0;
                foreach ($filteredScores as $score) {
                    $weight = $score->criteria->weight;
                    $weightedScore = $score->score * $weight;
                    $totalScore += $weightedScore;
                }

                $marksByPloAndAssessor[$course->courseId][$plo][$assessorType] += $totalScore;
            }
        }

        return view('coordinator.evaluation.studentEvaluateDetails', compact('student', 'courses', 'marksByPloAndAssessor', 'allPlosByCourse', 'ploNames'));
    }

    public function index_supervisor()
    {
        $supervisor = Auth::user();

        $students = $supervisor->students;

        $evaluations = Evaluation::with(['criteria', 'course', 'assessment'])
            ->where('assessor', 'University')
            ->get();

        $evaluationsGrouped = $evaluations->groupBy('course.courseCode')->sortKeys();

        $assessmentByCourse = [];
        $totalMarksByAssessment = [];

        foreach ($evaluationsGrouped as $courseCode => $evaluations) {
            $assessments = [];
            foreach ($evaluations as $evaluation) {
                $assessments[$evaluation->assessmentId] = $evaluation->assessment->assessmentName;

                foreach ($evaluation->criteria as $criterion) {
                    $existingScores = EvaluationScore::where('evaCriId', $criterion->evaCriId)->get();
                    foreach ($existingScores as $score) {
                        // Initialize the nested array if not already set
                        $key = $score->stuId . '_' . $evaluation->course->courseCode . '_' . $evaluation->assessmentId;
                        if (!isset($totalMarksByAssessment[$key])) {
                            $totalMarksByAssessment[$key] = 0;
                        }
                        // Aggregate scores for each student, course, and assessment
                        $totalMarksByAssessment[$key] += $score->score * $criterion->weight;
                    }
                }
            }
            $assessmentByCourse[$courseCode] = $assessments;
        }

        return view('supervisor.evaluation.index', compact('students', 'evaluationsGrouped', 'assessmentByCourse', 'totalMarksByAssessment'));
    }

    public function documentEvaluate_supervisor($stuId)
    {
        $student = Student::findOrFail($stuId);

        $evaluations = Evaluation::with(['criteria', 'course'])
            ->where('assessor', 'University')
            ->whereHas('assessment', function ($query) {
                $query->where('assessmentName', 'project documentation');
            })
            ->get();

        $evaluationsGrouped = $evaluations->groupBy('course.courseCode')->sortKeys();

        $plosByCourse = [];
        foreach ($evaluationsGrouped as $courseCode => $evaluations) {
            $plosByCourse[$courseCode] = $evaluations->pluck('plo')->unique();
        }

        $existingEvaluations = EvaluationScore::whereIn('stuId', $student->pluck('stuId'))
            ->get()
            ->groupBy('stuId');

        return view('supervisor.evaluation.documentEvaluate', compact('student', 'evaluationsGrouped', 'plosByCourse', 'existingEvaluations'));
    }

    public function documentEvaluate_store_supervisor(Request $request, $stuId)
    {
        $request->validate([
            'criteria' => 'required|array',
            'criteria.*' => 'required|numeric|min:0|max:5',
        ]);

        $student = Student::findOrFail($stuId);
        $criteria = $request->input('criteria');
        $plo = $request->input('plo');

        foreach ($criteria as $evaCriId => $score) {
            EvaluationScore::updateOrCreate(
                [
                    'stuId' => $student->stuId,
                    'plo' => $plo,
                    'evaCriId' => $evaCriId,
                ],
                [
                    'score' => $score,
                ]
            );
        }

        return redirect()->back()->with('success', 'Evaluation scores saved successfully.');
    }

    public function logbookEvaluate_supervisor($stuId)
    {
        $student = Student::findOrFail($stuId);

        $evaluations = Evaluation::with(['criteria', 'course'])
            ->where('assessor', 'University')
            ->whereHas('assessment', function ($query) {
                $query->where('assessmentName', 'logbook');
            })
            ->get();

        $evaluationsGrouped = $evaluations->groupBy('course.courseCode')->sortKeys();

        $plosByCourse = [];
        foreach ($evaluationsGrouped as $courseCode => $evaluations) {
            $plosByCourse[$courseCode] = $evaluations->pluck('plo')->unique();
        }

        $existingEvaluations = EvaluationScore::whereIn('stuId', $student->pluck('stuId'))
            ->get()
            ->groupBy('stuId');

        return view('supervisor.evaluation.logbookEvaluate', compact('student', 'evaluationsGrouped', 'plosByCourse', 'existingEvaluations'));
    }

    public function logbookEvaluate_store_supervisor(Request $request, $stuId)
    {
        $request->validate([
            'criteria' => 'required|array',
            'criteria.*' => 'required|numeric|min:0|max:5',
        ]);

        $student = Student::findOrFail($stuId);
        $criteria = $request->input('criteria');
        $plo = $request->input('plo');

        foreach ($criteria as $evaCriId => $score) {
            EvaluationScore::updateOrCreate(
                [
                    'stuId' => $student->stuId,
                    'plo' => $plo,
                    'evaCriId' => $evaCriId,
                ],
                [
                    'score' => $score,
                ]
            );
        }

        return redirect()->back()->with('success', 'Evaluation scores saved successfully.');
    }

    public function presentationEvaluate_supervisor(Request $request)
    {
        $supervisor = Auth::user();
        $students = $supervisor->students;

        $evaluations = Evaluation::with(['criteria', 'course'])
            ->where('assessor', 'University')
            ->whereHas('assessment', function ($query) {
                $query->where('assessmentName', 'final presentation');
            })
            ->get();

        $evaluationsGrouped = $evaluations->groupBy('course.courseCode')->sortKeys();

        $plosByCourse = [];
        foreach ($evaluationsGrouped as $courseCode => $evaluations) {
            $plosByCourse[$courseCode] = $evaluations->pluck('plo')->unique();
        }

        $existingEvaluations = EvaluationScore::whereIn('stuId', $students->pluck('stuId'))
            ->get()
            ->groupBy('stuId');

        return view('supervisor.evaluation.presentationEvaluate', compact('students', 'evaluationsGrouped', 'plosByCourse', 'existingEvaluations'));
    }

    public function presentationEvaluate_store_supervisor(Request $request)
    {
        $stuId = $request->input('stuId');
        $criteria = $request->input('criteria');
        $plo = $request->input('plo');

        foreach ($criteria as $evaCriId => $score) {
            EvaluationScore::updateOrCreate(
                [
                    'stuId' => $stuId,
                    'plo' => $plo,
                    'evaCriId' => $evaCriId
                ],
                [
                    'score' => $score
                ]
            );
        }

        return redirect()->route('supervisors.evaluations.presentationEvaluate', ['stuId' => $stuId])->with('success', 'Evaluation scores saved successfully.');
    }

    public function projectOutputEvaluate_supervisor(Request $request)
    {
        $supervisor = Auth::user();
        $students = $supervisor->students;

        $evaluations = Evaluation::with(['criteria', 'course'])
            ->where('assessor', 'University')
            ->whereHas('assessment', function ($query) {
                $query->where('assessmentName', 'project output');
            })
            ->get();

        $evaluationsGrouped = $evaluations->groupBy('course.courseCode')->sortKeys();

        $plosByCourse = [];
        foreach ($evaluationsGrouped as $courseCode => $evaluations) {
            $plosByCourse[$courseCode] = $evaluations->pluck('plo')->unique();
        }

        $existingEvaluations = EvaluationScore::whereIn('stuId', $students->pluck('stuId'))
            ->get()
            ->groupBy('stuId');

        return view('supervisor.evaluation.projectOutputEvaluate', compact('students', 'evaluationsGrouped', 'plosByCourse', 'existingEvaluations'));
    }

    public function projectOutputEvaluate_store_supervisor(Request $request)
    {
        $stuId = $request->input('stuId');
        $criteria = $request->input('criteria');
        $plo = $request->input('plo');

        foreach ($criteria as $evaCriId => $score) {
            EvaluationScore::updateOrCreate(
                [
                    'stuId' => $stuId,
                    'plo' => $plo,
                    'evaCriId' => $evaCriId
                ],
                [
                    'score' => $score
                ]
            );
        }

        return redirect()->route('supervisors.evaluations.projectOutputEvaluate', ['stuId' => $stuId])->with('success', 'Evaluation scores saved successfully.');
    }

    public function index_coach()
    {
        $coach = Auth::user();

        $students = $coach->students;

        $evaluations = Evaluation::with(['criteria', 'course', 'assessment'])
            ->where('assessor', 'Industry')
            ->get();

        $evaluationsGrouped = $evaluations->groupBy('course.courseCode')->sortKeys();

        $assessmentByCourse = [];
        $totalMarksByAssessment = [];

        foreach ($evaluationsGrouped as $courseCode => $evaluations) {
            $assessments = [];
            foreach ($evaluations as $evaluation) {
                $assessments[$evaluation->assessmentId] = $evaluation->assessment->assessmentName;

                foreach ($evaluation->criteria as $criterion) {
                    $existingScores = EvaluationScore::where('evaCriId', $criterion->evaCriId)->get();
                    foreach ($existingScores as $score) {
                        // Initialize the nested array if not already set
                        $key = $score->stuId . '_' . $evaluation->course->courseCode . '_' . $evaluation->assessmentId;
                        if (!isset($totalMarksByAssessment[$key])) {
                            $totalMarksByAssessment[$key] = 0;
                        }
                        // Aggregate scores for each student, course, and assessment
                        $totalMarksByAssessment[$key] += $score->score * $criterion->weight;
                    }
                }
            }
            $assessmentByCourse[$courseCode] = $assessments;
        }

        return view('coach.evaluation.index', compact('students', 'evaluationsGrouped', 'assessmentByCourse', 'totalMarksByAssessment'));
    }

    public function documentEvaluate_coach($stuId)
    {
        $student = Student::findOrFail($stuId);

        $evaluations = Evaluation::with(['criteria', 'course'])
            ->where('assessor', 'Industry')
            ->whereHas('assessment', function ($query) {
                $query->where('assessmentName', 'project documentation');
            })
            ->get();

        $evaluationsGrouped = $evaluations->groupBy('course.courseCode')->sortKeys();

        $plosByCourse = [];
        foreach ($evaluationsGrouped as $courseCode => $evaluations) {
            $plosByCourse[$courseCode] = $evaluations->pluck('plo')->unique();
        }

        $existingEvaluations = EvaluationScore::whereIn('stuId', $student->pluck('stuId'))
            ->get()
            ->groupBy('stuId');

        return view('coach.evaluation.documentEvaluate', compact('student', 'evaluationsGrouped', 'plosByCourse', 'existingEvaluations'));
    }

    public function documentEvaluate_store_coach(Request $request, $stuId)
    {
        $request->validate([
            'criteria' => 'required|array',
            'criteria.*' => 'required|numeric|min:0|max:5',
        ]);

        $student = Student::findOrFail($stuId);
        $criteria = $request->input('criteria');
        $plo = $request->input('plo');

        foreach ($criteria as $evaCriId => $score) {
            EvaluationScore::updateOrCreate(
                [
                    'stuId' => $student->stuId,
                    'plo' => $plo,
                    'evaCriId' => $evaCriId,
                ],
                [
                    'score' => $score,
                ]
            );
        }

        return redirect()->back()->with('success', 'Evaluation scores saved successfully.');
    }

    public function observationEvaluate_coach(Request $request)
    {
        $coach = Auth::user();
        $students = $coach->students;

        $evaluations = Evaluation::with(['criteria', 'course'])
            ->where('assessor', 'Industry')
            ->whereHas('assessment', function ($query) {
                $query->where('assessmentName', 'observation');
            })
            ->get();

        $evaluationsGrouped = $evaluations->groupBy('course.courseCode')->sortKeys();

        $plosByCourse = [];
        foreach ($evaluationsGrouped as $courseCode => $evaluations) {
            $plosByCourse[$courseCode] = $evaluations->pluck('plo')->unique();
        }

        $existingEvaluations = EvaluationScore::whereIn('stuId', $students->pluck('stuId'))
            ->get()
            ->groupBy('stuId');

        return view('coach.evaluation.observationEvaluate', compact('students', 'evaluationsGrouped', 'plosByCourse', 'existingEvaluations'));
    }

    public function observationEvaluate_store_coach(Request $request)
    {
        $stuId = $request->input('stuId');
        $criteria = $request->input('criteria');
        $plo = $request->input('plo');

        foreach ($criteria as $evaCriId => $score) {
            EvaluationScore::updateOrCreate(
                [
                    'stuId' => $stuId,
                    'plo' => $plo,
                    'evaCriId' => $evaCriId
                ],
                [
                    'score' => $score
                ]
            );
        }

        return redirect()->route('coaches.evaluations.observationEvaluate', ['stuId' => $stuId])->with('success', 'Evaluation scores saved successfully.');
    }

    public function progressPresentationEvaluate_coach(Request $request)
    {
        $coach = Auth::user();
        $students = $coach->students;

        $evaluations = Evaluation::with(['criteria', 'course'])
            ->where('assessor', 'Industry')
            ->whereHas('assessment', function ($query) {
                $query->where('assessmentName', 'progress presentation');
            })
            ->get();

        $evaluationsGrouped = $evaluations->groupBy('course.courseCode')->sortKeys();

        $plosByCourse = [];
        foreach ($evaluationsGrouped as $courseCode => $evaluations) {
            $plosByCourse[$courseCode] = $evaluations->pluck('plo')->unique();
        }

        $existingEvaluations = EvaluationScore::whereIn('stuId', $students->pluck('stuId'))
            ->get()
            ->groupBy('stuId');

        return view('coach.evaluation.progressPresentationEvaluate', compact('students', 'evaluationsGrouped', 'plosByCourse', 'existingEvaluations'));
    }

    public function progressPresentationEvaluate_store_coach(Request $request)
    {
        $stuId = $request->input('stuId');
        $criteria = $request->input('criteria');
        $plo = $request->input('plo');

        foreach ($criteria as $evaCriId => $score) {
            EvaluationScore::updateOrCreate(
                [
                    'stuId' => $stuId,
                    'plo' => $plo,
                    'evaCriId' => $evaCriId
                ],
                [
                    'score' => $score
                ]
            );
        }

        return redirect()->route('coaches.evaluations.progressPresentationEvaluate', ['stuId' => $stuId])->with('success', 'Evaluation scores saved successfully.');
    }

    public function finalPresentationEvaluate_coach(Request $request)
    {
        $coach = Auth::user();
        $students = $coach->students;

        $evaluations = Evaluation::with(['criteria', 'course'])
            ->where('assessor', 'Industry')
            ->whereHas('assessment', function ($query) {
                $query->where('assessmentName', 'final presentation');
            })
            ->get();

        $evaluationsGrouped = $evaluations->groupBy('course.courseCode')->sortKeys();

        $plosByCourse = [];
        foreach ($evaluationsGrouped as $courseCode => $evaluations) {
            $plosByCourse[$courseCode] = $evaluations->pluck('plo')->unique();
        }

        $existingEvaluations = EvaluationScore::whereIn('stuId', $students->pluck('stuId'))
            ->get()
            ->groupBy('stuId');

        return view('coach.evaluation.finalPresentationEvaluate', compact('students', 'evaluationsGrouped', 'plosByCourse', 'existingEvaluations'));
    }

    public function finalPresentationEvaluate_store_coach(Request $request)
    {
        $stuId = $request->input('stuId');
        $criteria = $request->input('criteria');
        $plo = $request->input('plo');

        foreach ($criteria as $evaCriId => $score) {
            EvaluationScore::updateOrCreate(
                [
                    'stuId' => $stuId,
                    'plo' => $plo,
                    'evaCriId' => $evaCriId
                ],
                [
                    'score' => $score
                ]
            );
        }

        return redirect()->route('coaches.evaluations.finalPresentationEvaluate', ['stuId' => $stuId])->with('success', 'Evaluation scores saved successfully.');
    }

    public function projectOutputEvaluate_coach(Request $request)
    {
        $supervisor = Auth::user();
        $students = $supervisor->students;

        $evaluations = Evaluation::with(['criteria', 'course'])
            ->where('assessor', 'Industry')
            ->whereHas('assessment', function ($query) {
                $query->where('assessmentName', 'project output');
            })
            ->get();

        $evaluationsGrouped = $evaluations->groupBy('course.courseCode')->sortKeys();

        $plosByCourse = [];
        foreach ($evaluationsGrouped as $courseCode => $evaluations) {
            $plosByCourse[$courseCode] = $evaluations->pluck('plo')->unique();
        }

        $existingEvaluations = EvaluationScore::whereIn('stuId', $students->pluck('stuId'))
            ->get()
            ->groupBy('stuId');

        return view('coach.evaluation.projectOutputEvaluate', compact('students', 'evaluationsGrouped', 'plosByCourse', 'existingEvaluations'));
    }

    public function projectOutputEvaluate_store_coach(Request $request)
    {
        $stuId = $request->input('stuId');
        $criteria = $request->input('criteria');
        $plo = $request->input('plo');

        foreach ($criteria as $evaCriId => $score) {
            EvaluationScore::updateOrCreate(
                [
                    'stuId' => $stuId,
                    'plo' => $plo,
                    'evaCriId' => $evaCriId
                ],
                [
                    'score' => $score
                ]
            );
        }

        return redirect()->route('coaches.evaluations.projectOutputEvaluate', ['stuId' => $stuId])->with('success', 'Evaluation scores saved successfully.');
    }

    public function studentEvaluateOverview_hop(Request $request)
    {
        $sessions = Session::with(['students.supervisorDetails', 'students.coachDetails'])->get();
        return view('hop.evaluation.studentEvaluateOverview', compact('sessions'));
    }

    public function studentEvaluateDetails_hop($stuId)
    {
        $student = Student::with(['sessionDetails.courses.evaluations.assessment'])->findOrFail($stuId);
        $courses = $student->sessionDetails->courses;

        $evaluationScores = EvaluationScore::where('stuId', $stuId)
            ->with(['criteria.evaluation'])
            ->get();

        $marksByPloAndAssessor = [];
        $allPlosByCourse = [];
        $processedEvaluations = [];

        $ploNames = [
            1 => 'Knowledge and Understanding',
            2 => 'Practical Skills',
            3 => 'Cognitive Skills',
            4 => 'Communication Skills',
            5 => 'Interpersonal Skills',
            6 => 'Ethics and Professionalism',
            7 => 'Personal Skills',
            8 => 'Entrepreneurial Skills',
            9 => 'Leadership, Autonomy and Responsibility'
        ];

        foreach ($courses as $course) {
            $plos = $course->evaluations->pluck('plo')->unique();
            $sortedPlos = $plos->sort()->values()->all();
            $allPlosByCourse[$course->courseId] = $sortedPlos;

            foreach ($course->evaluations as $evaluation) {
                $plo = $evaluation->plo;
                $assessorType = $evaluation->assessor;
                $evaId = $evaluation->evaId;

                if (in_array($evaId, $processedEvaluations)) {
                    continue;
                }
                $processedEvaluations[] = $evaId;

                if (!isset($marksByPloAndAssessor[$course->courseId][$plo][$assessorType])) {
                    $marksByPloAndAssessor[$course->courseId][$plo][$assessorType] = 0;
                }

                $filteredScores = $evaluationScores->filter(function ($score) use ($evaId) {
                    return $score->criteria->evaluation->evaId == $evaId;
                });

                $totalScore = 0;
                foreach ($filteredScores as $score) {
                    $weight = $score->criteria->weight;
                    $weightedScore = $score->score * $weight;
                    $totalScore += $weightedScore;
                }

                $marksByPloAndAssessor[$course->courseId][$plo][$assessorType] += $totalScore;
            }
        }

        return view('hop.evaluation.studentEvaluateDetails', compact('student', 'courses', 'marksByPloAndAssessor', 'allPlosByCourse', 'ploNames'));
    }
}
