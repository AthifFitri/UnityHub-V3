@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold mb-4">PLO Details</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md mt-4">
            @if (session('success'))
                <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            <div class="flex justify-between mb-4">
                <div>
                    @if ($evaluation->course)
                        <div class="flex flex-row">
                            <p class="font-semibold text-base text-gray-700 mr-2">Course :</p>
                            <p class="text-blue-500 font-medium text-base">{{ $evaluation->course->courseCode }} -
                                {{ $evaluation->course->courseName }}</p>
                        </div>
                    @else
                        <div class="flex flex-row">
                            <p class="font-semibold text-base text-gray-700 mr-2">Course :</p>
                            <p class="text-red-500 font-medium text-base">Course not found</p>
                        </div>
                    @endif
                    <div class="flex flex-row">
                        <p class="font-semibold text-base text-gray-700 mr-2">Evaluation Type :</p>
                        <p class="text-blue-500 font-medium text-base">{{ $evaluation->evaType }} Evaluation</p>
                    </div>
                    <div class="flex flex-row items-center">
                        <p class="font-semibold text-base text-gray-700 mr-2">Program Learning Outcome (PLO) :</p>
                        <p class="text-blue-500 font-medium text-base">{{ $evaluation->plo }}</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('coordinators.evaluations.addCriteria', $evaluation->evaId) }}"
                        class="text-blue-700 cursor-pointer"><i class="fas fa-plus-circle"></i> Add more criteria</a>
                </div>
            </div>

            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-400 text-white">
                        <th class="border px-4 py-2">No.</th>
                        <th class="border px-4 py-2">Criteria</th>
                        <th class="border px-4 py-2">Weight</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evaluation->criteria as $index => $criteria)
                        <tr class="text-center">
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2">{{ $criteria->criteria }}</td>
                            <td class="border px-4 py-2">{{ $criteria->weight }}</td>
                            <td class="border px-4 py-2">
                                <div class="flex justify-center space-x-5">
                                    <a href="{{ route('coordinators.evaluations.editCriteria', $criteria->evaCriId) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    <form
                                        action="{{ route('coordinators.evaluations.destroyCriteria', $criteria->evaCriId) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                            onclick="return confirm('Are you sure you want to delete this criteria?');">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('coordinators.evaluations.index') }}"
                    class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black">
                    Back
                </a>
            </div>
        </div>
    </div>
@endsection