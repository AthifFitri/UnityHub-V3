@extends('layout')
@section('title', 'Session')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Create Internship Session</h1>
        </div>

        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('coordinators.sessions.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="sessionSemester" class="block font-medium text-base text-gray-700">Semester</label>
                    <select name="sessionSemester" id="sessionSemester"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500"
                        required>
                        <option value="" disabled selected>Select Semester</option>
                        @foreach (range(1, 5) as $semester)
                            <option value="Sem {{ $semester }}">Sem {{ $semester }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="sessionYear" class="block font-medium text-base text-gray-700">Year
                        <p class="text-orange-500 text-xs mb-1">Format: (YYYY/YYYY) only!</p>
                    </label>
                    <input type="text" name="sessionYear" id="sessionYear"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500"
                        maxlength="9" required>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Create
                    </button>
                    <a href="{{ route('coordinators.sessions.index') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('sessionYear').addEventListener('input', function(e) {
            let input = e.target.value.replace(/\D/g, '').substring(0, 8);
            let yearPart1 = input.substring(0, 4);
            let yearPart2 = input.substring(4, 8);
            if (input.length > 4) {
                e.target.value = `${yearPart1}/${yearPart2}`;
            } else {
                e.target.value = yearPart1;
            }
        });
    </script>
@endsection
