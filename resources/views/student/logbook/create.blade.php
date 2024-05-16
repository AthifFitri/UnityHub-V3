@extends('layout')
@section('title', 'Logbook')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Create Logbook</h1>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="bg-slate-300 p-6 rounded-md shadow-md">
                <form action="{{ route('logbooks.store') }}" method="POST">
                    @csrf

                    {{-- Logbook Week --}}
                    <div class="mb-4">
                        <label for="week" class="block font-medium text-base text-gray-700">Week</label>
                        <select name="week" id="week" class="block w-full rounded-md p-1" required>
                            <option value="" disabled selected>Select week</option>
                            @for ($i = 1; $i <= 26; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- Loogbook Start Date --}}
                    <div class="mb-4">
                        <label for="start_date" class="block font-medium text-base text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="block w-full rounded-md p-1"
                            required>
                    </div>

                    {{-- Logbook End Date --}}
                    <div class="mb-4">
                        <label for="end_date" class="block font-medium text-base text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" class="block w-full rounded-md p-1" required>
                    </div>

                    {{-- Attendance --}}
                    <div class="mb-4">
                        <label for="attendance" class="block font-medium text-base text-gray-700">Attendance</label>
                        <div class="overflow-x-auto">
                            <table class="w-full border">
                                <thead class="bg-white">
                                    <tr>
                                        <th class="border px-2 py-1">Day</th>
                                        <th class="border px-2 py-1">Present</th>
                                        <th class="border px-2 py-1">Absent</th>
                                        <th class="border px-2 py-1">Public Holiday</th>
                                        <th class="border px-2 py-1">Annual Leave</th>
                                        <th class="border px-2 py-1">Medical Leave</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <tr class="border">
                                            <td class="border px-2 py-1">Day {{ $i }}</td>
                                            <td class="border px-2 py-1"><input type="radio"
                                                    name="attendance[{{ $i }}]" value="present" required></td>
                                            <td class="px-2 py-1"><input type="radio"
                                                    name="attendance[{{ $i }}]" value="absent" required></td>
                                            <td class="border px-2 py-1"><input type="radio"
                                                    name="attendance[{{ $i }}]" value="public_holiday" required>
                                            </td>
                                            <td class="border px-2 py-1"><input type="radio"
                                                    name="attendance[{{ $i }}]" value="annual_leave" required>
                                            </td>
                                            <td class="border px-2 py-1"><input type="radio"
                                                    name="attendance[{{ $i }}]" value="medical_leave" required>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>

            </div>

            <div class="bg-slate-300 p-6 rounded-md shadow-md">
                {{-- Activities --}}
                <div class="mb-4">
                    <label for="daily_activities" class="block font-medium text-base text-gray-700">Daily Activities</label>
                    <textarea name="daily_activities" id="daily_activities" rows="4" class="block w-full rounded-md p-1" required></textarea>
                </div>

                {{-- Knowledge/Skills --}}
                <div class="mb-4">
                    <label for="knowledge_skill" class="block font-medium text-base text-gray-700">Knowledge/Skills
                        Gained</label>
                    <textarea name="knowledge_skill" id="knowledge_skill" rows="4" class="block w-full rounded-md p-1" required></textarea>
                </div>

                {{-- Problem/Comments --}}
                <div class="mb-4">
                    <label for="problem_comment" class="block font-medium text-base text-gray-700">Problems/Comments</label>
                    <textarea name="problem_comment" id="problem_comment" rows="4" class="block w-full rounded-md p-1" required></textarea>
                </div>

                {{-- Hidden Fields --}}
                <input type="hidden" name="timestamp" value="{{ now() }}">
                <input type="hidden" name="status" value="pending">
            </div>

            <div class="flex items-center justify-center mt-4 col-span-2">
                <button type="submit"
                    class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                    Create
                </button>
                <a href="{{ route('logbooks.index') }}"
                    class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                    onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                    Cancel
                </a>
            </div>
            </form>
        </div>
    </div>
@endsection
