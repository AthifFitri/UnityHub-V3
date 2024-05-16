@extends('layout')
@section('title', 'Edit Quiz Score')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Edit Quiz Score</h1>
        </div>

        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('coordinators.quizes.update', ['id' => $student->stuId, 'course' => $course]) }}"
                method="POST">
                @csrf
                @method('PUT')

                {{-- Student Name (Read-only) --}}
                <div class="mb-4">
                    <label for="student" class="block font-medium text-base text-gray-700">Student Name</label>
                    <input type="text" id="student" value="{{ $student->stuName }}" readonly
                        class="block w-full rounded-md p-1 bg-gray-100" disabled>
                </div>

                {{-- Course (Read-only) --}}
                <div class="mb-4">
                    <label for="course" class="block font-medium text-base text-gray-700">Course</label>
                    <input type="text" id="course" value="{{ $course }}" readonly
                        class="block w-full rounded-md p-1 bg-gray-100" disabled>
                </div>

                {{-- Student Score --}}
                <div class="mb-4">
                    <label for="score" class="block font-medium text-base text-gray-700">Student Score</label>
                    <input type="number" id="score" name="score" class="block w-full rounded-md p-1" min="0.0"
                        max="10.0" step="0.1" value="{{ $quiz ? $quiz->score : 0 }}" required>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Update
                    </button>
                    <a href="{{ route('coordinators.quizes.score', $student->stuId) }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
