@extends('layout')

@section('content')
    <div class="student">
        <p>Exam</p>
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Exam Name</th>
                    <th scope="col">Category Name</th>
                    <th scope="col">Time</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Total Attempt</th>
                    <th scope="col">Aready Attempt</th>
                    <th scope="col">Copy Link</th>
                    <th scope="col">Enter</th>
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
                        <td>{{ $exam->attempt }} Time</td>
                        <td>{{ $exam->attempt_counter }} Time</td>
                        <td>{{ $exam->enterance_id }} <a href="#" data-code="{{ $exam->enterance_id }}" class="copy"><i class="bx bx-copy"></i></a></td>
                        <td><a href="{{URL::to('/')}}/exam/{{ $exam->enterance_id }}">Enter</a></td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No Exams Available!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    <div>
    <script>
        $(document).ready(function(){
            $('.copy').click(function(){
                $(this).parent().prepend('<span class="copied_text">Copied</span>');

                var code = $(this).attr('data-code');
                var url = "{{URL::to('/')}}/exam/"+code;

                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(url).select();
                document.execCommand("copy");
                $temp.remove();

                setTimeout(() => {
                $('.copied_text').remove();
                }, 1000);
            });
        });
    </script>
@endsection
