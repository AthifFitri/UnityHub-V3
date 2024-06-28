@extends('layout')
@section('title', 'Material')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Internship Material</h1>
        </div>

        <a href="{{ route('coordinators.materials.create') }}"
            class="btn btn-primary inline-block ml-5 py-3 w-44 rounded-md text-center bg-blue-700 text-white transition duration-300 ease-in-out transform hover:scale-105 hover:bg-blue-400 hover:text-black">Upload
            New Material</a>

        <div class="bg-gray-100 p-6 rounded-md shadow-md mt-4">
            @if (session('success'))
                <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-row mb-4">
                <label for="filterMaterialType" class="block text-gray-600 mr-4">Filter by Material Type:</label>
                <form action="{{ route('coordinators.materials.index') }}" method="GET">
                    <select name="matType" id="filterMaterialType" onchange="this.form.submit()" class="select-input">
                        <option value="" {{ $selectedType === null ? 'selected' : '' }}>All Types</option>
                        <option value="rubric" {{ $selectedType === 'rubric' ? 'selected' : '' }}>Rubric</option>
                        <option value="guideline" {{ $selectedType === 'guideline' ? 'selected' : '' }}>Guideline</option>
                        <option value="others" {{ $selectedType === 'others' ? 'selected' : '' }}>Others</option>
                    </select>
                </form>
            </div>

            @if ($materials->count() > 0)
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-400 text-white">
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">Type</th>
                            <th class="border px-4 py-2">Title</th>
                            <th class="border px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $index => $material)
                            <tr class="text-center">
                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                <td class="border px-4 py-2">{{ $material->matType }}</td>
                                <td class="border px-4 py-2">{{ $material->matTitle }}</td>
                                <td class="border px-4 py-2">
                                    <div class="flex justify-center space-x-5">
                                        <a href="{{ asset('materials/' . $material->matContent) }}" target="_blank"
                                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">View</a>
                                        <a href="{{ route('coordinators.materials.edit', $material->matId) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                        <form action="{{ route('coordinators.materials.destroy', $material->matId) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                onclick="return confirm('Are you sure you want to delete this material?');">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 text-center">No materials available.</p>
            @endif
        </div>
    </div>
@endsection
