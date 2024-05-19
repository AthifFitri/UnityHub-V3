@extends('layout')
@section('title', 'Edit Profile')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Edit Profile</h1>
        </div>
        <div class="max-w-md mx-auto bg-gray-300 p-6 rounded-md shadow-md">
            <form action="{{ route('coaches.profile.update') }}" method="POST">
                @csrf

                {{-- Student Name --}}
                <div class="mb-4">
                    <label for="coachName" class="block font-medium text-base text-gray-700">Full Name</label>
                    <input type="text" name="coachName" id="coachName" class="block w-full rounded-md p-1"
                        value="{{ $coach->coachName }}" required>
                </div>

                {{-- Student Phone Number --}}
                <div class="mb-4">
                    <label for="coachPhone" class="block font-medium text-base text-gray-700">Phone Number</label>
                    <input type="text" name="coachPhone" id="coachPhone" class="block w-full rounded-md p-1"
                        value="{{ $coach->coachPhone }}" required>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Update
                    </button>
                    <a href="{{ route('coaches.profile.index') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
