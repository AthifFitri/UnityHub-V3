@extends('layout')
@section('title', 'Course')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Create Internship Course</h1>
        </div>

        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('coordinators.courses.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="session" class="block font-medium text-base text-gray-700">Session</label>
                    <select name="session" id="session"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500"
                        required>
                        <option value="" disabled selected>Select Session</option>
                        @foreach ($sessions as $session)
                            <option value="{{ $session->sessionId }}">{{ $session->sessionSemester }}
                                {{ $session->sessionYear }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="courseCode" class="block font-medium text-base text-gray-700">Course Code</label>
                    <input type="text" name="courseCode" id="courseCode"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        required>
                </div>

                <div class="mb-4">
                    <label for="courseName" class="block font-medium text-base text-gray-700">Course Name</label>
                    <textarea name="courseName" id="courseName" rows="2"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        required></textarea>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Create
                    </button>
                    <a href="{{ route('coordinators.courses.index') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
