@extends('layout')
@section('title', 'Quiz')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Internship Quiz</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md mt-4">
            <div class="flex justify-between mb-4">
                <div>
                    <div class="flex flex-row">
                        <p class="font-semibold text-base text-gray-700 mr-2">Student Name :</p>
                        <p class="text-blue-500 font-medium text-base">{{ $student->stuName }}</p>
                    </div>
                </div>
            </div>
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-400 text-white">
                        <th class="border px-4 py-2">Course</th>
                        <th class="border px-4 py-2">Score (10%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        @php
                            $quiz = $student->quizzes->where('courseId', $course->courseId)->first();
                            $score = $quiz ? $quiz->score : '0.00';
                        @endphp
                        <tr class="text-center">
                            <td class="border px-4 py-2">{{ $course->courseCode }}</td>
                            <td class="border px-4 py-2">{{ number_format($score, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
