@extends('layout')
@section('title', 'Edit Uploaded Resume')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Edit Uploaded Resume</h1>
        </div>

        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('coaches.resume.update', $coach->coachId) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="coachResume" class="block font-medium text-base text-gray-700">Coach Resume
                        <p class="text-orange-500 text-xs mt-1">The maximum file size is 5mb</p>
                    </label>
                    <input type="file" name="coachResume" id="coachResume" accept=".pdf, .doc, .docx, .pptx"
                        class="block mt-1 w-auto rounded-md p-1" required>
                    @if ($coach->coachResume)
                        <p class="text-sm text-gray-600 my-2">Current File: <a
                                href="{{ asset('resume/' . $coach->coachResume) }}" target="_blank"
                                class="text-blue-600 hover:underline">View</a></p>
                    @endif
                    @error('coachResume')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Update
                    </button>
                    <a href="{{ route('coaches.resume.index') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
