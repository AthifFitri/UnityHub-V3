@extends('layout')
@section('title', 'New Password')

@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-xl font-bold">Enter your new password here!</h1>
        </div>
        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">

            <form action="{{ route('reset.password.post') }}" method="POST">
                @csrf

                <!-- Hidden input field for role -->
                <input type="text" name="token" value="{{ $token }}" hidden>
                <input type="email" name="email" value="{{ $email }}" hidden>
                <input type="hidden" name="role" id="selectedRole" value="{{ $role }}">

                {{-- New Password --}}
                <div class="mt-4 relative">
                    <label class="block font-medium text-base text-gray-700" for="password">New Password</label>
                    <input id="password" class="block mt-1 w-full rounded-md p-1" type="password" name="password"
                        required />
                    <i class="absolute right-2 top-8 cursor-pointer text-gray-500 hover:text-gray-700"
                        onclick="togglePasswordVisibility('password', 'passwordToggleIcon')">
                        <i id="passwordToggleIcon" class="fas fa-eye"></i>
                    </i>
                    @error('password')
                        @if ($message == 'The new password must be at least 6 characters long.')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @endif
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mt-4 relative">
                    <label class="block font-medium text-base text-gray-700" for="password_confirmation">Confirm
                        Password</label>
                    <input id="password_confirmation" class="block mt-1 w-full rounded-md p-1" type="password"
                        name="password_confirmation" required />
                    <i class="absolute right-2 top-8 cursor-pointer text-gray-500 hover:text-gray-700"
                        onclick="togglePasswordVisibility('password_confirmation', 'confirmPasswordToggleIcon')">
                        <i id="confirmPasswordToggleIcon" class="fas fa-eye"></i>
                    </i>
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-blue-700 text-white py-1 w-16 rounded-md hover:bg-blue-400 hover:text-black">
                        Submit
                    </button>
                    <a href="{{ route('forget.password') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black">
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
