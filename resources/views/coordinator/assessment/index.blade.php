@extends('layout')
@section('title', 'Assessment')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold mb-4">Internship Assessment</h1>
        </div>

        <a href="{{ route('coordinators.assessments.create') }}"
            class="btn btn-primary inline-block ml-5 py-3 w-52 rounded-md text-center bg-blue-700 text-white transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-400 hover:text-black">Create
            New Assessment
        </a>

        <div class="bg-gray-100 p-6 rounded-md shadow-md mt-4">
            @if (session('success'))
                <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md ">
                    {{ session('success') }}
                </div>
            @endif

            @if ($assessments->count() > 0)
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-400 text-white">
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Assessment Name</th>
                            <th class="border px-4 py-2">Description</th>
                            <th class="border px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assessments as $assessment)
                            <tr class="text-center">
                                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2">{{ $assessment->assessmentName }}</td>
                                <td class="border px-4 py-2">{{ $assessment->assessmentDescription ?? '-' }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex justify-center space-x-5">
                                        <a href="{{ route('coordinators.assessments.edit', $assessment->assessmentId) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                        <form
                                            action="{{ route('coordinators.assessments.destroy', $assessment->assessmentId) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                onclick="return confirm('Are you sure you want to delete this assessment?');">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 text-center">No assessment available.</p>
            @endif
        </div>
    </div>
@endsection
