@extends('layout')
@section('title', 'Quiz')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Quiz Score</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md mt-4">
            @if (session('success'))
                <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-row mb-4">
                <p class="font-bold text-lg text-gray-700 mr-2">Student Name:</p>
                <p class="text-blue-500 font-semibold text-lg">{{ $student->stuName }}</p>
            </div>

            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-400 text-white">
                        <th class="border px-4 py-2">Course</th>
                        <th class="border px-4 py-2">Quiz Score (10%)</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courseScores as $courseScore)
                        <tr class="text-center">
                            <td class="border px-4 py-2">{{ $courseScore['course'] }}</td>
                            <td class="border px-4 py-2">{{ $courseScore['score'] }}</td>
                            <td class="border px-4 py-2">
                                <div class="flex justify-center space-x-5">
                                    <a href="{{ route('coordinators.quizes.edit', ['id' => $student->stuId, 'course' => $courseScore['course']]) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('coordinators.quizes.index') }}"
                    class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black">
                    Back
                </a>
            </div>
        </div>
    </div>
@endsection
