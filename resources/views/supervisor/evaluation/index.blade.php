@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Student Overview Evaluation</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md mt-4">
            <div class="flex justify-start">
                <button id="tabCSM4908"
                    class="px-4 py-2 rounded-t-lg transition duration-300 ease-in-out bg-blue-500 text-white">CSM4908</button>
                <button id="tabCSM4918"
                    class="px-4 py-2 rounded-t-lg transition duration-300 ease-in-out bg-gray-300">CSM4918</button>
                <button id="tabCSM4928"
                    class="px-4 py-2 rounded-t-lg transition duration-300 ease-in-out bg-gray-300">CSM4928</button>
                <button id="tabCSM4938"
                    class="px-4 py-2 rounded-t-lg transition duration-300 ease-in-out bg-gray-300">CSM4938</button>
            </div>

            <div class="p-5 bg-white rounded-b-md">
                <div id="evaluationCSM4908" class="text-gray-600">
                    <h2 class="text-xl font-bold mb-4">CSM4908 - Industrial Project Management</h2>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-400 text-white">
                                <th class="border px-4 py-2">No.</th>
                                <th class="border px-4 py-2">Student Name</th>
                                <th class="border px-4 py-2">Logbook (5%)</th>
                                <th class="border px-4 py-2">Quiz (10%)</th>
                                <th class="border px-4 py-2">Project Documentation (10%)</th>
                                <th class="border px-4 py-2">Final Presentation (20%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr class="text-center">
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $student->stuName }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="evaluationCSM4918" class="text-gray-600 hidden">
                    <h2 class="text-xl font-bold mb-4">CSM4918 - Industrial Project Development</h2>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-400 text-white">
                                <th class="border px-4 py-2">No.</th>
                                <th class="border px-4 py-2">Student Name</th>
                                <th class="border px-4 py-2">Project Documentation (10%)</th>
                                <th class="border px-4 py-2">Final Presentation (10%)</th>
                                <th class="border px-4 py-2">Project Output (10%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr class="text-center">
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $student->stuName }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="evaluationCSM4928" class="text-gray-600 hidden">
                    <h2 class="text-xl font-bold mb-4">CSM4928 - Integrated Industrial Project Managemet</h2>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-400 text-white">
                                <th class="border px-4 py-2">No.</th>
                                <th class="border px-4 py-2">Student Name</th>
                                <th class="border px-4 py-2">Logbook (5%)</th>
                                <th class="border px-4 py-2">Quiz (10%)</th>
                                <th class="border px-4 py-2">Project Documentation (10%)</th>
                                <th class="border px-4 py-2">Final Presentation (5%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr class="text-center">
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $student->stuName }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div id="evaluationCSM4938" class="text-gray-600 hidden">
                    <h2 class="text-xl font-bold mb-4">CSM4938 - Integrated Industrial Project Development</h2>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-400 text-white">
                                <th class="border px-4 py-2">No.</th>
                                <th class="border px-4 py-2">Student Name</th>
                                <th class="border px-4 py-2">Project Documentation (10%)</th>
                                <th class="border px-4 py-2">Final Presentation (10%)</th>
                                <th class="border px-4 py-2">Project Output (10%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr class="text-center">
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $student->stuName }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setActiveTab(tabId, evaluationId) {
            const tabs = ['tabCSM4908', 'tabCSM4918', 'tabCSM4928', 'tabCSM4938'];
            const evaluations = ['evaluationCSM4908', 'evaluationCSM4918', 'evaluationCSM4928', 'evaluationCSM4938'];

            localStorage.setItem('activeTab', tabId);

            tabs.forEach((tab) => {
                document.getElementById(tab).classList.remove('bg-blue-500', 'text-white');
                document.getElementById(tab).classList.add('bg-gray-300');
            });

            evaluations.forEach((evaluation) => {
                document.getElementById(evaluation).classList.add('hidden');
            });

            document.getElementById(tabId).classList.remove('bg-gray-300');
            document.getElementById(tabId).classList.add('bg-blue-500', 'text-white');
            document.getElementById(evaluationId).classList.remove('hidden');
        }

        document.getElementById('tabCSM4908').addEventListener('click', function() {
            setActiveTab('tabCSM4908', 'evaluationCSM4908');
        });

        document.getElementById('tabCSM4918').addEventListener('click', function() {
            setActiveTab('tabCSM4918', 'evaluationCSM4918');
        });

        document.getElementById('tabCSM4928').addEventListener('click', function() {
            setActiveTab('tabCSM4928', 'evaluationCSM4928');
        });

        document.getElementById('tabCSM4938').addEventListener('click', function() {
            setActiveTab('tabCSM4938', 'evaluationCSM4938');
        });
    </script>
@endsection
