{{-- @extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5 text-center">
            <h1 class="text-3xl font-bold mb-4">Internship Evaluation</h1>
        </div>

        <div class="flex justify-center mb-5">
            <a href="{{ route('coordinators.evaluations.createUniversity') }}"
                class="btn btn-primary inline-block ml-5 py-3 w-60 rounded-md text-center bg-blue-700 text-white transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-400 hover:text-black">Create
                University Evaluation
            </a>
            <a href="{{ route('coordinators.evaluations.createIndustry') }}"
                class="btn btn-primary inline-block ml-5 py-3 w-60 rounded-md text-center bg-blue-700 text-white transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-400 hover:text-black">Create
                Industry Evaluation
            </a>
        </div>

        @if (session('success'))
            <div class="text-center bg-green-200 p-2 my-4 mx-auto rounded-md w-3/4 lg:w-1/2">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 m-4">
            @foreach ($courses as $course)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gray-300 p-3 rounded-t-md">
                        <h2 class="text-xl font-bold">{{ $course->courseCode }} - {{ $course->courseName }}</h2>
                    </div>
                    <div class="p-4">
                        <div class="mb-14">
                            <h3 class="text-center text-lg font-semibold mb-4 text-blue-700">University Evaluation</h3>
                            <div class="grid grid-cols-3 gap-4">
                                @forelse ($course->evaluations->where('evaType', 'University') as $evaluation)
                                    <div
                                        class="bg-blue-100 rounded-lg p-4 transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-200 relative group cursor-pointer">
                                        <h2 class="text-md font-semibold mb-2 text-blue-800">PLO{{ $evaluation->plo }}</h2>
                                        <p class="text-sm text-blue-600">Click to see the PLO{{ $evaluation->plo }} details
                                        </p>
                                        <div
                                            class="absolute top-0 right-0 m-2 flex space-x-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                            <button
                                                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>
                                            <button
                                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 font-medium text-sm">No PLO created</p>
                                @endforelse
                            </div>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-center text-lg font-semibold mb-4 text-green-700">Industry Evaluation</h3>
                            <div class="grid grid-cols-3 gap-4">
                                @forelse ($course->evaluations->where('evaType', 'Industry') as $evaluation)
                                    <div
                                        class="bg-green-100 rounded-lg p-4 transition duration-300 ease-in-out transform hover:scale-105 hover:bg-green-200 relative group cursor-pointer">
                                        <h2 class="text-md font-semibold mb-2 text-green-800">PLO{{ $evaluation->plo }}</h2>
                                        <p class="text-sm text-green-600">Click to see the PLO{{ $evaluation->plo }} details
                                        </p>
                                        <div
                                            class="absolute top-0 right-0 m-2 flex space-x-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                            <button
                                                class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>
                                            <button
                                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 font-medium text-sm">No PLO created</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection --}}

@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5 text-center">
            <h1 class="text-3xl font-bold mb-4">Internship Evaluation</h1>
        </div>

        <div class="flex justify-center mb-5">
            <a href="{{ route('coordinators.evaluations.createUniversity') }}"
                class="btn btn-primary inline-block ml-5 py-3 w-60 rounded-md text-center bg-blue-700 text-white transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-400 hover:text-black">Create
                University Evaluation
            </a>
            <a href="{{ route('coordinators.evaluations.createIndustry') }}"
                class="btn btn-primary inline-block ml-5 py-3 w-60 rounded-md text-center bg-blue-700 text-white transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-400 hover:text-black">Create
                Industry Evaluation
            </a>
        </div>

        @if (session('success'))
            <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 m-4">
            @foreach ($courses as $course)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="bg-gray-300 p-3 rounded-t-md">
                        <h2 class="text-xl font-bold">{{ $course->courseCode }} - {{ $course->courseName }}</h2>
                    </div>
                    <div class="p-4">
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold mb-4 text-blue-700">University Evaluation</h3>
                            <div class="grid grid-cols-3 gap-4">
                                @forelse ($course->evaluations->where('evaType', 'University')->sortBy('plo') as $evaluation)
                                    <a href="{{ route('coordinators.evaluations.ploDetails', $evaluation->evaId) }}"
                                        class="block bg-blue-100 rounded-lg p-4 transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-200 relative group cursor-pointer">
                                        <h2 class="text-md font-semibold mb-2 text-blue-800">PLO{{ $evaluation->plo }}</h2>
                                        <p class="text-sm text-blue-600">Click to see the PLO{{ $evaluation->plo }} details
                                        </p>
                                    </a>
                                @empty
                                    <p>No PLO created.</p>
                                @endforelse
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-green-700">Industry Evaluation</h3>
                            <div class="grid grid-cols-3 gap-4">
                                @forelse ($course->evaluations->where('evaType', 'Industry')->sortBy('plo') as $evaluation)
                                    <a href="{{ route('coordinators.evaluations.ploDetails', $evaluation->evaId) }}"
                                        class="block bg-green-100 rounded-lg p-4 transition duration-300 ease-in-out transform hover:scale-105 hover:bg-green-200 relative group cursor-pointer">
                                        <h2 class="text-md font-semibold mb-2 text-green-800">PLO{{ $evaluation->plo }}</h2>
                                        <p class="text-sm text-green-600">Click to see the PLO{{ $evaluation->plo }}
                                            details
                                        </p>
                                    </a>
                                @empty
                                    <p>No PLO created.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
