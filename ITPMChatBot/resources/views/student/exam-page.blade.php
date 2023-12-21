@extends('empty-layout')

@section('content')
    @php
        $endTime = $exam[0]['end_time']; // Update this with the correct variable for end time
    @endphp
    <div class="container">
        <p style="font-size: 1rem; color: black; padding-top:.5rem">Welcome, {{ Auth::user()->name }}</p>
        <h1 class="text-center">{{ $exam[0]['exam_name'] }}</h1>
        @php
            $qcount = 1;
        @endphp
        @if($success == true)
            @if($qna->isNotEmpty())
                <h4 class="text-right time">{{ $exam[0]['time'] }}</h4>
                <form action="{{ route('examSubmit') }}" method="POST" id="exam_form" class="md-5">@csrf
                <input type="hidden" name="exam_id" value="{{ $exam[0]['id'] }}">
                @forelse($qna as $data)
                    <div>
                        <h5>Q{{$qcount++}}.</h5>
                        @if($data['question'][0]['image'] != 'empty.jpg' && !empty($data['question'][0]['image']))
                        <img src="{{ asset ('images/') }}/{{ $data['question'][0]['image'] }}" class="img-fluid" alt="">
                        @endif
                        <h5>{{ $data['question'][0]['question'] }}</h5>
                        <input type="hidden" name="q[]" value="{{ $data['question'][0]['id'] }}">
                        <input type="hidden" name="ans_{{$qcount-1}}" id="ans_{{$qcount-1}}">

                        @php
                            $shuffledAnswers = collect($data['question'][0]['answers'])->shuffle();
                            $acount = 1;
                        @endphp
                        @foreach($shuffledAnswers as $answer)
                            <p>
                                <input type="radio" name="radio_{{$qcount-1}}" data-id="{{$qcount-1}}" class="select_ans" value="{{ $answer['id'] }}">
                                <b>{{$acount++}}. </b>{{ $answer['answer'] }}
                            </p>
                        @endforeach
                    </div>
                    <br>
                @empty
                @endforelse
                    <div class="text-center">
                        <input type="submit" class="btn btn-info">
                    </div>
                </form>
            @else
                <h3 style="color:red;" class="text-center">Questions & Answers not available!</h3>
            @endif
        @else
            <h3 style="color:red;" class="text-center">{{ $msg }}</h3>
        @endif
    </div>

    <script>
        $(document).ready(function(){
            $('.select_ans').click(function(){
                var no = $(this).attr('data-id');
                $('#ans_'+no).val($(this).val());
            });

            // Get current time in HH:MM:SS format
            function getCurrentTime() {
                var now = new Date();
                var hours = now.getHours().toString().padStart(2, '0');
                var minutes = now.getMinutes().toString().padStart(2, '0');
                var seconds = now.getSeconds().toString().padStart(2, '0');
                return hours + ':' + minutes + ':' + seconds;
            }

            // Display current time
            $('.time').text(getCurrentTime() + ' Left time');

            // Get end time from PHP variable
            var endTime = @json($endTime);
            var endDateTime = new Date(endTime);

            // Update time every second
            var timer = setInterval(function() {
                var now = new Date();

                if (isNaN(now.getTime())) {
                    // Handle invalid date
                    console.error("Invalid date. Stopping timer.");
                    clearInterval(timer);
                    return;
                }

                var currentTime = getCurrentTime(now);
                var remainingTime = getRemainingTime(now, endDateTime);
                console.log(currentTime);
                console.log(remainingTime);

                // Display current time and remaining time
                $('.time').html(`Current Time: ${currentTime} | Remaining Time: ${remainingTime}`);

                if (now >= endDateTime) {
                    clearInterval(timer);
                    $('#exam_form').submit();
                }
            }, 1000);

            // Function to calculate remaining time
            function getRemainingTime(currentTime, endTime) {
                var timeDiff = Math.floor((endTime - currentTime) / 1000);
                var hours = Math.floor(timeDiff / 3600);
                var minutes = Math.floor((timeDiff % 3600) / 60);
                var seconds = timeDiff % 60;

                return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        });
        
        function isValid(){
            var result = true;
            var qlength = parseInt("{{$qcount}}")-1;
            $('.error_msg').remove();
            for(let i = 1; i <= qlength; i++){
                if($('#ans_'+i).val() == ""){
                    result = false;
                    $('#ans_'+i).parent().append('<span style="color:red;" class="error_msg">Please select answer</span>');
                    setTimeout(() => {
                        $('.error_msg').remove();
                    }, 5000);
                }
            }
            return result;
        }
    </script>

@endsection