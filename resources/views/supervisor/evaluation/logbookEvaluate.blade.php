@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-3xl font-bold">Student Logbook Evaluation</h1>
        </div>

        <div class="bg-gray-100 p-6 rounded-md shadow-md">
            <div class="flex justify-start">
                <button id="tabCSM4908"
                    class="px-4 py-2 rounded-t-lg transition duration-300 ease-in-out bg-blue-500 text-white">CSM4908</button>
                <button id="tabCSM4928"
                    class="px-4 py-2 rounded-t-lg transition duration-300 ease-in-out bg-gray-300">CSM4928</button>
            </div>

            <div class="p-5 bg-white rounded-b-md">
                <div id="evaluationCSM4908" class="text-gray-600">
                    @if (session('success'))
                        <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h2 class="text-xl font-bold mb-4">CSM4908 - Industrial Project Management</h2>

                    @if ($criteriaCSM4908->isEmpty())
                        <div class="text-center text-gray-500">No evaluation form available!</div>
                    @else
                        <form action="{{ route('supervisors.evaluations.logbookEvaluate.store', $student->stuId) }}"
                            method="POST">
                            @csrf

                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <div class="flex flex-row">
                                        <p class="font-semibold text-base text-gray-700 mr-2">Student Name :</p>
                                        <p class="flex-grow text-blue-500 font-medium text-base">{{ $student->stuName }}</p>
                                    </div>
                                    <div class="flex flex-row">
                                        <p class="font-semibold text-base text-gray-700 mr-2">Program Learning Outcome
                                            (PLO):</p>
                                        <p class="text-blue-500 font-medium text-base">{{ $ploCSM4908->implode(', ') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <button type="submit"
                                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                                        Submit
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <table class="w-full border">
                                    <thead>
                                        <tr class="bg-gray-400 text-white">
                                            <th class="border px-4 py-2">No.</th>
                                            <th class="border px-4 py-2">Criteria</th>
                                            <th class="border px-4 py-2">Weight</th>
                                            <th class="border px-4 py-2">Poor <br> (1 Mark)</th>
                                            <th class="border px-4 py-2">Weak <br> (2 Mark)</th>
                                            <th class="border px-4 py-2">Moderate <br> (3 Mark)</th>
                                            <th class="border px-4 py-2">Good <br> (4 Mark)</th>
                                            <th class="border px-4 py-2">Excellent <br> (5 Mark)</th>
                                            <th class="border px-4 py-2">Mark <br> Gained</th>
                                            <th class="border px-4 py-2">Total Mark <br> (Max)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalMarkGained = 0;
                                        @endphp
                                        @foreach ($criteriaCSM4908 as $index => $criterion)
                                            @php
                                                $existingScore =
                                                    $existingEvaluationsCSM4908[$criterion->evaCriId]->logScore ?? null;
                                                $markGained = $existingScore ? $existingScore * $criterion->weight : 0;
                                                $totalMarkGained += $markGained;
                                            @endphp
                                            <tr class="text-center">
                                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                                <td class="border px-4 py-2 text-left w-96">{{ $criterion->criteria }}</td>
                                                <td class="border px-4 py-2">{{ number_format($criterion->weight, 2) }}</td>
                                                <td class="border px-4 py-2">
                                                    <input type="radio" name="criteria[{{ $criterion->evaCriId }}]"
                                                        value="1" class="form-radio"
                                                        {{ $existingScore == 1 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="radio" name="criteria[{{ $criterion->evaCriId }}]"
                                                        value="2" class="form-radio"
                                                        {{ $existingScore == 2 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="radio" name="criteria[{{ $criterion->evaCriId }}]"
                                                        value="3" class="form-radio"
                                                        {{ $existingScore == 3 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="radio" name="criteria[{{ $criterion->evaCriId }}]"
                                                        value="4" class="form-radio"
                                                        {{ $existingScore == 4 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="radio" name="criteria[{{ $criterion->evaCriId }}]"
                                                        value="5" class="form-radio"
                                                        {{ $existingScore == 5 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border px-4 py-2 text-orange-500">
                                                    {{ $existingScore ? number_format($existingScore * $criterion->weight, 2) : '-' }}
                                                </td>
                                                <td class="border px-4 py-2">{{ number_format($criterion->weight * 5, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="bg-gray-400 text-white font-bold text-right border px-4 py-2"
                                                colspan="2">Total Weight / Max Mark</td>
                                            <td class="bg-gray-300 text-center font-bold border px-4 py-2">
                                                {{ number_format($criteriaCSM4908->sum('weight'), 2) }}
                                            </td>
                                            <td colspan="5" class="bg-gray-400 border px-4 py-2"></td>
                                            <td class="bg-gray-300 text-center text-green-500 font-bold border px-4 py-2">
                                                {{ number_format($totalMarkGained, 2) }}
                                            </td>
                                            <td class="bg-gray-300 text-center font-bold border px-4 py-2">
                                                {{ number_format(
                                                    $criteriaCSM4908->sum(function ($criteriaCSM4908) {
                                                        return $criteriaCSM4908->weight * 5;
                                                    }),
                                                    2,
                                                ) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    @endif
                </div>

                <div id="evaluationCSM4928" class="text-gray-600 hidden">
                    @if (session('success'))
                        <div class="text-center bg-green-200 p-2 mb-4 mx-auto rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h2 class="text-xl font-bold mb-4">CSM4928 - Integrated Industrial Project Management</h2>

                    @if ($criteriaCSM4928->isEmpty())
                        <div class="text-center text-gray-500">No evaluation form available</div>
                    @else
                        <form action="{{ route('supervisors.evaluations.logbookEvaluate.store', $student->stuId) }}"
                            method="POST">
                            @csrf

                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <div class="flex flex-row">
                                        <p class="font-semibold text-base text-gray-700 mr-2">Student Name :</p>
                                        <p class="flex-grow text-blue-500 font-medium text-base">{{ $student->stuName }}
                                        </p>
                                    </div>
                                    <div class="flex flex-row">
                                        <p class="font-semibold text-base text-gray-700 mr-2">Program Learning Outcome
                                            (PLO):</p>
                                        <p class="text-blue-500 font-medium text-base">{{ $ploCSM4928->implode(', ') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <button type="submit"
                                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                                        Submit
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <table class="w-full border">
                                    <thead>
                                        <tr class="bg-gray-400 text-white">
                                            <th class="border px-4 py-2">No.</th>
                                            <th class="border px-4 py-2">Criteria</th>
                                            <th class="border px-4 py-2">Weight</th>
                                            <th class="border px-4 py-2">Poor <br> (1 Mark)</th>
                                            <th class="border px-4 py-2">Weak <br> (2 Mark)</th>
                                            <th class="border px-4 py-2">Moderate <br> (3 Mark)</th>
                                            <th class="border px-4 py-2">Good <br> (4 Mark)</th>
                                            <th class="border px-4 py-2">Excellent <br> (5 Mark)</th>
                                            <th class="border px-4 py-2">Mark <br> Gained</th>
                                            <th class="border px-4 py-2">Total Mark <br> (Max)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalMarkGained = 0;
                                        @endphp
                                        @foreach ($criteriaCSM4928 as $index => $criterion)
                                            @php
                                                $existingScore =
                                                    $existingEvaluationsCSM4928[$criterion->evaCriId]->logScore ?? null;
                                                $markGained = $existingScore ? $existingScore * $criterion->weight : 0;
                                                $totalMarkGained += $markGained;
                                            @endphp
                                            <tr class="text-center">
                                                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                                                <td class="border px-4 py-2 text-left w-96">{{ $criterion->criteria }}
                                                </td>
                                                <td class="border px-4 py-2">{{ number_format($criterion->weight, 2) }}
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="radio" name="criteria[{{ $criterion->evaCriId }}]"
                                                        value="1" class="form-radio"
                                                        {{ $existingScore == 1 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="radio" name="criteria[{{ $criterion->evaCriId }}]"
                                                        value="2" class="form-radio"
                                                        {{ $existingScore == 2 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="radio" name="criteria[{{ $criterion->evaCriId }}]"
                                                        value="3" class="form-radio"
                                                        {{ $existingScore == 3 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="radio" name="criteria[{{ $criterion->evaCriId }}]"
                                                        value="4" class="form-radio"
                                                        {{ $existingScore == 4 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <input type="radio" name="criteria[{{ $criterion->evaCriId }}]"
                                                        value="5" class="form-radio"
                                                        {{ $existingScore == 5 ? 'checked' : '' }}>
                                                </td>
                                                <td class="border px-4 py-2 text-orange-500">
                                                    {{ $existingScore ? number_format($existingScore * $criterion->weight, 2) : '-' }}
                                                </td>
                                                <td class="border px-4 py-2">
                                                    {{ number_format($criterion->weight * 5, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="bg-gray-400 text-white font-bold text-right border px-4 py-2"
                                                colspan="2">Total Weight / Max Mark</td>
                                            <td class="bg-gray-300 text-center font-bold border px-4 py-2">
                                                {{ number_format($criteriaCSM4928->sum('weight'), 2) }}
                                            </td>
                                            <td colspan="5" class="bg-gray-400 border px-4 py-2"></td>
                                            <td class="bg-gray-300 text-center text-green-500 font-bold border px-4 py-2">
                                                {{ number_format($totalMarkGained, 2) }}
                                            </td>
                                            <td class="bg-gray-300 text-center font-bold border px-4 py-2">
                                                {{ number_format(
                                                    $criteriaCSM4928->sum(function ($criteriaCSM4928) {
                                                        return $criteriaCSM4928->weight * 5;
                                                    }),
                                                    2,
                                                ) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('supervisors.logbooks.index', ['stuId' => $student->stuId]) }}"
                    class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black">Back</a>
            </div>
        </div>
    </div>

    <script>
        function switchTab(activeTab, inactiveTab) {
            localStorage.setItem('activeTab', activeTab);
            document.getElementById(`evaluation${activeTab}`).classList.remove('hidden');
            document.getElementById(`evaluation${inactiveTab}`).classList.add('hidden');
            document.getElementById(`tab${activeTab}`).classList.remove('bg-gray-300');
            document.getElementById(`tab${activeTab}`).classList.add('bg-blue-500', 'text-white');
            document.getElementById(`tab${inactiveTab}`).classList.remove('bg-blue-500', 'text-white');
            document.getElementById(`tab${inactiveTab}`).classList.add('bg-gray-300');
        }

        document.getElementById('tabCSM4928').addEventListener('click', function() {
            switchTab('CSM4928', 'CSM4908');
        });

        document.getElementById('tabCSM4908').addEventListener('click', function() {
            switchTab('CSM4908', 'CSM4928');
        });

        document.addEventListener('DOMContentLoaded', function() {
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab === 'CSM4908') {
                switchTab('CSM4908', 'CSM4928');
            } else if (activeTab === 'CSM4928') {
                switchTab('CSM4928', 'CSM4908');
            }
        });
    </script>
@endsection
