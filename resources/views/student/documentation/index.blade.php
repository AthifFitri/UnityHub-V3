@extends('layout')
@section('title', 'Document')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Internship Documentation</h1>
        </div>

        <a href="{{ route('student.documents.create') }}"
            class="btn btn-primary inline-block ml-5 py-3 w-44 rounded-md text-center bg-blue-700 text-white hover:bg-blue-400 hover:text-black">Upload
            New Document</a>

        @if (session('success'))
            <div class="text-center bg-green-200 p-2 my-4 mx-auto rounded-md">
                {{ session('success') }}
            </div>
        @endif

        {{-- Loop through each document type --}}
        @foreach ($documentTypes as $docType => $displayName)
            {{-- Retrieve documents for the current type --}}
            @php
                $filteredDocuments = $documents->where('docType', $docType);
            @endphp

            <div class="px-4 mt-8">
                <div class="bg-gray-100 rounded-lg shadow-md">
                    <div class="bg-gray-300 p-2 rounded-t-md">
                        <h2 class="text-xl font-bold">{{ $displayName }}</h2>
                    </div>

                    <div class="pt-5 px-6">
                        {{-- Check if documents exist for the current type --}}
                        @if ($filteredDocuments->count() > 0)
                            <table class="w-full border-collapse border">
                                <thead>
                                    <tr class="bg-gray-400 text-white">
                                        <th class="border px-4 py-2">Document Name</th>
                                        <th class="border px-4 py-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Loop through documents --}}
                                    @foreach ($filteredDocuments as $document)
                                        <tr class="text-center bg-white">
                                            <td class="border px-4 py-2">{{ $document->docTitle }}</td>
                                            <td class="border px-4 py-2">
                                                <div class="flex justify-center space-x-5">
                                                    <a href="{{ route('student.documents.edit', $document->docId) }}"
                                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                                    <form
                                                        action="{{ route('student.documents.destroy', $document->docId) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                            onclick="return confirm('Are you sure you want to delete this document?');">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            {{-- Display message if no documents --}}
                            <p class="text-center text-gray-600 pb-4">No documents uploaded</p>
                        @endif
                    </div>

                    {{-- Display "View" button only if documents exist --}}
                    @if ($filteredDocuments->count() > 0)
                        <div class="flex justify-end p-4">
                            <a href="{{ asset('documents/' . $document->docContent) }}" target="_blank"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">View</a>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection
