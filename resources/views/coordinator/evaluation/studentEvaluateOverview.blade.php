@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold mb-4">Student Evaluation Overview</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md">
            <div class="flex justify-start">
                @foreach ($sessions as $session)
                    <button id="tab{{ $session->sessionId }}"
                        class="px-4 py-2 rounded-t-lg border transition duration-300 ease-in-out bg-gray-300"
                        onclick="switchTab('{{ $session->sessionId }}')">{{ $session->sessionSemester }}
                        {{ $session->sessionYear }}</button>
                @endforeach
            </div>

            <div class="p-5 bg-white rounded-b-md">
                @if (session('success'))
                    <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                @foreach ($sessions as $session)
                    <div id="session{{ $session->sessionId }}" class="session-content hidden">
                        <h2 class="text-xl font-bold mb-4">{{ $session->sessionSemester }} {{ $session->sessionYear }}</h2>

                        @if ($session->students->isEmpty())
                            <p class="text-gray-500 text-center">No students in this session!</p>
                        @else
                            @foreach ($session->students->groupBy('supervisorDetails.staffId') as $supervisorId => $students)
                                @php $supervisor = $students->first()->supervisorDetails; @endphp

                                <table class="w-full border mb-4">
                                    <thead>
                                        <tr class="bg-gray-400 text-white">
                                            <th class="border border-gray-300 p-2">University Supervisor</th>
                                            <th class="border border-gray-300 p-2">Student</th>
                                            <th class="border border-gray-300 p-2">Industry Supervisor / Coach</th>
                                            <th class="border border-gray-300 p-2">Detail Evaluation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $rowspan = count($students); @endphp
                                        @foreach ($students as $index => $student)
                                            @php $coach = $student->coachDetails; @endphp
                                            <tr class="text-justify">
                                                @if ($index === 0)
                                                    <td class="border px-4 py-2" rowspan="{{ $rowspan }}">
                                                        {{ $supervisor->staffName }}</td>
                                                @endif
                                                <td class="border px-4 py-2">{{ $student->stuName }}</td>
                                                <td class="border px-4 py-2">{{ $coach->coachName ?? '-' }}</td>
                                                <td class="border px-4 py-2">
                                                    <div class="flex justify-center space-x-5">
                                                        <a href="{{ route('coordinators.evaluations.studentEvaluateDetails', $student->stuId) }}"
                                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">View</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var activeTab = localStorage.getItem('activeSessionTab_studentEvaluateOverview');
            if (activeTab) {
                switchTab(activeTab);
            } else {
                var firstTab = document.querySelector('[id^="tab"]');
                if (firstTab) {
                    switchTab(firstTab.id.replace('tab', ''));
                }
            }
        });

        function switchTab(sessionId) {
            document.querySelectorAll('.session-content').forEach(function(content) {
                content.classList.add('hidden');
            });

            document.querySelectorAll('[id^="tab"]').forEach(function(button) {
                button.classList.remove('bg-blue-500', 'text-white');
                button.classList.add('bg-gray-300');
            });

            document.getElementById('session' + sessionId).classList.remove('hidden');
            document.getElementById('tab' + sessionId).classList.remove('bg-gray-300');
            document.getElementById('tab' + sessionId).classList.add('bg-blue-500', 'text-white');
            localStorage.setItem('activeSessionTab_studentEvaluateOverview', sessionId);
        }
    </script>
@endsection
