@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class=" text-center text-3xl font-bold mb-4">Edit Criteria</h1>
        </div>

        <div class="max-w-screen-sm mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('coordinators.evaluations.updateCriteria', $criteria->evaCriId) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="flex flex-row space-x-5 items-start">
                    <div class="basis-1/2">
                        <div class="mb-4">
                            <label for="criteria" class="block font-medium text-base text-gray-700">Criteria</label>
                            <textarea name="criteria" id="criteria" rows="4"
                                class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                                required>{{ $criteria->criteria }}</textarea>
                        </div>
                    </div>
                    <div class="basis-1/2">
                        <div class="mb-4">
                            <label for="weight" class="block font-medium text-base text-gray-700">Weight</label>
                            <input type="number" id="weight" name="weight"
                                class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                                min="0.0" max="10.0" step="0.1" value="{{ $criteria->weight }}" required>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Update
                    </button>
                    <a href="{{ route('coordinators.evaluations.ploDetails', $criteria->evaId) }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
