@extends('layout')
@section('title', 'Assign Coach')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Student Internship Information</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md mt-4">
            @if (session('success'))
                <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if ($students->count() > 0)
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-400 text-white">
                            <th class="border px-4 py-2">No.</th>
                            <th class="border px-4 py-2">Student Name</th>
                            <th class="border px-4 py-2">Matric No.</th>
                            <th class="border px-4 py-2">Phone Number</th>
                            <th class="border px-4 py-2">Email</th>
                            <th class="border px-4 py-2">Supervisor University</th>
                            <th class="border px-4 py-2">Supervisor Industry / Coach</th>
                            <th class="border px-4 py-2">Industry</th>
                            <th class="border px-4 py-2">Session</th>
                            <th class="border px-4 py-2">Assign / Change</th>
                        </tr>
                    </thead>
                    @foreach ($students as $student)
                        <tr class="text-center">
                            <td class="border px-4 py-2 w-3">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2 text-left w-60">{{ $student->stuName }}</td>
                            <td class="border px-4 py-2">{{ $student->stuMatricNo }}</td>
                            <td class="border px-4 py-2">{{ $student->stuPhone }}</td>
                            <td class="border px-4 py-2">{{ $student->stuEmail }}</td>
                            <td class="border px-4 py-2 text-left w-60">{{ $student->supervisorDetails->staffName }}</td>
                            @if ($student->coachDetails)
                                <td class="border px-4 py-2 text-left w-60">{{ $student->coachDetails->coachName }}</td>
                            @else
                                <td class="border px-4 py-2 text-red-500 text-left w-60">No Coach Assign</td>
                            @endif
                            <td class="border px-4 py-2 text-left w-60">{{ $student->coachDetails->industry->indName }}
                            </td>
                            <td class="border px-4 py-2 w-16">{{ $student->sessionDetails->sessionSemester }}
                                {{ $student->sessionDetails->sessionYear }}</td>
                            <td class="border px-4 py-2">
                                <div class="flex justify-center space-x-5">
                                    <a href="{{ route('coordinators.infos.assignCoach', $student->stuId) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Coach</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p class="text-gray-500 text-center">No student available.</p>
            @endif
        </div>
    </div>
@endsection
