@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold mb-4">Student Evaluation Details</h1>
        </div>

        <div class="p-4">
            <div class="flex justify-start">
                @foreach ($courses as $course)
                    <button id="tab{{ $course->courseId }}"
                        class="px-4 py-2 rounded-t-lg border transition duration-300 ease-in-out bg-gray-300"
                        onclick="switchCourseTab('{{ $course->courseId }}')">{{ $course->courseCode }}
                    </button>
                @endforeach
            </div>

            @foreach ($courses as $course)
                <div id="evaluation{{ $course->courseId }}" class="p-5 bg-gray-100 rounded-b-md hidden">
                    <h2 class="text-xl font-bold mb-4">{{ $course->courseCode }} - {{ $course->courseName }}</h2>

                    <div class="flex flex-row">
                        <p class="font-semibold text-base text-gray-700 mr-2">Student Name :</p>
                        <p class="flex-grow text-blue-500 font-medium text-base">{{ $student->stuName }}</p>
                    </div>
                    <div class="flex flex-row">
                        <p class="font-semibold text-base text-gray-700 mr-2">Supervisor Name :</p>
                        <p class="flex-grow text-blue-500 font-medium text-base">
                            {{ $student->supervisorDetails->staffName }}</p>
                    </div>
                    <div class="flex flex-row mb-4">
                        <p class="font-semibold text-base text-gray-700 mr-2">Coach Name :</p>
                        <p class="flex-grow text-blue-500 font-medium text-base">{{ $student->coachDetails->coachName }}</p>
                    </div>

                    <div class="bg-white">
                        <table class="w-full border mb-4">
                            <thead>
                                <tr class="bg-gray-400 text-white">
                                    <th class="border border-gray-300 p-2">PLO</th>
                                    <th class="border border-gray-300 p-2">Assessor Type</th>
                                    <th class="border border-gray-300 p-2">Mark Gained</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalMarks = 0;
                                    $ploData = [];
                                    $universityScores = [];
                                    $industryScores = [];
                                @endphp
                                @foreach ($allPlosByCourse[$course->courseId] as $plo)
                                    @php
                                        $universityScoreSum =
                                            $marksByPloAndAssessor[$course->courseId][$plo]['University'] ?? '0';
                                        $industryScoreSum =
                                            $marksByPloAndAssessor[$course->courseId][$plo]['Industry'] ?? '0';
                                        if (is_numeric($universityScoreSum) && is_numeric($industryScoreSum)) {
                                            $totalMarks += $universityScoreSum + $industryScoreSum;
                                        }
                                        $ploData[] = $ploNames[$plo] . ' (' . $plo . ')';
                                        $universityScores[] = $universityScoreSum;
                                        $industryScores[] = $industryScoreSum;
                                    @endphp
                                    <tr class="text-center bg-white">
                                        <td class="border px-4 py-2 bg-slate-50 w-1/3 text-justify" rowspan="2">
                                            {{ $ploNames[$plo] }} ({{ $plo }})
                                        </td>
                                        <td class="border px-4 py-2">University</td>
                                        <td class="border px-4 py-2">{{ $universityScoreSum }}</td>
                                    </tr>
                                    <tr class="text-center bg-slate-100">
                                        <td class="border px-4 py-2">Industry</td>
                                        <td class="border px-4 py-2">{{ $industryScoreSum }}</td>
                                @endforeach
                                <tr class="text-center">
                                    <td class="bg-gray-400 text-white font-bold text-right border px-4 py-2" colspan="2">
                                        Total Mark Gained
                                    </td>
                                    <td class="bg-gray-300 text-center text-green-500 font-bold border px-4 py-2">
                                        {{ $totalMarks }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-16 text-center border bg-white border-blue-300 rounded-lg p-6 shadow-lg">
                        <h2 class="text-xl font-bold mb-4">Student Evaluation Overview Graph</h2>
                        <div class="px-20">
                            <canvas id="chart{{ $course->courseId }}"></canvas>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('coordinators.evaluations.studentEvaluateOverview') }}"
                            class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black">Back</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @foreach ($courses as $course)
        @php
            $coursePloData = $allPlosByCourse[$course->courseId];
            $courseUniversityScores = [];
            $courseIndustryScores = [];
            $transformedPloData = [];

            foreach ($coursePloData as $ploId) {
                $ploName = $ploNames[$ploId] ?? "PLO {$ploId}";

                $label = "{$ploName} ({$ploId})";

                $transformedPloData[] = $label;

                $courseUniversityScores[] = $marksByPloAndAssessor[$course->courseId][$ploId]['University'] ?? 0;
                $courseIndustryScores[] = $marksByPloAndAssessor[$course->courseId][$ploId]['Industry'] ?? 0;
            }
        @endphp

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var activeCourseTab = localStorage.getItem('activeCourseTab_studentEvaluateDetails');
                if (activeCourseTab) {
                    switchCourseTab(activeCourseTab);
                } else {
                    var firstTab = document.querySelector('[id^="tab"]');
                    if (firstTab) {
                        switchCourseTab(firstTab.id.replace('tab', ''));
                    }
                }

                var ctx = document.getElementById('chart{{ $course->courseId }}').getContext('2d');
                var chartData = {
                    labels: @json($transformedPloData),
                    datasets: [{
                            label: 'University',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            data: @json($courseUniversityScores)
                        },
                        {
                            label: 'Industry',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            data: @json($courseIndustryScores)
                        }
                    ]
                };

                new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Program Learning Outcome (PLO)'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Student Score / Mark Gained (%)'
                                }
                            }
                        }
                    }
                });
            });

            function switchCourseTab(activeCourseTab) {
                document.querySelectorAll('[id^="evaluation"]').forEach(function(tab) {
                    tab.classList.add('hidden');
                });

                document.querySelectorAll('[id^="tab"]').forEach(function(button) {
                    button.classList.remove('bg-blue-500', 'text-white');
                    button.classList.add('bg-gray-300');
                });

                document.getElementById('evaluation' + activeCourseTab).classList.remove('hidden');
                document.getElementById('tab' + activeCourseTab).classList.remove('bg-gray-300');
                document.getElementById('tab' + activeCourseTab).classList.add('bg-blue-500', 'text-white');
                localStorage.setItem('activeCourseTab_studentEvaluateDetails', activeCourseTab);
            }
        </script>
    @endforeach
@endsection
