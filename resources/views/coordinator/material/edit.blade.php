@extends('layout')
@section('title', 'Material')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Edit Material</h1>
        </div>
        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('coordinators.materials.update', $material->matId) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Material Type --}}
                <div class="mb-4">
                    <label for="matType" class="block font-medium text-base text-gray-700">Material Type</label>
                    <select name="matType" id="matType"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        required>
                        <option value="rubric" {{ $material->matType === 'rubric' ? 'selected' : '' }}>Rubric</option>
                        <option value="guideline" {{ $material->matType === 'guideline' ? 'selected' : '' }}>Guideline
                        </option>
                        <option value="others" {{ $material->matType === 'others' ? 'selected' : '' }}>Others</option>
                    </select>
                </div>

                {{-- Material Title --}}
                <div class="mb-4">
                    <label for="matTitle" class="block font-medium text-base text-gray-700">Material Title</label>
                    <textarea name="matTitle" id="matTitle" rows="2"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        required>{{ $material->matTitle }}</textarea>
                </div>

                {{-- Material Content --}}
                <div class="mb-4">
                    <label for="matContent" class="block font-medium text-base text-gray-700 mb-1">Material Content
                        <p class="text-orange-500 text-xs mt-1">The maximum file size is 5mb</p>
                    </label>
                    @if ($material->matContent)
                        <p class="text-sm text-gray-600 my-2">Current File: <a
                                href="{{ asset('materials/' . $material->matContent) }}" target="_blank"
                                class="text-blue-600 hover:underline">View</a></p>
                    @endif
                    <input type="file" name="matContent" id="matContent" accept=".pdf, .doc, .docx, .pptx"
                        class="block w-full rounded-md p-2 border border-gray-300">
                    @error('matContent')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Update
                    </button>
                    <a href="{{ route('coordinators.materials.index') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
