@extends('layout')
@section('title', 'Logbook')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Create Logbook</h1>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div class="bg-slate-300 p-6 rounded-md shadow-md">
                <form action="{{ route('student.logbooks.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Logbook Week --}}
                    <div class="mb-4">
                        <label for="week" class="block font-medium text-base text-gray-700">Week</label>
                        <select name="week" id="week"
                            class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                            required>
                            <option value="" disabled selected>Select week</option>
                            @for ($i = 1; $i <= 26; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- Loogbook Start Date --}}
                    <div class="mb-4">
                        <label for="start_date" class="block font-medium text-base text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                            class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                            required>
                    </div>

                    {{-- Logbook End Date --}}
                    <div class="mb-4">
                        <label for="end_date" class="block font-medium text-base text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                            class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                            required>
                    </div>

                    {{-- Attendance --}}
                    <div class="mb-4">
                        <label for="attendance" class="block font-medium text-base text-gray-700">Attendance
                            <p class="text-orange-500 text-xs mb-2">* You have to upload your proof when you choose Annual
                                Leave / Medical Leave</p>
                        </label>
                        <div class="overflow-x-auto">
                            <table class="w-full border">
                                <thead>
                                    <tr>
                                        <th class="border px-4 py-2">Day</th>
                                        <th class="border px-4 py-2">Attendance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <tr>
                                            <td class="border px-4 py-2">Day {{ $i }}</td>
                                            <td class="border px-4 py-2">
                                                <select name="attendance[{{ $i }}]"
                                                    class="attendance-select block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                                                    required>
                                                    <option value="present">Present</option>
                                                    <option value="public_holiday">Public Holiday</option>
                                                    @if ($remainingAnnualLeave > 0)
                                                        <option value="annual_leave">Annual Leave</option>
                                                    @endif
                                                    <option value="medical_leave">Medical Leave</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Proof (If AL/MC choosen) --}}
                    <div class="mb-4" id="proofUpload">
                        <label for="proof" class="block font-medium text-base text-gray-700">Annual Leave/Medical
                            Certificate Proof
                            <p class="text-orange-500 text-xs mt-1">The maximum file size is 5mb</p>
                        </label>
                        <input type="file" name="proof" id="proof" accept=".pdf, .doc, .docx, .pptx"
                            class="block mt-1 w-auto rounded-md p-1">
                        @error('proof')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
            </div>

            <div class="bg-slate-300 p-6 rounded-md shadow-md">
                {{-- Activities --}}
                <div class="mb-4">
                    <label for="daily_activities" class="block font-medium text-base text-gray-700">Daily Activities</label>
                    <textarea name="daily_activities" id="daily_activities" rows="4"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        required></textarea>
                </div>

                {{-- Knowledge/Skills --}}
                <div class="mb-4">
                    <label for="knowledge_skill" class="block font-medium text-base text-gray-700">Knowledge/Skills
                        Gained</label>
                    <textarea name="knowledge_skill" id="knowledge_skill" rows="4"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        required></textarea>
                </div>

                {{-- Problem/Comments --}}
                <div class="mb-4">
                    <label for="problem_comment" class="block font-medium text-base text-gray-700">Problems/Comments</label>
                    <textarea name="problem_comment" id="problem_comment" rows="4"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        required></textarea>
                </div>

                {{-- Hidden Fields --}}
                <input type="hidden" name="timestamp" value="{{ now() }}">
                <input type="hidden" name="status" value="pending">

                <div class="flex items-center justify-center mt-4 col-span-2">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Create
                    </button>
                    <a href="{{ route('student.logbooks.index') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </div>

            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            // Function to calculate end date based on start date
            function calculateEndDate() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(startDate.getTime() + (4 * 24 * 60 * 60 * 1000)); // Add 4 days
                endDateInput.value = endDate.toISOString().split('T')[0];
            }

            // Add event listener for change event on start date input
            startDateInput.addEventListener('change', calculateEndDate);
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Get all attendance select elements
            const attendanceSelects = document.querySelectorAll('.attendance-select');

            // Get the proof upload field
            const proofUpload = document.getElementById('proofUpload');

            // Hide the proof upload field by default
            proofUpload.style.display = 'none';

            // Function to check attendance options
            function checkAttendance() {
                let showProof = false;
                attendanceSelects.forEach(select => {
                    if (select.value === 'annual_leave' || select.value === 'medical_leave') {
                        showProof = true;
                    }
                });

                proofUpload.style.display = showProof ? 'block' : 'none';
            }

            // Add event listeners for change events on attendance selects
            attendanceSelects.forEach(select => {
                select.addEventListener('change', checkAttendance);
            });
        });
    </script>
@endsection
