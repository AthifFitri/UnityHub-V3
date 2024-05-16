@extends('layout')
@section('title', 'Document')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Edit Document</h1>
        </div>
        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('student.documents.update', $document->docId) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Document Type (Read-only) --}}
                <div class="mb-4">
                    <label for="docType" class="block font-medium text-base text-gray-700">Document Type
                        <p class="text-orange-500 text-xs mb-1">You are currently editing this document</p>
                    </label>
                    <input type="text" id="docType" value="{{ $documentTypes[$document->docType] ?? '' }}" readonly
                        class="block w-full rounded-md p-1 bg-gray-100" disabled>
                </div>

                {{-- Document Title --}}
                <div class="mb-4">
                    <label for="docTitle" class="block font-medium text-base text-gray-700">Document Title</label>
                    <textarea type="text" name="docTitle" id="docTitle" rows="2" class="block w-full rounded-md p-1" required>{{ $document->docTitle }}</textarea>
                </div>

                {{-- Document Content --}}
                <div class="mb-4">
                    <label for="docContent" class="block font-medium text-base text-gray-700">Document Content
                        <p class="text-orange-500 text-xs mt-1">The maximum file size is 5mb</p>
                    </label>
                    @if ($document->docContent)
                        <p class="text-sm text-gray-600 my-2">Current File: <a
                                href="{{ asset('documents/' . $document->docContent) }}" target="_blank"
                                class="text-blue-600 hover:underline">View</a></p>
                    @endif
                    <input type="file" name="docContent" id="docContent" accept=".pdf, .doc, .docx, .pptx"
                        class="block mt-1 w-auto rounded-md p-1">
                    @error('matContent')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Update
                    </button>
                    <a href="{{ route('student.documents.index') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
