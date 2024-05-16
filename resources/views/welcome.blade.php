@extends('layout')
@section('title', 'Homepage')
@section('content')
    <header class="text-center p-16 bg-gradient-to-r from-gray-500 to-yellow-300 text-white shadow-lg">
        <div>
            <h1 class="text-5xl font-semibold">2u2i UnityHub</h1>
            <h2 class="text-2xl font-medium">Internship Evaluation Platform</h2>
        </div>
    </header>

    <div class="container mx-auto my-8">
        <div class="flex flex-col md:flex-row md:space-x-8">
            <div class="flex-grow p-4 bg-white rounded-md shadow-md">
                <h1 class="text-3xl font-bold text-center mb-4">About</h1>
                <p class="text-lg text-justify p-4">
                    The 2u2i program at Universiti Malaysia Terengganu (UMT) offers students from the Faculty of Maritime
                    Engineering and Information Technology (FTKKI) a unique opportunity for career exposure. Lasting for a
                    duration of one year, this program places students in organizations specifically identified to align
                    with their respective fields of study. Through the 2u2i initiative, students not only gain theoretical
                    knowledge from their academic pursuits but also acquire practical insights by immersing themselves in
                    real-world work environments. This experiential learning approach enhances their overall skill set,
                    fosters a deeper understanding of industry dynamics, and prepares them for a seamless transition from
                    academia to the professional world upon graduation.
                </p>
            </div>
            <div class="flex-grow mt-4 md:mt-0 p-4 bg-white rounded-md shadow-md">
                <h1 class="text-3xl font-bold text-center mb-4">Collaborative</h1>
                <p class="text-lg text-justify p-4">
                    The success of the 2u2i program at Universiti Malaysia Terengganu (UMT) is underscored by the
                    collaborative efforts with various industries that actively participate in this initiative. These
                    forward-thinking industries, all of which boast Memorandum of Understanding (MOU) certificates, play a
                    pivotal role in shaping the program's implementation. Their engagement goes beyond mere support; these
                    industry partners actively contribute to the design and execution of the program, ensuring a mutually
                    beneficial experience for both the students and the organizations involved. The MOU certificates signify
                    a commitment to fostering a symbiotic relationship, highlighting the dedication of these industries to
                    the professional development of the students and the overall success of the 2u2i program. This
                    collaborative framework not only enhances the students' exposure to real-world scenarios but also
                    establishes a dynamic bridge between academia and industry, enriching the educational journey and
                    promoting a holistic approach to career readiness.
                </p>
            </div>
        </div>
    </div>
@endsection
