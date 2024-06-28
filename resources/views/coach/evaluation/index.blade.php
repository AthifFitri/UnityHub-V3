@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Student Overview Evaluation Score</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md">
            <div class="flex justify-start">
                @foreach ($evaluationsGrouped as $courseCode => $evaluations)
                    <button id="tab{{ $courseCode }}"
                        class="px-4 py-2 rounded-t-lg transition duration-300 ease-in-out bg-gray-300"
                        onclick="switchTab('{{ $courseCode }}')">{{ $courseCode }}</button>
                @endforeach
            </div>

            @foreach ($evaluationsGrouped as $courseCode => $evaluations)
                <div id="evaluation{{ $courseCode }}" class="p-5 bg-white rounded-b-md hidden">
                    <h2 class="text-xl font-bold mb-4">{{ $courseCode }} - {{ $evaluations[0]->course->courseName }}</h2>

                    <div id="studentEvaluations{{ $courseCode }}">
                        <div class="mb-4">
                            <table class="w-full border">
                                <thead>
                                    <tr class="bg-gray-400 text-white">
                                        <th class="border px-4 py-2">No.</th>
                                        <th class="border px-4 py-2">Student Name</th>
                                        @foreach ($assessmentByCourse[$courseCode] as $assessmentId => $assessmentName)
                                            <th class="border px-4 py-2">{{ $assessmentName }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr class="text-center">
                                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                            <td class="border px-4 py-2">{{ $student->stuName }}</td>
                                            @foreach ($assessmentByCourse[$courseCode] as $assessmentId => $assessmentName)
                                                @php
                                                    $key = $student->stuId . '_' . $courseCode . '_' . $assessmentId;
                                                    $studentMarks = $totalMarksByAssessment[$key] ?? '0';
                                                @endphp
                                                <td class="border px-4 py-2">
                                                    {{ number_format($studentMarks, 2) }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var activeTab = localStorage.getItem('activeTab_overviewEvaluateUni');
            if (activeTab) {
                switchTab(activeTab);
            }
        });

        function switchTab(activeTab) {
            document.querySelectorAll('[id^="evaluation"]').forEach(function(tab) {
                tab.classList.add('hidden');
            });

            document.querySelectorAll('[id^="tab"]').forEach(function(button) {
                button.classList.remove('bg-blue-500', 'text-white');
                button.classList.add('bg-gray-300');
            });

            document.getElementById('evaluation' + activeTab).classList.remove('hidden');
            document.getElementById('tab' + activeTab).classList.remove('bg-gray-300');
            document.getElementById('tab' + activeTab).classList.add('bg-blue-500', 'text-white');
            localStorage.setItem('activeTab_overviewEvaluateUni', activeTab);
        }
    </script>
@endsection
