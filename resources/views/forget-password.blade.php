@extends('layout')
@section('title', 'Forget Password')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-xl font-bold">You will receive link at your email, use that link to reset password.</h1>
        </div>
        <div class="max-w-md mx-auto bg-slate-300 p-6 rounded-md shadow-md">

            {{-- Error or Success message --}}
            <div class="pb-2">
                @if (session()->has('error'))
                    <div class="text-red-500">{{ session('error') }}</div>
                @endif

                @if (isset($success))
                    <div class="text-green-500">{{ $success }}</div>
                @endif
            </div>
            <form action="{{ route('forget.password.post') }}" method="POST">
                @csrf

                {{-- Role Selection --}}
                <div class="mt-4 mb-4">
                    <label class="block font-medium text-base text-gray-700">Role</label>
                    <div class="flex">
                        <label class="inline-flex items-center mx-9">
                            <input class="cursor-pointer" type="radio" name="role" value="student" required />
                            <span class="ms-2 text-sm text-gray-600">Student</span>
                        </label>
                        <label class="inline-flex items-center mx-9">
                            <input class="cursor-pointer" type="radio" name="role" value="staff" required />
                            <span class="ms-2 text-sm text-gray-600">Staff</span>
                        </label>
                        <label class="inline-flex items-center mx-9">
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

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-blue-700 text-white py-1 w-16 rounded-md hover:bg-blue-400 hover:text-black">
                        Submit
                    </button>
                    <a href="{{ route('login') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel?');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
