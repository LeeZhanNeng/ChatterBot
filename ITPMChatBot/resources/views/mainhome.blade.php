@extends('layout')

@section('content')
    @guest
    @else
        @if(Auth::user()->user_type == 'lecturer')
            <div class="container" style="padding-top:3.5%; min-height: 100vh;">
                <div class="text-center" style="font-size: 2.25rem;">
                    Welcome back to ChatterBot
                </div>
                <div class="row" style="padding-top:2.5%;">
                    <div class="col-md-4 d-flex align-items-center justify-content-center" style="padding-top:2.5%;">
                        <div class="card" style="height: 250px;">
                            <a href="{{ route('aiChat') }}" style="text-decoration: none; text-align: center; color: inherit;">
                                <br>
                                <div class="card-top" style="font-size: 1.5rem;">
                                    <i class="bx bx-chat"></i>Chat
                                </div>
                                <div class="card-body" style="font-size: 1.25rem;">
                                    Try to ask some questions with ChatterBot or chat with other users.
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center" style="padding-top:2.5%;">
                        <div class="card" style="height: 250px;">
                            <a href="{{ route('subject') }}" style="text-decoration: none; text-align: center; color: inherit;">
                                <br>
                                <div class="card-top" style="font-size: 1.5rem;">
                                    <i class="bx bx-book"></i>Category
                                </div>
                                <div class="card-body" style="font-size: 1.25rem;">
                                    Organize, structure, and prepare your exams or assessments efficiently with our comprehensive category planning tools.
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center" style="padding-top:2.5%;">
                        <div class="card" style="height: 250px;">
                            <a href="{{ route('exam') }}" style="text-decoration: none; text-align: center; color: inherit;">
                                <br>
                                <div class="card-top" style="font-size: 1.5rem;">
                                    <i class="bx bx-task"></i>Exams
                                </div>
                                <div class="card-body" style="font-size: 1.25rem;">
                                    Efficiently plan and organize exams with our intuitive exam planning tools.
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center" style="padding-top:2.5%;">
                        <div class="card" style="height: 250px;">
                            <a href="{{ route('questionAnswer') }}" style="text-decoration: none; text-align: center; color: inherit;">
                                <br>
                                <div class="card-top" style="font-size: 1.5rem;">
                                    <i class="bx bx-help-circle"></i>Q&A
                                </div>
                                <div class="card-body" style="font-size: 1.25rem;">
                                    Access a repository of exam questions and detailed answers.
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center" style="padding-top:2.5%;">
                        <div class="card" style="height: 250px;">
                            <a href="{{ route('mark') }}" style="text-decoration: none; text-align: center; color: inherit;">
                                <br>
                                <div class="card-top" style="font-size: 1.5rem;">
                                    <i class="bx bx-check"></i>Marks
                                </div>
                                <div class="card-body" style="font-size: 1.25rem;">
                                    Track and manage your exam marks effortlessly with our intuitive grading and performance analysis tools.
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center justify-content-center" style="padding-top:2.5%;">
                        <div class="card" style="height: 250px;">
                            <a href="{{ route('reviewExam') }}" style="text-decoration: none; text-align: center; color: inherit;">
                                <br>
                                <div class="card-top" style="font-size: 1.5rem;">
                                    <i class="bx bx-file"></i>Review
                                </div>
                                <div class="card-body" style="font-size: 1.25rem;">
                                    Effortlessly review and approve exam results with our intuitive result approval and verification tools.
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="container" style="padding-top:3.5%; min-height: 100vh;">
                <div class="text-center" style="font-size: 2.25rem;">
                    Welcome back to ChatterBot
                </div>
                <div class="row" style="padding-top:2.5%;">
                    <div class="col-md-12 d-flex align-items-center justify-content-center">
                        <div class="card" style="height: 200px;">
                            <a href="{{ route('aiChat') }}" style="text-decoration: none; text-align: center; color: inherit;">
                                <br>
                                <div class="card-top" style="font-size: 1.5rem;">
                                    <i class="bx bx-chat"></i>Chat
                                </div>
                                <div class="card-body" style="font-size: 1.25rem;">
                                    Try to ask some questions with or chat with other users.
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-top:2.5%;">
                        <div class="card" style="height: 350px;">
                            <a href="{{ route('studentExamIndex') }}" style="text-decoration: none; text-align: center; color: inherit;">
                                <br>
                                <div class="card-top" style="font-size: 1.5rem;">
                                    <i class="bx bx-task"></i>Exam
                                </div>
                                <div class="card-body" style="height: 250px; overflow: auto;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Exam Name</th>
                                                <th scope="col">Category Name</th>
                                                <th scope="col">Time</th>
                                                <th scope="col">Start Time</th>
                                                <th scope="col">End Time</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count = 1;
                                            @endphp
                                            @forelse($exams as $exam)
                                                <tr>
                                                    @if($exam['end_time'] > date('Y-m-d H:i:s'))
                                                    <td style="display:none;">{{ $exam->id }}</td>
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $exam->exam_name }}</td>
                                                    <td>{{ $exam->subjects[0]['subject'] }}</td>
                                                    <td>{{ $exam->time }} Hrs</td>
                                                    <td>{{ $exam->start_time }}</td>
                                                    <td>{{ $exam->end_time }}</td>
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8">No Exams Available!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding-top:2.5%;">
                        <div class="card" style="height: 350px;">
                            <a href="{{ route('resultIndex') }}" style="text-decoration: none; text-align: center; color: inherit;">
                                <br>
                                <div class="card-top" style="font-size: 1.5rem;">
                                    <i class="bx bx-book"></i>Results
                                </div>
                                <div class="card-body" style="height: 250px; overflow: auto;">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Exam</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $x = 1;
                                            @endphp
                                            @forelse($attempts as $attempt)
                                                <tr>
                                                    <td>{{ $x++ }}</td>
                                                    <td>{{ $attempt->exam->exam_name }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4">You not attempted any Exam!</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endguest
@endsection
