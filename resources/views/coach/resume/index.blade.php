@extends('layout')
@section('title', 'Resume')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Coach Resume</h1>
        </div>

        @if (!$coach->coachResume)
            <a href="{{ route('coaches.resume.create') }}"
                class="btn btn-primary inline-block ml-5 py-3 w-44 rounded-md text-center bg-blue-700 text-white hover:bg-blue-400 hover:text-black">Upload
                Resume</a>
        @endif

        <div class="px-4 mt-8">
            @if (session('success'))
                <div class="text-center bg-green-200 p-2 my-4 mx-auto rounded-md ">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gray-100 rounded-lg shadow-md">
                <div class="bg-gray-300 p-2 rounded-t-md">
                    <h2 class="text-xl font-bold">Resume Uploaded</h2>
                </div>

                <div class="pt-5 px-6">
                    @if ($coach->coachResume)
                        <table class="w-full border-collapse border">
                            <thead>
                                <tr class="bg-gray-400 text-white">
                                    <th class="border px-4 py-2">Resume Name</th>
                                    <th class="border px-4 py-2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center bg-white">
                                    <td class="border px-4 py-2">{{ $coach->coachResume }}</td>
                                    <td class="border px-4 py-2">
                                        <div class="flex justify-center space-x-5">
                                            <a href="{{ route('coaches.resume.edit', $coach->coachId) }}"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                            <form action="{{ route('coaches.resume.destroy', $coach->coachId) }}"
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
                            </tbody>
                        </table>
                        <div class="flex justify-end p-4">
                            <a href="{{ asset('resume/' . $coach->coachResume) }}" target="_blank"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">View</a>
                        </div>
                    @else
                        <p class="text-center text-gray-600 pb-4">No resume uploaded</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
