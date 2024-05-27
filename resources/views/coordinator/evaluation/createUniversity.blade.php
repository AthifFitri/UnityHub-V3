@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="p-5 text-center">
            <h1 class="text-4xl font-bold">Create University Evaluation</h1>
        </div>

        <div class="max-w-screen-sm mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <form action="{{ route('coordinators.evaluations.store') }}" method="POST">
                @csrf

                <input type="hidden" name="evaType" value="University">

                <div class="mb-4">
                    <label for="course" class="block font-medium text-base text-gray-700">Course</label>
                    <select name="course" id="course"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500"
                        required>
                        <option value="" disabled selected>Select Course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->courseId }}">{{ $course->courseCode }} - {{ $course->courseName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="plo" class="block font-medium text-base text-gray-700">Choose Program Learning Outcome
                        (PLO)</label>
                    <select name="plo" id="plo"
                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500"
                        required>
                        <option value="" disabled selected>Select PLO</option>
                        @foreach (range(1, 9) as $plo)
                            <option value="{{ $plo }}">PLO{{ $plo }}</option>
                        @endforeach
                    </select>
                </div>

                <div id="criteria-container">
                    <div class="flex flex-row space-x-5 items-start">
                        <div class="basis-1/2">
                            <div class="mb-4">
                                <label for="criteria1" class="block font-medium text-base text-gray-700">Criteria 1</label>
                                <textarea name="criteria[]" id="criteria1" rows="4"
                                    class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                                    required></textarea>
                            </div>
                        </div>
                        <div class="basis-1/6">
                            <div class="mb-4">
                                <label for="weight1" class="block font-medium text-base text-gray-700">Weight</label>
                                <input type="number" id="weight1" name="weight[]"
                                    class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                                    min="0.0" max="10.0" step="0.1" value="0" required>
                            </div>
                        </div>
                        <div class="basis-1/12 flex items-center justify-center mt-28">
                            <button type="button"
                                class="text-red-700 delete-criteria-btn focus:outline-none hover:text-red-800 transition ease-in-out duration-150">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <p id="add-criteria" class="text-blue-700 cursor-pointer"><i class="fas fa-plus-circle"></i> more
                        criteria
                    </p>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Create
                    </button>
                    <a href="{{ route('coordinators.evaluations.index') }}"
                        class="text-center bg-red-700 text-white py-1 w-16 ml-5 rounded-md hover:bg-red-400 hover:text-black"
                        onclick="return confirm('Are you sure you want to cancel? This will discard your changes.');">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addLink = document.getElementById('add-criteria');
            const criteriaContainer = document.getElementById('criteria-container');
            let criteriaCount = 1;

            // Hide the delete button for the first criteria by default
            const firstDeleteButton = document.querySelector('.delete-criteria-btn');
            firstDeleteButton.style.display = 'none';

            addLink.addEventListener('click', function() {
                criteriaCount++;
                const newRow = document.createElement('div');
                newRow.classList.add('flex', 'flex-row', 'space-x-5', 'items-start');
                newRow.id = 'criteria-row-' + criteriaCount;

                newRow.innerHTML = `
                <div class="basis-1/2">
                    <div class="mb-4">
                        <label for="criteria${criteriaCount}" class="block font-medium text-base text-gray-700">Criteria ${criteriaCount}</label>
                        <textarea name="criteria[]" id="criteria${criteriaCount}" rows="4" class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150" required></textarea>
                    </div>
                </div>
                <div class="basis-1/6">
                    <div class="mb-4">
                        <label for="weight${criteriaCount}" class="block font-medium text-base text-gray-700">Weight</label>
                        <input type="number" id="weight${criteriaCount}" name="weight[]" class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150" min="0.0" max="10.0" step="0.1" value="0" required>
                    </div>
                </div>
                <div class="basis-1/12 flex items-center justify-center mt-28">
                    <button type="button" class="text-red-700 delete-criteria-btn focus:outline-none hover:text-red-800 transition ease-in-out duration-150">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `;

                criteriaContainer.appendChild(newRow);
                updateCriteriaNumbering();

                // Add event listener to the delete button
                const deleteButton = newRow.querySelector('.delete-criteria-btn');
                deleteButton.addEventListener('click', function() {
                    newRow.remove();
                    updateCriteriaNumbering();
                });

                // Show the delete button for the first criteria when more criteria are added
                if (criteriaCount > 1) {
                    firstDeleteButton.style.display = 'block';
                }
            });

            function updateCriteriaNumbering() {
                const criteriaRows = document.querySelectorAll('#criteria-container > .flex');
                criteriaRows.forEach((row, index) => {
                    const criteriaLabel = row.querySelector('label[for^="criteria"]');
                    const weightLabel = row.querySelector('label[for^="weight"]');
                    const criteriaTextarea = row.querySelector('textarea');
                    const weightInput = row.querySelector('input[type="number"]');
                    const deleteButton = row.querySelector('.delete-criteria-btn');
                    const rowNumber = index + 1;

                    criteriaLabel.textContent = `Criteria ${rowNumber}`;
                    criteriaLabel.setAttribute('for', `criteria${rowNumber}`);
                    criteriaTextarea.id = `criteria${rowNumber}`;
                    criteriaTextarea.name = `criteria[]`;

                    weightLabel.setAttribute('for', `weight${rowNumber}`);
                    weightInput.id = `weight${rowNumber}`;
                    weightInput.name = `weight[]`;

                    if (rowNumber === 1 && criteriaRows.length === 1) {
                        deleteButton.style.display = 'none';
                    } else {
                        deleteButton.style.display = 'block';
                    }
                });
            }
        });
    </script>
@endsection
