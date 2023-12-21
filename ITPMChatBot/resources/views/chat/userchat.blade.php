@extends('chat')

@section('sectionContent')
    <div class="chat-container">
        <input type="hidden" name="userId" id="userId" value="{{ $userId }}">
        @forelse($userschathistories as $chathistory)
            @if($chathistory->sender_id === Auth::id())
                <div class="send">
                    <input type="hidden" name="chatDatabaseId" id="chatDatabaseId" value="{{$chathistory->id}}">
                    <div class="message">{{$chathistory->message}}</div>
                </div>
            @else
                <div class="receive">
                    <input type="hidden" name="chatDatabaseId" id="chatDatabaseId" value="{{$chathistory->id}}">
                    <div class="message">{{$chathistory->message}}</div>
                </div>
            @endif
        @empty
        @endforelse
    </div>
    <div class="scrollToggleButton"><i class='bx bx-down-arrow-alt'></i></div>
    <div class="chat">
        <textarea id="input" class="message" rows="1" placeholder="Send a message"></textarea>
        <button id="stt" aria-label="stt"><div></div><i class='bx bxs-microphone'></i></button>
        <button id="send" aria-label="send"><i class='bx bxs-send'></i></button>
    </div>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#send").click(function(){
            $value = $('#input').val();
            $('#input').val('');
            if($value != '' && $value != null){
                $('.chat-container').append(
                    `<div class="send">
                        <div class="message">`+$value+`</div>
                    </div>`
                );

                $userId = $('#userId').val();

                $.ajax({
                    type: 'post',
                    url: '{{ route('send') }}',
                    data: {
                        'input': $value,
                        'userId': $userId,
                    },
                    success: function(data) {
                   
                        var redirectUrl = '{{ route('userChat', ['userId' => $userId]) }}';
                    
                        window.location.href = redirectUrl;
                    }
                });
            }
        });
    </script>
@endsection
