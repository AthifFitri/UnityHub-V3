@extends('layout')
@section('title', 'Logbook')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Internship Logbook</h1>
        </div>

        <a href="{{ route('student.logbooks.create') }}"
            class="btn btn-primary inline-block ml-5 py-3 w-52 rounded-md text-center bg-blue-700 text-white transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-400 hover:text-black">
            Create New Logbook
        </a>

        <div class="bg-gray-100 p-6 rounded-md shadow-md mt-4">
            @if (session('success'))
                <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex mb-5">
                <p class="font-bold mr-2">Remaining Annual Leave: </p>
                <p class="font-semibold text-orange-500">{{ $remainingAnnualLeave }}</p>
            </div>

            @if ($entries->count() > 0)
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-400 text-white">
                            <th class="border px-4 py-2">Week</th>
                            <th class="border px-4 py-2">Start Date</th>
                            <th class="border px-4 py-2">End Date</th>
                            <th class="border px-4 py-2">Attendance</th>
                            <th class="border px-4 py-2">Proof</th>
                            <th class="border px-4 py-2">Daily Activities</th>
                            <th class="border px-4 py-2">Knowledge / Skills Gained</th>
                            <th class="border px-4 py-2">Problems / Comments</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entries as $entry)
                            <tr class="text-center">
                                <td class="border px-4 py-2 w-8">{{ $entry->week }}</td>
                                <td class="border px-4 py-2 w-32">{{ $entry->start_date }}</td>
                                <td class="border px-4 py-2 w-32">{{ $entry->end_date }}</td>
                                <td class="border px-4 py-2 w-52">
                                    <ul class="list-inside space-y-1">
                                        @foreach (json_decode($entry->attendance, true) as $day => $status)
                                            <li class="flex items-center">
                                                <span class="mr-2 font-semibold">{{ "Day $day:" }}</span>
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
                                <td class="border px-4 py-2 w-10">
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
                                <td class="border px-4 py-2 w-44">{{ $entry->daily_activities }}</td>
                                <td class="border px-4 py-2 w-60">{{ $entry->knowledge_skill }}</td>
                                <td class="border px-4 py-2 w-60">{{ $entry->problem_comment }}</td>
                                <td class="border px-4 py-2 w-10">
                                    <span
                                        style="background-color: {{ $entry->status === 'pending' ? '#EF4444' : '#10B981' }}"
                                        class="rounded-full px-3 py-1 text-sm font-semibold text-white hover:bg-opacity-75 transition duration-300 ease-in-out"
                                        title="{{ ucfirst($entry->status) }}">
                                        {{ ucfirst($entry->status) }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2 w-10">
                                    @if ($entry->status === 'pending')
                                        <a href="{{ route('student.logbooks.edit', $entry->logId) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    @else
                                        <p class="text-blue-500">No action required</p>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 text-center">No logbook available.</p>
            @endif
        </div>
    </div>
@endsection
