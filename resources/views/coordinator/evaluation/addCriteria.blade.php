@extends('layout')
@section('title', 'Evaluate')
@section('content')
    <div class="container mx-auto p-4">
        <div class="m-5">
            <h1 class="text-center text-3xl font-bold mb-4">Add New Criteria</h1>
        </div>

        <div class="max-w-screen-sm mx-auto bg-slate-300 p-6 rounded-md shadow-md">
            <p class="text-orange-500 font-semibold text-base mb-4">You cannot delete the existing criteria here!</p>
            <form action="{{ route('coordinators.evaluations.storeCriteria', $evaluation->evaId) }}" method="POST">
                @csrf

                <div id="criteria-container">
                    @foreach ($evaluation->criteria as $index => $criteria)
                        <div class="flex flex-row space-x-5 items-start existing-criteria">
                            <div class="basis-1/2">
                                <div class="mb-4">
                                    <label for="existing_criteria{{ $index + 1 }}"
                                        class="block font-medium text-base text-gray-700">Criteria
                                        {{ $index + 1 }}</label>
                                    <textarea name="existing_criteria[{{ $criteria->evaCriId }}]" id="existing_criteria{{ $index + 1 }}" rows="4"
                                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                                        readonly required>{{ $criteria->criteria }}</textarea>
                                </div>
                            </div>
                            <div class="basis-1/2">
                                <div class="mb-4">
                                    <label for="existing_weight{{ $index + 1 }}"
                                        class="block font-medium text-base text-gray-700">Weight</label>
                                    <input type="number" id="existing_weight{{ $index + 1 }}"
                                        name="existing_weight[{{ $criteria->evaCriId }}]"
                                        class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                                        min="0.0" max="10.0" step="0.1" value="{{ $criteria->weight }}"
                                        readonly required>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <p id="add-criteria" class="text-blue-700 cursor-pointer"><i class="fas fa-plus-circle"></i> more
                        criteria</p>
                </div>

                <div class="flex items-center justify-center mt-4">
                    <button type="submit"
                        class="text-center bg-green-700 text-white py-1 w-16 rounded-md hover:bg-green-400 hover:text-black">
                        Create
                    </button>
                    <a href="{{ route('coordinators.evaluations.ploDetails', $evaluation->evaId) }}"
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
            let criteriaCount = {{ $evaluation->criteria->count() }};

            addLink.addEventListener('click', function() {
                criteriaCount++;
                const newRow = document.createElement('div');
                newRow.classList.add('flex', 'flex-row', 'space-x-5', 'items-start', 'new-criteria');
                newRow.id = 'criteria-row-' + criteriaCount;

                newRow.innerHTML = `
                    <div class="basis-1/2">
                        <div class="mb-4">
                            <label for="criteria${criteriaCount}" class="block font-medium text-base text-gray-700">Criteria ${criteriaCount}</label>
                            <textarea name="criteria[]" id="criteria${criteriaCount}" rows="4"
                                      class="block w-full rounded-md p-2 border border-gray-300 focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 transition ease-in-out duration-150"
                                      required></textarea>
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
                attachDeleteEvent(newRow);
                updateCriteriaNumbering();
            });

            function updateCriteriaNumbering() {
                const existingCriteriaRows = Array.from(document.querySelectorAll(
                    '#criteria-container > .flex.existing-criteria'));
                const newCriteriaRows = Array.from(document.querySelectorAll(
                    '#criteria-container > .flex.new-criteria'));

                existingCriteriaRows.forEach((row, index) => {
                    const criteriaLabel = row.querySelector('label[for^="existing_criteria"]');
                    const weightLabel = row.querySelector('label[for^="existing_weight"]');
                    const rowNumber = index + 1;

                    criteriaLabel.textContent = `Existing Criteria ${rowNumber}`;
                    criteriaLabel.setAttribute('for', `existing_criteria${rowNumber}`);
                    weightLabel.setAttribute('for', `existing_weight${rowNumber}`);
                });

                newCriteriaRows.forEach((row, index) => {
                    const criteriaLabel = row.querySelector('label[for^="criteria"]');
                    const weightLabel = row.querySelector('label[for^="weight"]');
                    const criteriaTextarea = row.querySelector('textarea');
                    const weightInput = row.querySelector('input[type="number"]');
                    const rowNumber = index + 1;

                    criteriaLabel.textContent = `New Criteria ${rowNumber}`;
                    criteriaLabel.setAttribute('for', `criteria${rowNumber}`);
                    criteriaTextarea.id = `criteria${rowNumber}`;
                    criteriaTextarea.name = `criteria[]`;

                    weightLabel.setAttribute('for', `weight${rowNumber}`);
                    weightInput.id = `weight${rowNumber}`;
                    weightInput.name = `weight[]`;
                });
            }

            function attachDeleteEvent(row) {
                const deleteButton = row.querySelector('.delete-criteria-btn');
                if (deleteButton) {
                    deleteButton.addEventListener('click', function() {
                        row.remove();
                        updateCriteriaNumbering();
                    });
                }
            }

            document.querySelectorAll('.new-criteria').forEach(row => attachDeleteEvent(row));
            updateCriteriaNumbering();
        });
    </script>
@endsection
