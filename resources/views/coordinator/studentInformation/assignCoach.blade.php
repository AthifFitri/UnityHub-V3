@extends('layout')
@section('title', 'Assign Coach')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Assign New Coach</h1>
        </div>

        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('coordinators.infos.updateCoach', $student->stuId) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="student" class="block font-medium text-base text-gray-700">Student Name</label>
                    <input type="text" id="student" value="{{ $student->stuName }}" readonly
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150">
                </div>

                <div class="mb-4">
                    <label for="matric" class="block font-medium text-base text-gray-700">Student Matric No</label>
                    <input type="text" id="matric" value="{{ $student->stuMatricNo }}" readonly
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150">
                </div>

                <div class="mb-4">
                    <label for="coach" class="block font-medium text-base text-gray-700">Select New Coach</label>
                    <select name="coachId" id="coach"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500">
                        <option value="" disabled selected>Select New Coach</option>
                        @foreach ($coaches as $coach)
                            <option value="{{ $coach->coachId }}"
                                {{ $student->coachId == $coach->coachId ? 'selected' : '' }}>
                                {{ $coach->coachName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Update
                    </button>
                    <a href="{{ route('coordinators.infos.index', $student->stuId) }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
