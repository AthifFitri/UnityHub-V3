@extends('layout')
@section('title', 'Logbook')
@section('content')
    <div class="container mx-auto p-4">
        <div class="my-5">
            <h1 class="text-3xl font-bold">Student Internship Logbook</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md overflow-x-auto">
            @if ($students->isEmpty())
                <p class="text-red-500 text-center">No students assigned to this supervisor!</p>
            @else
                <div class="flex flex-row">
                    <label for="stuId" class="block text-gray-600 mr-4">Student Name:</label>
                    <form action="{{ route('supervisors.logbooks.index') }}" method="GET">
                        <select name="stuId" id="stuId" onchange="this.form.submit()" class="select-input">
                            <option value="">Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->stuId }}"
                                    {{ request('stuId') == $student->stuId ? 'selected' : '' }}>
                                    {{ $student->stuName }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <div class="mb-4">
                    <p class="text-orange-500 text-xs mt-1">*Displaying only approved student logbook entries</p>
                </div>

                @if ($entries->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full border">
                            <thead>
                                <tr class="bg-gray-400 text-white">
                                    <th class="border px-4 py-2">Week</th>
                                    <th class="border px-4 py-2">Start Date</th>
                                    <th class="border px-4 py-2">End Date</th>
                                    <th class="border px-4 py-2">Attendance</th>
                                    <th class="border px-4 py-2">Proof</th>
                                    <th class="border px-4 py-2">Daily Activities</th>
                                    <th class="border px-4 py-2">Knowledge/Skills Gained</th>
                                    <th class="border px-4 py-2">Problems/Comments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($entries as $entry)
                                    <tr class="text-center">
                                        <td class="border px-4 py-2">{{ $entry->week }}</td>
                                        <td class="border px-4 py-2">{{ $entry->start_date }}</td>
                                        <td class="border px-4 py-2">{{ $entry->end_date }}</td>
                                        <td class="border px-4 py-2 w-52">
                                            <ul class="list-inside space-y-1">
                                                @foreach (json_decode($entry->attendance, true) as $day => $status)
                                                    <li class="flex items-center">
                                                        <span class="mr-2">{{ "Day $day:" }}</span>
                                                        <span>
                                                            @if ($status === 'present')
                                                                Present
                                                            @elseif ($status === 'public_holiday')
                                                                Public Holiday
                                                            @elseif ($status === 'annual_leave')
                                                                Annual Leave
                                                            @elseif ($status === 'medical_leave')
                                                                Medical Leave
                                                            @endif
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="border px-4 py-2">
                                            @php
                                                $attendanceRequiresProof = false;
                                                $attendanceStatuses = json_decode($entry->attendance, true);
                                                foreach ($attendanceStatuses as $status) {
                                                    if ($status === 'annual_leave' || $status === 'medical_leave') {
                                                        $attendanceRequiresProof = true;
                                                        break;
                                                    }
                                                }
                                            @endphp

                                            @if ($attendanceRequiresProof)
                                                @if ($entry->proof)
                                                    <a href="{{ asset('proof/' . $entry->proof) }}" target="_blank"
                                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">View</a>
                                                @else
                                                    <p class="text-red-500">No proof uploaded</p>
                                                @endif
                                            @else
                                                <p class="text-green-500">No proof needed</p>
                                            @endif
                                        </td>
                                        <td class="border px-4 py-2">{{ $entry->daily_activities }}</td>
                                        <td class="border px-4 py-2">{{ $entry->knowledge_skill }}</td>
                                        <td class="border px-4 py-2">{{ $entry->problem_comment }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    @if (request('stuId'))
                        <p class="text-gray-500 text-center">No approved logbook available for the selected student.</p>
                    @else
                        <p class="text-gray-500 text-center">Please select a student to view their logbook!</p>
                    @endif
                @endif
            @endif
            @if (request('stuId') && $entries->count() > 0)
                <div class="flex items-center justify-end mt-4">
                    <a href="{{ route('supervisors.evaluations.logbookEvaluate', request('stuId')) }}"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Evaluate
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
