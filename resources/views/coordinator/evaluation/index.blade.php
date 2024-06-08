@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5 text-center">
            <h1 class="text-3xl font-bold mb-4">Internship Evaluation</h1>
        </div>

        <div class="flex justify-center mb-5">
            <a href="{{ route('coordinators.evaluations.createUniversity') }}"
                class="btn btn-primary inline-block py-3 w-60 rounded-md text-center bg-blue-700 text-white transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-400 hover:text-black">Create
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
                            @php
                                $universityEvaluations = $course->evaluations
                                    ->where('assessor', 'University')
                                    ->groupBy('assessmentId');
                                $sortedUniversityEvaluations = $universityEvaluations->sortBy(
                                    fn($group, $key) => $group->first()->assessment->assessmentName,
                                );
                            @endphp
                            @if ($sortedUniversityEvaluations->isEmpty())
                                <p class="text-gray-500">No assessment created.</p>
                            @else
                                @foreach ($sortedUniversityEvaluations as $assessmentId => $evaluations)
                                    <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-300 rounded-lg">
                                        <h4 class="text-md font-semibold text-gray-600 mb-2">
                                            {{ $evaluations->first()->assessment->assessmentName }}</h4>
                                        <div class="grid grid-cols-3 gap-4">
                                            @foreach ($evaluations as $evaluation)
                                                <div class="relative group">
                                                    <a href="{{ route('coordinators.evaluations.ploDetails', $evaluation->evaId) }}"
                                                        class="block bg-blue-100 rounded-lg p-4 transition duration-300 ease-in-out transform group-hover:scale-105 hover:bg-blue-200 cursor-pointer">
                                                        <h2 class="text-md font-semibold mb-2 text-blue-800">
                                                            PLO{{ $evaluation->plo }}</h2>
                                                        <p class="text-sm text-blue-600">Click to see the
                                                            PLO{{ $evaluation->plo }} details</p>
                                                    </a>
                                                    <div class="absolute top-2 right-2 hidden group-hover:flex">
                                                        <form
                                                            action="{{ route('coordinators.evaluations.destroyPlo', $evaluation->evaId) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="bg-red-500 hover:bg-red-700 text-white font-medium py-1 px-2 rounded-md"
                                                                onclick="return confirm('Are you sure you want to delete this plo?');">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-green-700">Industry Evaluation</h3>
                            @php
                                $industryEvaluations = $course->evaluations
                                    ->where('assessor', 'Industry')
                                    ->groupBy('assessmentId');
                                $sortedIndustryEvaluations = $industryEvaluations->sortBy(
                                    fn($group, $key) => $group->first()->assessment->assessmentName,
                                );
                            @endphp
                            @if ($sortedIndustryEvaluations->isEmpty())
                                <p class="text-gray-500">No assessment created.</p>
                            @else
                                @foreach ($sortedIndustryEvaluations as $assessmentId => $evaluations)
                                    <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-300 rounded-lg">
                                        <h4 class="text-md font-semibold text-gray-600 mb-2">
                                            {{ $evaluations->first()->assessment->assessmentName }}</h4>
                                        <div class="grid grid-cols-3 gap-4">
                                            @foreach ($evaluations as $evaluation)
                                                <div class="relative group">
                                                    <a href="{{ route('coordinators.evaluations.ploDetails', $evaluation->evaId) }}"
                                                        class="block bg-green-100 rounded-lg p-4 transition duration-300 ease-in-out transform group-hover:scale-105 hover:bg-green-200 cursor-pointer">
                                                        <h2 class="text-md font-semibold mb-2 text-green-800">
                                                            PLO{{ $evaluation->plo }}</h2>
                                                        <p class="text-sm text-green-600">Click to see the
                                                            PLO{{ $evaluation->plo }} details</p>
                                                    </a>
                                                    <div class="absolute top-2 right-2 hidden group-hover:flex">
                                                        <form
                                                            action="{{ route('coordinators.evaluations.destroyPlo', $evaluation->evaId) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="bg-red-500 hover:bg-red-700 text-white font-medium py-1 px-2 rounded-md"
                                                                onclick="return confirm('Are you sure you want to delete this plo?');">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
