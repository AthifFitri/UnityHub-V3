@extends('layout')
@section('title', 'Quiz')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Student Quiz</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md mt-4">
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-400 text-white">
                        <th class="border px-4 py-2">No.</th>
                        <th class="border px-4 py-2">Student Name</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr class="text-center">
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $student->stuName }}</td>
                            <td class="border px-4 py-2">
                                <div class="flex justify-center space-x-5">
                                    <a href="{{ route('coordinators.quizes.score', $student->stuId) }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
