@extends('layout')
@section('title', 'Register')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Industry Coach List</h1>
        </div>

        <a href="{{ route('registers.create') }}"
            class="btn btn-primary inline-block ml-5 py-3 w-44 rounded-md text-center bg-blue-700 text-white transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-400 hover:text-black">Create
            New Coach</a>

        <div class="bg-gray-100 p-6 rounded-md shadow-md mt-4">
            @if (session('success'))
                <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-row mb-4">
                <label for="filterIndustry" class="block text-gray-600 mr-4">Filter by Industry:</label>
                <form action="{{ route('registers.index') }}" method="GET">
                    <select name="industry" id="filterIndustry" onchange="this.form.submit()" class="select-input">
                        <option value="" {{ $selectedIndustry === null ? 'selected' : '' }}>All Industries</option>
                        @foreach ($industries as $industry)
                            <option value="{{ $industry->indId }}"
                                {{ $selectedIndustry == $industry->indId ? 'selected' : '' }}>
                                {{ $industry->indName }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            @if ($coaches->count() > 0)
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-400 text-white">
                            <th class="border px-4 py-2">No.</th>
                            <th class="border px-4 py-2">Coach Name</th>
                            <th class="border px-4 py-2">Coach Phone Number</th>
                            <th class="border px-4 py-2">Coach Email</th>
                            <th class="border px-4 py-2">Coach Industry</th>
                            <th class="border px-4 py-2">Resume</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coaches as $coach)
                            <tr class="text-center">
                                <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="border px-4 py-2 text-justify">{{ $coach->coachName }}</td>
                                <td class="border px-4 py-2">{{ $coach->coachPhone }}</td>
                                <td class="border px-4 py-2">{{ $coach->coachEmail }}</td>
                                <td class="border px-4 py-2 text-justify">{{ $coach->industry->indName }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex justify-center space-x-5">
                                        @if ($coach->coachResume == null)
                                            <p class="text-red-500 py-2">No resume uploaded.</p>
                                        @else
                                            <a href="{{ asset('resume/' . $coach->coachResume) }}" target="_blank"
                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">View</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 text-center">No coach available.</p>
            @endif
        </div>
    </div>
@endsection
