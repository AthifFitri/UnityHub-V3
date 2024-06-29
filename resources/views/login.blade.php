@extends('layout')
@section('title', 'Login')
@section('content')
    <div class="flex-grow flex flex-row justify-center items-center">
        {{-- Left Section --}}
        <div class="text-center m-10">
            <h1 class="text-3xl font-bold">Welcome to 2u2i UnityHub!</h1>
            <h2 class="text-xl font-medium text-orange-500">Transforming Internships Journeys Where Students Shine</h2>
        </div>

        {{-- Right Section --}}
        <div class="m-10">
            <div class="w-96 mx-auto">
                <div class="p-5 text-center">
                    <h1 class="text-4xl font-bold">Login</h1>
                </div>
                <div class="bg-slate-300 rounded-3xl px-16 py-10">

                    {{-- Error or Success message --}}
                    @if (session()->has('error'))
                        <div class="pb-2 text-red-500">{{ session('error') }}</div>
                    @elseif (session()->has('success'))
                        <div class="pb-2 text-green-500">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('loginPost') }}" method="POST">
                        @csrf

                        {{-- Role Selection --}}
                        <div class="mt-4 mb-4">
                            <label class="block font-medium text-base text-gray-700">Role</label>
                            <div class="flex">
                                <label class="inline-flex items-center mr-4">
                                    <input class="cursor-pointer" type="radio" name="role" value="student" required />
                                    <span class="ms-2 text-sm text-gray-600">Student</span>
                                </label>
                                <label class="inline-flex items-center mr-4">
                                    <input class="cursor-pointer" type="radio" name="role" value="staff" required />
                                    <span class="ms-2 text-sm text-gray-600">Staff</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input class="cursor-pointer" type="radio" name="role" value="coach" required />
                                    <span class="ms-2 text-sm text-gray-600">Industry</span>
                                </label>
                            </div>
                        </div>

                        {{-- Email Address --}}
                        <div>
                            <label class="block font-medium text-base text-gray-700" for="email">Email</label>
                            <input id="email"
                                class="block w-full rounded-md p-1 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                                type="email" name="email" required />
                        </div>

                        {{-- Password --}}
                        <div class="mt-4 relative">
                            <label class="block font-medium text-base text-gray-700" for="password">Password</label>
                            <input id="password"
                                class="block w-full rounded-md p-1 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                                type="password" name="password" required />
                            <i class="absolute right-2 top-7 cursor-pointer text-gray-500 hover:text-gray-700"
                                onclick="togglePasswordVisibility('password', 'passwordToggleIcon')">
                                <i id="passwordToggleIcon" class="fas fa-eye"></i>
                            </i>
                        </div>

                        {{-- Position Dropdown (visible only if role is staff) --}}
                        <div id="positionSection" class="mt-4 mb-4 hidden">
                            <label class="block font-medium text-base text-gray-700">Position</label>
                            <select name="position" class="block w-full rounded-md p-1">
                                <option value="" disabled selected>Select your position</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->posId }}">{{ $position->posName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-start mt-7">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('forget.password') }}">Forgot your password?
                            </a>

                            <button
                                class="text-center bg-blue-700 text-white py-1 w-20 rounded-md ml-8 hover:bg-blue-400 hover:text-black"
                                type="submit">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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

        // Show/hide position dropdown based on selected role
        const roleRadioButtons = document.querySelectorAll('input[name="role"]');
        const positionSection = document.getElementById('positionSection');

        roleRadioButtons.forEach(radioButton => {
            radioButton.addEventListener('change', () => {
                if (radioButton.value === 'staff') {
                    positionSection.classList.remove('hidden');
                    positionSection.querySelector('select').setAttribute('required', 'required');
                } else {
                    positionSection.classList.add('hidden');
                    positionSection.querySelector('select').removeAttribute('required');
                }
            });
        });
    </script>
@endsection
