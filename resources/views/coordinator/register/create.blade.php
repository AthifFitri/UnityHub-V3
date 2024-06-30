@extends('layout')
@section('title', 'Create New Coach')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Create Coach</h1>
        </div>
        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('registers.store') }}" method="POST">
                @csrf

                {{-- Coach Name --}}
                <div class="mb-4">
                    <label for="coachName" class="block font-medium text-base text-gray-700">Name</label>
                    <input type="text" name="coachName" id="coachName"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        value="{{ old('coachName') }}" required>
                </div>

                {{-- Coach Phone Number --}}
                <div class="mb-4">
                    <label for="coachPhone" class="block font-medium text-base text-gray-700">Phone Number</label>
                    <input type="number" name="coachPhone" id="coachPhone"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        value="{{ old('coachPhone') }}" required>
                </div>

                {{-- Coach Email --}}
                <div class="mb-4">
                    <label for="coachEmail" class="block font-medium text-base text-gray-700">Email</label>
                    <input type="email" name="coachEmail" id="coachEmail"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        value="{{ old('coachEmail') }}" required>
                </div>

                {{-- Coach Temporary Password --}}
                <div class="mb-4 relative">
                    <label for="coachPassword" class="block font-medium text-base text-gray-700">Password</label>
                    <input type="password" name="coachPassword" id="coachPassword"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        required>
                    <i class="absolute right-2 top-8 cursor-pointer text-gray-500 hover:text-gray-700"
                        onclick="togglePasswordVisibility('coachPassword', 'coachPasswordToggleIcon')">
                        <i id="coachPasswordToggleIcon" class="fas fa-eye"></i>
                    </i>
                    @error('coachPassword')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Coach Industry --}}
                <div class="mb-4">
                    <label for="indId" class="block font-medium text-base text-gray-700">Industry</label>
                    <select name="indId" id="indId"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                        required>
                        <option value="" disabled selected>Select type</option>
                        @foreach ($industries as $industry)
                            <option value="{{ $industry->indId }}">{{ $industry->indName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Create
                    </button>
                    <a href="{{ route('registers.index') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>
@endsection
