<nav class="flex flex-row bg-gray-100 text-gray-500 font-semibold p-4 shadow-lg">
    {{-- 2u2i UnityHub Logo --}}
    <div class="shrink-0 flex items-center h-10">
        <img src="/../img/navbar logo.png" alt="logo" class="h-24">
    </div>

    {{-- Left Navigation Links --}}
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

        {{-- Student Navigation --}}
        @auth('student')
            <ul class="flex space-x-7 items-center align-items-center">
                <li><a href="{{ route('studentDashboard') }}"
                        class="hover:text-blue-400 @if (request()->routeIs('studentDashboard')) font-semibold text-blue-400 @endif">Dashboard</a>
                </li>
                <li><a href="{{ route('student.materials.index') }}"
                        class="hover:text-blue-400 @if (request()->routeIs('student.materials.index')) font-semibold text-blue-400 @endif">Material</a>
                </li>
                <li><a href="{{ route('student.documents.index') }}"
                        class="hover:text-blue-400 @if (request()->routeIs('student.documents.index')) font-semibold text-blue-400 @endif">Document</a>
                </li>
                <li><a href="{{ route('student.logbooks.index') }}"
                        class="hover:text-blue-400 @if (request()->routeIs('student.logbooks.index')) font-semibold text-blue-400 @endif">Logbook</a>
                </li>
            </ul>
        @endauth

        {{-- Staff Navigation --}}
        @auth('staff')
            @php
                $position = auth('staff')->user()->position->posId;
            @endphp
            <ul class="flex space-x-7 items-center align-items-center">
                {{-- Supervisor Navigation --}}
                @if ($position == 1)
                    <li><a href="{{ route('supervisorDashboard') }}"
                            class="hover:text-blue-400 @if (request()->routeIs('supervisorDashboard')) font-semibold text-blue-400 @endif">Dashboard</a>
                    </li>
                    <li><a href="{{ route('supervisors.materials.index') }}"
                            class="hover:text-blue-400 @if (request()->routeIs('supervisors.materials.index')) font-semibold text-blue-400 @endif">Material</a>
                    </li>

                    {{-- Coordinator Navigation --}}
                @elseif ($position == 2)
                    <li><a href="{{ route('coordinatorDashboard') }}"
                            class="hover:text-blue-400 @if (request()->routeIs('coordinatorDashboard')) font-semibold text-blue-400 @endif">Dashboard</a>
                    </li>
                    <li><a href="{{ route('coordinators.materials.index') }}"
                            class="hover:text-blue-400 @if (request()->routeIs('coordinators.materials.index')) font-semibold text-blue-400 @endif">Material</a>
                    </li>
                    <li><a href="{{ route('registers.index') }}"
                            class="hover:text-blue-400 @if (request()->routeIs('registers.index')) font-semibold text-blue-400 @endif">Coach</a>
                    </li>
                    <li><a href="{{ route('coordinators.quizes.index') }}"
                            class="hover:text-blue-400 @if (request()->routeIs('coordinators.quizes.index')) font-semibold text-blue-400 @endif">Quiz</a>
                    </li>

                    {{-- Hop Navigation --}}
                @elseif ($position == 3)
                    <li><a href="{{ route('hopDashboard') }}"
                            class="hover:text-blue-400 @if (request()->routeIs('hopDashboard')) font-semibold text-blue-400 @endif">Dashboard</a>
                    </li>
                @endif
            </ul>
        @endauth

        {{-- Coach Navigation --}}
        @auth('coach')
            <ul class="flex space-x-7 items-center align-items-center">
                <li><a href="{{ route('coachDashboard') }}"
                        class="hover:text-blue-400 @if (request()->routeIs('coachDashboard')) font-semibold text-blue-400 @endif">Dashboard</a>
                </li>
                <li><a href="{{ route('coaches.materials.index') }}"
                        class="hover:text-blue-400 @if (request()->routeIs('coaches.materials.index')) font-semibold text-blue-400 @endif">Material</a>
                </li>
                <li><a href="{{ route('coaches.logbooks.index') }}"
                        class="hover:text-blue-400 @if (request()->routeIs('coaches.logbooks.index')) font-semibold text-blue-400 @endif">Student
                        Logbook</a>
                </li>
                <li><a href="{{ route('coaches.resume.index') }}"
                        class="hover:text-blue-400 @if (request()->routeIs('coaches.resume.index')) font-semibold text-blue-400 @endif">Resume</a>
                </li>
            </ul>
        @endauth

        {{-- Homepage Navigation --}}
        @if (request()->routeIs('homepage') || request()->routeIs('login') || request()->routeIs('forget.password'))
            <ul class="flex space-x-7 items-center align-items-center">
                <li><a href="{{ route('homepage') }}"
                        class="hover:text-blue-400 @if (request()->routeIs('homepage')) font-semibold text-blue-400 @endif">Homepage</a>
                </li>
            </ul>
        @endif
    </div>

    {{-- Right Navigation Links --}}
    <div class="flex ml-auto space-x-8">
        <ul class="flex space-x-7 items-center align-items-center">

            {{-- Sign In Button in Homepage --}}
            @if (request()->routeIs('homepage'))
                <div class="flex">
                    <button onclick="window.location.href='{{ route('login') }}'"
                        class="bg-blue-700 text-white py-2 px-4 rounded-md hover:bg-blue-400 hover:text-black">Sign
                        In</button>
                </div>
            @endif

            {{-- Profile and Logout for Student --}}
            @auth('student')
                <li>
                    <div class="relative">
                        <button id="profileDropdown"
                            class="hover:text-blue-400">{{ auth('student')->user()->stuName }}</button>
                        <ul id="dropdownMenu" class="absolute hidden right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <li><a href="{{ route('students.profile.index') }}"
                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-200 hover:text-blue-400">Profile</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="return"
                                    class="block px-4 py-2 text-red-500 hover:bg-gray-200">Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endauth

            {{-- Profile and Logout for Staff --}}
            @auth('staff')
                @php
                    $position = auth('staff')->user()->position->posId;
                @endphp
                <li>
                    <div class="relative">
                        <button id="profileDropdown"
                            class="hover:text-blue-400">{{ auth('staff')->user()->staffName }}</button>
                        <ul id="dropdownMenu" class="absolute hidden right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            {{-- Supervisor Profile --}}
                            @if ($position == 1)
                                <li><a href="{{ route('supervisors.profile.index') }}"
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-200 hover:text-blue-400">Profile</a>
                                </li>

                                {{-- Coordinator Profile --}}
                            @elseif ($position == 2)
                                <li><a href="{{ route('coordinators.profile.index') }}"
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-200 hover:text-blue-400">Profile</a>
                                </li>

                                {{-- Hop Profile --}}
                            @elseif ($position == 3)
                                <li><a href="{{ route('hop.profile.index') }}"
                                        class="block px-4 py-2 text-gray-800 hover:bg-gray-200 hover:text-blue-400">Profile</a>
                                </li>
                            @endif
                            <li>
                                <a href="{{ route('logout') }}" onclick="return"
                                    class="block px-4 py-2 text-red-500 hover:bg-gray-200">Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endauth

            {{-- Profile and Logout for Coach --}}
            @auth('coach')
                <li>
                    <div class="relative">
                        <button id="profileDropdown"
                            class="hover:text-blue-400">{{ auth('coach')->user()->coachName }}</button>
                        <ul id="dropdownMenu" class="absolute hidden right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <li><a href="{{ route('coaches.profile.index') }}"
                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-200 hover:text-blue-400">Profile</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="return"
                                    class="block px-4 py-2 text-red-500 hover:bg-gray-200">Logout</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endauth
        </ul>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var profileDropdown = document.getElementById("profileDropdown");
            var dropdownMenu = document.getElementById("dropdownMenu");

            profileDropdown.addEventListener("click", function(event) {
                dropdownMenu.classList.toggle("hidden");
                event.stopPropagation();
            });

            document.addEventListener("click", function(event) {
                if (!profileDropdown.contains(event.target)) {
                    dropdownMenu.classList.add("hidden");
                }
            });
        });
    </script>
</nav>
