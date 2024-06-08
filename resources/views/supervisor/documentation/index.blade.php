@extends('layout')
@section('title', 'Document')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Student Internship Documentation</h1>
        </div>

        <div class="bg-gray-100 shadow-md rounded-lg p-6">
            @if (session('success'))
                <div class="text-center bg-green-200 p-2 my-4 mx-auto rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col sm:flex-row items-center mb-6">
                <label for="stuId" class="block text-gray-700 mb-2 sm:mb-0 sm:mr-4">Student Name:</label>
                <form action="{{ route('supervisors.documents.index') }}" method="GET" class="w-full sm:w-auto flex-grow">
                    <select name="stuId" id="stuId" onchange="this.form.submit()"
                        class="w-full sm:w-auto select-input border-gray-300">
                        <option value="">Select Student</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->stuId }}"
                                {{ request('stuId') == $student->stuId ? 'selected' : '' }}>
                                {{ $student->stuName }}
                            </option>
                        @endforeach
                    </select>
                </form>
                @if (request('stuId'))
                    <a href="{{ route('supervisors.evaluations.documentEvaluate', request('stuId')) }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded sm:ml-4 mt-4 sm:mt-0">
                        Evaluate
                    </a>
                @endif
            </div>

            @if (request('stuId'))
                @foreach ($documentTypes as $docType => $displayName)
                    @php
                        $filteredDocuments = $documents->where('docType', $docType);
                    @endphp
                    <div class="mb-10">
                        <div class="bg-gray-200 rounded-lg shadow-md">
                            <div class="bg-gray-300 p-2 rounded-t-md">
                                <h2 class="text-xl font-bold">{{ $displayName }}</h2>
                            </div>

                            <div class="p-6">
                                @if ($filteredDocuments->count() > 0)
                                    <table class="w-full border-collapse border">
                                        <thead>
                                            <tr class="bg-gray-400 text-white">
                                                <th class="border px-4 py-2">Document Name</th>
                                                <th class="border px-4 py-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($filteredDocuments as $document)
                                                <tr class="text-center bg-white">
                                                    <td class="border px-4 py-2">{{ $document->docTitle }}</td>
                                                    <td class="border px-4 py-2">
                                                        <div class="flex justify-center space-x-5">
                                                            <a href="{{ asset('documents/' . $document->docContent) }}"
                                                                target="_blank"
                                                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                                View
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-center text-gray-500">No documents uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center text-gray-500">Please select a student to view their documents!</p>
            @endif
        </div>
    </div>
@endsection
