@extends('layout')
@section('title', 'Dashboard')
@section('content')
    <div class="container mx-auto p-4">
        <header class="text-center py-16 px-8 bg-gradient-to-r from-gray-500 to-orange-300 text-white shadow-xl rounded-lg">
            <h1 class="mb-4 text-4xl font-semibold">Welcome Coach!</h1>
        </header>

        <div class="p-8">
            <div class="flex flex-col space-y-10">
                <div class="flex flex-row items-center border border-blue-300 rounded-lg p-6 shadow-lg">
                    <img src="/../img/2u2i Timeframe.png" alt="timeframe"
                        class="border-4 border-gray-400 rounded-lg shadow-lg h-96">
                    <div class="max-w-lg ml-28">
                        <h2 class="text-3xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-clock text-gray-600 mr-2"></i> Explore the 2U2I Timeframe
                        </h2>
                        <p class="text-gray-600 text-lg leading-7 text-justify">
                            The 2u2i timeframe is a one year plan that guides students in their learning journey. It is
                            designed to help students develop the necessary skills and knowledge to be successful in their
                            future careers. The 2U2I Timeframe is divided into 2 semesters, each with its own set of
                            learning outcomes and activities. Students are expected to complete a series of tasks and
                            assessments in each semester to demonstrate their progress and development.
                        </p>
                    </div>
                </div>

                <div class="flex flex-row items-center justify-between border border-blue-300 rounded-lg p-6 shadow-lg">
                    <div class="max-w-lg ml-24">
                        <h2 class="text-3xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-flag-checkered text-gray-600 mr-2"></i> Track the 2u2i Milestones
                        </h2>
                        <p class="text-gray-600 text-lg leading-7 text-justify">
                            The 2u2i milestones are a series of tasks and assessments that students must complete in order to
                            progress through the 2u2i timeframe. These milestones are designed to help students develop the
                            necessary skills and knowledge to be successful in their future careers. Students are expected to
                            complete a series of tasks and assessments in each milestone to demonstrate their progress and
                            development.
                        </p>
                    </div>
                    <img src="/../img/2u2i Milestone.png" alt="milestone"
                        class="border-4 border-gray-400 rounded-lg shadow-lg h-96">
                </div>
            </div>
        </div>
    </div>
@endsection
