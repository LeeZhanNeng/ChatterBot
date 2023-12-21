@extends('chat')

@section('sectionContent')
    <div class="chat-container">
        @if($aichathistories->isNotEmpty())
            <input type="hidden" name="chatId" id="chatId" value="{{ $aichathistories[0]->chat_id }}">
            <input type="hidden" name="chatTitle" id="chatTitle" value="{{ $aichathistories[0]->chat_title }}">
        @else
            <input type="hidden" name="chatId" id="chatId" value="">
            <input type="hidden" name="chatTitle" id="chatTitle" value="">
        @endif
        @forelse($aichathistories as $chathistory)
            @if($chathistory->source === 'user')
                <div class="send">
                    <input type="hidden" name="chatDatabaseId" id="chatDatabaseId" value="{{$chathistory->id}}">
                    <div class="message">{{$chathistory->message}}</div>
                </div>
            @else
                <div class="receive">
                    <input type="hidden" name="chatDatabaseId" id="chatDatabaseId" value="{{$chathistory->id}}">
                    <div class="message">
                        {{$chathistory->message}}
                        <div class="tts">
                            <i class="bx bx-play-circle playChat" data-history-id="{{$chathistory->id}}"></i>
                            <i class="bx bx-pause-circle pauseChat" data-history-id="{{$chathistory->id}}" style="display: none;"></i>
                            <i class="bx bx-stop-circle stopChat" data-history-id="{{$chathistory->id}}" style="display: none;"></i>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="emptyChat" style="display: flex; justify-content: center; width: 100%; height: 100%; align-items: flex-end; font-size: 1.125rem; color: #808080;">Try to ask some questions with ChatterBot...</div>
        @endforelse
    </div>
    <audio id="speechChat" src="#" type="audio/mp3" hidden></audio>
    <div class="scrollToggleButton"><i class='bx bx-down-arrow-alt'></i></div>
    <div class="chat">
        <textarea id="input" class="message" rows="1" placeholder="Ask questions with ChatterBot"></textarea>
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
                $('.emptyChat').remove();
                $('.chat-container').append(
                    `<div class="send">
                        <div class="message">`+$value+`</div>
                    </div>`
                );

                $chatId = $('#chatId').val();
                $chatTitle = $('#chatTitle').val();

                $.ajax({
                    type: 'post',
                    url: '{{ route('response') }}',
                    data: {
                        'input': $value,
                        'chatId': $chatId,
                        'chatTitle': $chatTitle,
                    },
                    success: function(data) {
                        
                        var redirectUrl = '{{ route('aiChatHistory', ['chatId' => ':chatId']) }}';
                        redirectUrl = redirectUrl.replace(':chatId', encodeURIComponent(data));
                    
                        window.location.href = redirectUrl;
                    }
                });
            }
        });
        $(document).ready(function () {
            var currentlyPlaying = null;
            var lastPlayed = null;
            var speechChat = $('#speechChat')[0];

            $('.playChat').on('click', function() {
                var historyId = $(this).data('history-id');

                var newAudioSource = '{{ asset('tts/speech.mp3') }}';

                if (currentlyPlaying != null && lastPlayed != historyId) {
                    speechChat.pause();
                    speechChat.currentTime = 0;
                    currentlyPlaying = historyId;
                }

                $('.playChat').show();
                $('.pauseChat').hide();
                $('.stopChat').hide();
                
                $('.playChat[data-history-id="'+historyId+'"]').hide();
                $('.pauseChat[data-history-id="'+historyId+'"]').show();
                $('.stopChat[data-history-id="'+historyId+'"]').show();
                
                if(lastPlayed != historyId){
                    $.ajax({
                        type: 'post',
                        url: '{{ route('tts', ['id' => ':id']) }}'.replace(':id', historyId),
                        success: function(response) {
                            console.log('TTS successfully.');
                            speechChat.src = newAudioSource;
                            speechChat.load();
                            speechChat.play();
                            lastPlayed = historyId;
                        },
                        error: function(error) {
                            console.error('Error:', error);
                        }
                    });
                } else {
                    speechChat.play();
                    lastPlayed = historyId;
                }
            });
            $('.pauseChat').on('click', function() {
                var historyId = $(this).data('history-id');
                $('.playChat[data-history-id="'+historyId+'"]').show();
                $('.pauseChat[data-history-id="'+historyId+'"]').hide();
                $('.stopChat[data-history-id="'+historyId+'"]').hide();
                
                speechChat.pause();
                currentlyPlaying = null;
            });
            $('.stopChat').on('click', function() {
                var historyId = $(this).data('history-id');
                $('.playChat[data-history-id="'+historyId+'"]').show();
                $('.pauseChat[data-history-id="'+historyId+'"]').hide();
                $('.stopChat[data-history-id="'+historyId+'"]').hide();

                speechChat.pause();
                speechChat.currentTime = 0;

                currentlyPlaying = null;
            });
        });
        
        speechChat.addEventListener('ended', function() {
            $('.playChat').show();
            $('.pauseChat').hide();
            $('.stopChat').hide();
            
            currentlyPlaying = null;
        });
    </script>
@endsection
