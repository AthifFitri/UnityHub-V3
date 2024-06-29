@extends('layout')
@section('title', 'Assessment')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Edit Internship Assessment</h1>
        </div>

        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('coordinators.assessments.update', $assessment->assessmentId) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="assessmentName" class="block font-medium text-base text-gray-700">Assessment Name</label>
                    <textarea name="assessmentName" id="assessmentName" rows="2"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        required>{{ $assessment->assessmentName }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="assessmentDescription" class="block font-medium text-base text-gray-700">Assessment
                        Description</label>
                    <textarea name="assessmentDescription" id="assessmentDescription" rows="4"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150">{{ $assessment->assessmentDescription }}</textarea>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Update
                    </button>
                    <a href="{{ route('coordinators.assessments.index') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
