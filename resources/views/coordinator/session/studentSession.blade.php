@extends('layout')
@section('title', 'Session')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold mb-4">Student Internship Session</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md">
            <div class="flex justify-start">
                @foreach ($sessions as $session)
                    <button id="tab{{ $session->sessionId }}"
                        class="px-4 py-2 rounded-t-lg transition duration-300 ease-in-out bg-gray-300"
                        onclick="switchTab('{{ $session->sessionId }}')">{{ $session->sessionSemester }}
                        {{ $session->sessionYear }}</button>
                @endforeach
            </div>

            <form action="{{ route('coordinators.sessions.studentSession.update') }}" method="POST"
                onsubmit="return validateForm()">
                @csrf
                <div class="flex">
                    <div class="w-3/4 pr-4 bg-white p-6 rounded-md shadow-md overflow-auto max-h-[600px]">
                        @foreach ($sessions as $session)
                            <div id="session{{ $session->sessionId }}" class="session-content hidden">

                                <h2 class="text-xl font-bold mb-4">{{ $session->sessionSemester }}
                                    {{ $session->sessionYear }}</h2>

                                @if ($students->where('session', $session->sessionId)->isEmpty())
                                    <p class="text-gray-500 text-center">No students in this session!</p>
                                @else
                                    <table class="w-full border">
                                        <thead>
                                            <tr class="bg-gray-400 text-white">
                                                <th class="border px-4 py-2">No</th>
                                                <th class="border px-4 py-2">Student Name</th>
                                                <th class="border px-4 py-2">Current Session</th>
                                                <th class="border px-4 py-2">
                                                    <label for="select-all-{{ $session->sessionId }}"
                                                        class="mr-2 font-semibold">Select All</label>
                                                    <input type="checkbox" id="select-all-{{ $session->sessionId }}"
                                                        class="form-checkbox h-4 w-4 rounded text-blue-500 select-all">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students->where('session', $session->sessionId) as $student)
                                                <tr class="text-center">
                                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                                    <td class="border px-4 py-2">{{ $student->stuName }}</td>
                                                    <td class="border px-4 py-2">
                                                        {{ $student->sessionDetails ? $student->sessionDetails->sessionSemester . ' ' . $student->sessionDetails->sessionYear : 'N/A' }}
                                                    </td>
                                                    <td class="border px-4 py-2">
                                                        <input type="checkbox" name="students[]"
                                                            value="{{ $student->stuId }}"
                                                            class="form-checkbox h-4 w-4 student-checkbox">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="w-1/4 pl-4">
                        <div class="bg-white p-6 rounded-md shadow-md">
                            @if (session('success'))
                                <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <div class="mt-4">
                                <label for="session" class="block font-medium text-base text-gray-700">New Session</label>
                                <select name="session" id="session"
                                    class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500"
                                    required>
                                    <option value="" disabled selected>Select New Session</option>
                                    @foreach ($sessions as $session)
                                        <option value="{{ $session->sessionId }}">{{ $session->sessionSemester }}
                                            {{ $session->sessionYear }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update
                                    Sessions</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                switchTab(activeTab);
            } else {
                // Set the first tab as active if no active tab is stored
                var firstTab = document.querySelector('[id^="tab"]');
                if (firstTab) {
                    switchTab(firstTab.id.replace('tab', ''));
                }
            }

            document.querySelectorAll('.select-all').forEach(selectAllCheckbox => {
                selectAllCheckbox.addEventListener('click', function(event) {
                    const sessionContentId = selectAllCheckbox.id.replace('select-all-', 'session');
                    const checkboxes = document.querySelectorAll(
                        `#${sessionContentId} .student-checkbox`);
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = event.target.checked;
                    });
                });
            });
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
            localStorage.setItem('activeTab', sessionId);
        }

        function validateForm() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

            if (!isChecked) {
                alert('Please select at least one student.');
                return false;
            }
            return true;
        }
    </script>
@endsection
