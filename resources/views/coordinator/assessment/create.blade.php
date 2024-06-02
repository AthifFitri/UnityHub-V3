@extends('layout')
@section('title', 'Assessment')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Create Internship Assessment</h1>
        </div>

        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('coordinators.assessments.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="assessName" class="block font-medium text-base text-gray-700">Assessment Name</label>
                    <textarea name="assessName" id="assessName" rows="2" class="block w-full rounded-md p-1" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="assessDescription" class="block font-medium text-base text-gray-700">Assessment Description</label>
                    <textarea name="assessDescription" id="assessDescription" rows="4" class="block w-full rounded-md p-1"></textarea>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Create
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