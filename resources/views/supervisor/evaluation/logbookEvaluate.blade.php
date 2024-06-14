@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Student Logbook Evaluation</h1>
        </div>

        <div class="p-4">
            <div class="flex justify-start">
                @foreach ($evaluationsGrouped as $courseCode => $evaluations)
                    <button id="tab{{ $courseCode }}"
                        class="px-4 py-2 rounded-t-lg border transition duration-300 ease-in-out bg-gray-300"
                        onclick="switchCourseTab('{{ $courseCode }}')">{{ $courseCode }}</button>
                @endforeach
            </div>

            @foreach ($evaluationsGrouped as $courseCode => $evaluations)
                <div id="evaluation{{ $courseCode }}" class="p-5 bg-gray-100 rounded-b-md hidden">

                    @if (session('success'))
                        <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h2 class="text-xl font-bold mb-4">{{ $courseCode }} - {{ $evaluations[0]->course->courseName }}</h2>

                    <div class="flex flex-row mb-4">
                        <p class="font-semibold text-base text-gray-700 mr-2">Student Name :</p>
                        <p class="flex-grow text-blue-500 font-medium text-base">
                            {{ $student->stuName }}</p>
                    </div>

                    @if ($plosByCourse[$courseCode]->isEmpty())
                        <p class="text-gray-500 text-center">No evaluation form created!</p>
                    @else
                        <div class="flex justify-start">
                            @foreach ($plosByCourse[$courseCode] as $index => $plo)
                                <button id="ploTab{{ $courseCode }}{{ $plo }}"
                                    class="px-4 py-2 rounded-t-lg border transition duration-300 ease-in-out bg-gray-300 {{ $index === 0 ? 'active-plo' : '' }}"
                                    onclick="switchPloTab('{{ $courseCode }}', '{{ $plo }}')">PLO
                                    {{ $plo }}</button>
                            @endforeach
                        </div>

                        @foreach ($plosByCourse[$courseCode] as $index => $plo)
                            <div id="ploEvaluation{{ $courseCode }}{{ $plo }}"
                                class="p-5 bg-white rounded-b-md {{ $index === 0 ? '' : 'hidden' }}">
                                <div id="studentEvaluations{{ $courseCode }}{{ $plo }}">

                                    <form
                                        action="{{ route('supervisors.evaluations.logbookEvaluate.store', $student->stuId) }}"
                                        method="POST">
                                        @csrf

                                        <input type="hidden" name="plo" value="{{ $plo }}">

                                        <div class="flex justify-between items-center mb-4">
                                            <div>
                                                <div class="flex flex-row">
                                                    <p class="font-semibold text-base text-gray-700 mr-2">Program Learning
                                                        Outcome (PLO):</p>
                                                    <p class="text-blue-500 font-medium text-base">{{ $plo }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center">
                                                <button type="submit"
                                                    class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">Submit
                                                </button>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <table class="w-full border">
                                                <thead>
                                                    <tr class="bg-gray-400 text-white">
                                                        <th class="border px-4 py-2">No.</th>
                                                        <th class="border px-4 py-2">Criteria</th>
                                                        <th class="border px-4 py-2">Weight</th>
                                                        <th class="border px-4 py-2">Poor <br> (1 Mark)</th>
                                                        <th class="border px-4 py-2">Weak <br> (2 Mark)</th>
                                                        <th class="border px-4 py-2">Moderate <br> (3 Mark)</th>
                                                        <th class="border px-4 py-2">Good <br> (4 Mark)</th>
                                                        <th class="border px-4 py-2">Excellent <br> (5 Mark)</th>
                                                        <th class="border px-4 py-2">Mark <br> Gained</th>
                                                        <th class="border px-4 py-2">Total Mark <br> (Max)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalMarkGained = 0;
                                                    @endphp
                                                    @foreach ($evaluations->where('plo', $plo) as $index => $evaluation)
                                                        @foreach ($evaluation->criteria as $criterion)
                                                            @php
                                                                $existingScore = isset(
                                                                    $existingEvaluations[request('stuId')],
                                                                )
                                                                    ? $existingEvaluations[request('stuId')]
                                                                            ->where('evaCriId', $criterion->evaCriId)
                                                                            ->first()->score ?? null
                                                                    : null;
                                                                $markGained = $existingScore
                                                                    ? $existingScore * $criterion->weight
                                                                    : 0;
                                                                $totalMarkGained += $markGained;
                                                            @endphp
                                                            <tr class="text-center">
                                                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                                                <td class="border px-4 py-2 text-justify w-96">
                                                                    {{ $criterion->criteria }}</td>
                                                                <td class="border px-4 py-2">
                                                                    {{ number_format($criterion->weight, 2) }}</td>
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <td class="border px-4 py-2">
                                                                        <input type="radio"
                                                                            name="criteria[{{ $criterion->evaCriId }}]"
                                                                            value="{{ $i }}" class="form-radio"
                                                                            {{ $existingScore == $i ? 'checked' : '' }}>
                                                                    </td>
                                                                @endfor
                                                                <td class="border px-4 py-2 text-orange-500">
                                                                    {{ $markGained ? number_format($markGained, 2) : '-' }}
                                                                </td>
                                                                <td class="border px-4 py-2">
                                                                    {{ number_format($criterion->weight * 5, 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @endforeach
                                                    <tr>
                                                        <td class="bg-gray-400 text-white font-bold text-right border px-4 py-2"
                                                            colspan="2">Total Weight / Max Mark</td>
                                                        <td class="bg-gray-300 text-center font-bold border px-4 py-2">
                                                            {{ number_format($evaluations->where('plo', $plo)->sum(function ($evaluation) {return $evaluation->criteria->sum('weight');}),2) }}
                                                        </td>
                                                        <td colspan="5" class="bg-gray-400 border px-4 py-2"></td>
                                                        <td
                                                            class="bg-gray-300 text-center text-green-500 font-bold border px-4 py-2">
                                                            {{ number_format($totalMarkGained, 2) }}</td>
                                                        <td class="bg-gray-300 text-center font-bold border px-4 py-2">
                                                            {{ number_format($evaluations->where('plo', $plo)->sum(function ($evaluation) {return $evaluation->criteria->sum('weight') * 5;}),2) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('supervisors.logbooks.index', ['stuId' => $student->stuId]) }}"
                            class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black">Back</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var activeCourseTab = localStorage.getItem('activeCourseTab_logbookEvaluateUni');
            var activePloTab = localStorage.getItem('activePloTab_logbookEvaluateUni');
            if (activeCourseTab) {
                switchCourseTab(activeCourseTab);
                if (activePloTab) {
                    switchPloTab(activeCourseTab, activePloTab);
                } else {
                    activateFirstPlo(activeCourseTab);
                }
            }
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
            localStorage.setItem('activeCourseTab_logbookEvaluateUni', activeCourseTab);

            activateFirstPlo(activeCourseTab);
        }

        function switchPloTab(courseCode, activePloTab) {
            document.querySelectorAll('#evaluation' + courseCode + ' > div[id^="ploEvaluation"]').forEach(function(tab) {
                tab.classList.add('hidden');
            });

            document.querySelectorAll('#evaluation' + courseCode + ' > div button[id^="ploTab"]').forEach(function(button) {
                button.classList.remove('bg-blue-500', 'text-white');
                button.classList.add('bg-gray-300');
            });

            document.getElementById('ploEvaluation' + courseCode + activePloTab).classList.remove('hidden');
            document.getElementById('ploTab' + courseCode + activePloTab).classList.remove('bg-gray-300');
            document.getElementById('ploTab' + courseCode + activePloTab).classList.add('bg-blue-500', 'text-white');
            localStorage.setItem('activePloTab_logbookEvaluateUni', activePloTab);
        }

        function activateFirstPlo(courseCode) {
            var firstPloTab = document.querySelector(`#evaluation${courseCode} button[id^="ploTab"]`);
            if (firstPloTab) {
                firstPloTab.click();
            }
        }
    </script>
@endsection
