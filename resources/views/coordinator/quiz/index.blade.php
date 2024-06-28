@extends('layout')
@section('title', 'Quiz')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Student Quiz</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md mt-4">
            @if (session('success'))
                <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-400 text-white">
                        <th class="border px-4 py-2">No.</th>
                        <th class="border px-4 py-2">Student Name</th>
                        <th class="border px-4 py-2">Course</th>
                        <th class="border px-4 py-2">Score (10%)</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        @php
                            $rowCount = $courses->count();
                        @endphp
                        @foreach ($courses as $course)
                            @php
                                $quiz = $student->quizzes->where('courseId', $course->courseId)->first();
                                $score = $quiz ? $quiz->score : '0.00';
                            @endphp
                            <tr class="text-center {{ $loop->even ? 'bg-slate-100' : 'bg-white' }}">
                                @if ($loop->first)
                                    <td class="border px-4 py-2 bg-gray-100" rowspan="{{ $rowCount }}">
                                        {{ $loop->parent->iteration }}</td>
                                    <td class="border px-4 py-2 bg-gray-100" rowspan="{{ $rowCount }}">
                                        {{ $student->stuName }}</td>
                                @endif
                                <td class="border px-4 py-2">{{ $course->courseCode }}</td>
                                <td class="border px-4 py-2">{{ number_format($score, 2) }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex justify-center space-x-5">
                                        <a href="{{ route('coordinators.quizes.edit', ['stuId' => $student->stuId, 'courseId' => $course->courseId]) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
