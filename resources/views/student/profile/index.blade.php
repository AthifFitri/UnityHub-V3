@extends('layout')
@section('title', 'Profile')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-center text-3xl font-bold">Student Profile</h1>
        </div>
        <div class="max-w-xl mx-auto bg-gray-100 rounded-xl shadow-md overflow-hidden p-5">
            @if (session('success'))
                <div class="text-center bg-green-200 p-2 mb-4 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            <div class="flex">
                <!-- Icon Section (Left) -->
                <div class="md:flex-shrink-0 flex justify-center items-center text-black text-5xl p-6">
                    <i class="fas fa-user fa-2x"></i>
                </div>
                <!-- Information Section (Right) -->
                <div class="p-8 md:w-3/4">
                    <div class="uppercase tracking-wide text-sm text-gray-500 font-semibold">Full Name</div>
                    <h1 class="block mt-1 text-lg leading-tight font-medium text-black">{{ $student->stuName }}</h1>
                    <div class="mt-4">
                        <div class="uppercase tracking-wide text-sm text-gray-500 font-semibold">Supervisor</div>
                        @if ($student->supervisorDetails)
                            <p class="block mt-1 text-lg leading-tight font-medium text-black">
                                {{ $student->supervisorDetails->staffName }}</p>
                        @else
                            <div class="uppercase tracking-wide text-sm text-red-500 font-semibold">No Supervisor Assigned</div>
                        @endif
                    </div>
                    <div class="mt-4">
                        <div class="uppercase tracking-wide text-sm text-gray-500 font-semibold">Coach</div>
                        @if ($student->coachDetails)
                            <p class="block mt-1 text-lg leading-tight font-medium text-black">
                                {{ $student->coachDetails->coachName }}</p>
                        @else
                            <div class="uppercase tracking-wide text-sm text-red-500 font-semibold">No Coach Assigned</div>
                        @endif
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center">
                            <i class="fas fa-graduation-cap text-gray-500"></i>
                            <p class="ml-2 text-black">{{ $student->stuMatricNo }}</p>
                        </div>
                        <div class="flex items-center mt-2">
                            <i class="fas fa-phone-alt text-gray-500"></i>
                            <p class="ml-2 text-black">{{ $student->stuPhone }}</p>
                        </div>
                        <div class="flex items-center mt-2">
                            <i class="fas fa-envelope text-gray-500"></i>
                            <p class="ml-2 text-black">{{ $student->stuEmail }}</p>
                        </div>
                        <div class="flex items-center mt-2">
                            <i class="fas fa-industry text-gray-500"></i>
                            <p class="ml-2 text-black">{{ $student->coachDetails->industry->indName }}</p>
                        </div>
                    </div>
                    <!-- Add Update Profile Button -->
                    <div class="mt-8 justify-end">
                        <a href="{{ route('students.profile.edit') }}"
                            class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600">Update Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
