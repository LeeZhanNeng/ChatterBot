@extends('layout')

@section('content')
    <div class="users-sidebar">
        <div class="aichat">
            <div class="chatbot">
                <div class="chatterbot">
                    ChatterBot
                    <i class='bx bx-chevron-down' id="list-status"></i>
                </div>
            </div>
            <span>
                <div class="chat-history">
                    <ol>
                        <li><a href="{{ route('aiChat') }}"><div>New Chat</div></a></li>
                        @foreach($aichathistorylist as $history)
                            <li>
                                <a href="{{ route('aiChatHistory', ['chatId' => $history->chat_id]) }}">
                                    <div>{{$history->chat_title}}</div>
                                    <i class='bx bx-dots-vertical-rounded' id="aiChatActions" data-chat-id="{{ $history->chat_id }}" onclick="showActionsMenu(this, event)"></i>
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </div>
                <div id="actionsMenu" style="display: none;">
                    <ol>
                        <li><a href="#" onclick="renameChat(event)">Rename</a></li>
                        <li class="danger"><a href="#" onclick="return confirm('Are you sure you want to delete this chat?')">Delete</a></li>
                    </ol>
                </div>
            </span>
        </div>
        <div class="users">
            <ol>
                @foreach($users as $user)
                    @if($user->user_type != 'admin')
                        <li class="user-item"><a href="{{ route('userChat', ['userId' => $user->id]) }}"><div>{{$user->name}}</div></a></li>
                    @endif
                @endforeach
            </ol>
        </div>
        <div class="search">
            <input type="text" class="searchbar" id="searchInput" placeholder="Search users..."/>
        </div>
    </div>
    <div class="chat-section">
        @yield('sectionContent')
    </div>
    
    <script>
        $(document).ready(function () {
            var remSize = 1 * parseFloat(getComputedStyle(document.documentElement).fontSize);
            
            var usersSidebar = $('.users-sidebar');
            var chatbot = $('.chatbot');
            var users = $('.users');
            var search = $('.search');
            var historyList = $('.chatterbot');
            var chatHistory = $('.chat-history');
            var closeList = $('#list-status');
            
            var chatbotHeight = parseFloat(chatbot.css('height').replace('px',''));
            var usersSiderbarHeight = parseFloat(usersSidebar.css('height').replace('px',''));
            var searchHeight = parseFloat(search.css('height').replace('px',''));
            var chatHistoryMaxHeight = parseFloat(chatHistory.css('max-height').replace('px',''));
            var chatHistoryHeight = parseFloat(chatHistory.css('height').replace('px',''));
            var chatHistoryOverflowY = chatHistory.css('overflow-y');

            function setUsersListMaxHeight() {
                if (chatHistory.hasClass('off')) {
                    users.css('max-height', usersSiderbarHeight - chatbotHeight - searchHeight + 'px');
                    users.css('transition', 'all 0.35s ease');
                } else {
                    users.css('max-height', usersSiderbarHeight - chatbotHeight - chatHistoryHeight - searchHeight + 'px');
                }
            }

            setUsersListMaxHeight();

            historyList.click(function () {
                if (chatHistory.hasClass('off')) {
                    chatHistory.removeClass('off');
                } else {
                    chatHistory.addClass('off');
                }
                historyListStatusChange();
                setUsersListMaxHeight();
            });
            
            function historyListStatusChange() {
                if(chatHistory.hasClass('off')){
                    chatHistory.css('max-height', 0 + 'px');
                    chatHistory.css('overflow-y', 'hidden');
                    closeList.removeClass('bx-chevron-down').addClass('bx-chevron-right');
                }else {
                    chatHistory.css('max-height', chatHistoryMaxHeight + 'px');
                    chatHistory.css('overflow-y', 'auto');
                    closeList.removeClass('bx-chevron-right').addClass('bx-chevron-down');
                }
            }
            
            var container = $('.chat-container');
            var scrollToggleButton = $('.scrollToggleButton');
            var scrollThreshold = 96;

            var chatDiv = $('.chat');
            var textarea = $('#input');

            var chatContainerDivHeight = parseFloat(container.css('height').replace('px',''));
            var chatContainerDivMaxHeight = parseFloat(container.css('max-height').replace('px',''));
            var chatDivTop = parseFloat(chatDiv.css('top').replace('px',''));
            var chatDivHeight = parseFloat(chatDiv.css('height').replace('px',''));
            var textareaHeight = parseFloat(textarea.css('height').replace('px',''));
            var textareaLineHeight = parseFloat(textarea.css('line-height').replace('px',''));
            var scrollToggleButtonTop = parseFloat(scrollToggleButton.css('top').replace('px',''));
            var container = $('.chat-container');

            function scrollToBottom() {
                container.scrollTop(container[0].scrollHeight);
            }

            function toggleButtonVisibility() {
                var lineCount = (textarea.val().match(/\n/g)||[]).length+1;
                var distanceFromBottom = container[0].scrollHeight - (container.scrollTop() + container.height());
                if (Math.floor(distanceFromBottom) > scrollThreshold) {
                    scrollToggleButton.addClass('showed');
                } else {
                    scrollToggleButton.removeClass('showed');
                }

                if (lineCount<= 4) {
                    if(scrollToggleButton.hasClass('showed')){
                        scrollToggleButton.css('top', scrollToggleButtonTop - 64 - (textareaLineHeight * (lineCount-1)) + 'px');
                    } else {
                        scrollToggleButton.css('top', scrollToggleButtonTop - (textareaLineHeight * (lineCount-1)) + 'px');
                    }
                } else {
                    if(scrollToggleButton.hasClass('showed')){
                        scrollToggleButton.css('top', scrollToggleButtonTop - 64 - (textareaLineHeight * 4) + 'px');
                    } else {
                        scrollToggleButton.css('top', scrollToggleButtonTop - (textareaLineHeight * 4) + 'px');
                    }
                }
            }

            scrollToBottom();
            
            container.scroll(function () {
                toggleButtonVisibility();
            });

            scrollToggleButton.click(function () {
                scrollToBottom();
            });

            textarea.on('input', function() {
                var lineCount = (textarea.val().match(/\n/g)||[]).length+1;
                var distanceFromBottom = container[0].scrollHeight - (container.scrollTop() + container.height());

                if (lineCount<= 4) {
                    container.css('height', chatContainerDivHeight - (textareaLineHeight * (lineCount-1)) + 'px');
                    container.css('max-height', chatContainerDivMaxHeight - (textareaLineHeight * (lineCount-1)) + 'px');
                    chatDiv.css('top', chatDivTop - (textareaLineHeight * (lineCount-1)) + 'px');
                    chatDiv.css('height', chatDivHeight + (textareaLineHeight * (lineCount-1)) + 'px');
                    textarea.css('height', textareaHeight + (textareaLineHeight * (lineCount-1)) + 'px');
                    if(scrollToggleButton.hasClass('showed')){
                        scrollToggleButton.css('top', scrollToggleButtonTop - 64 - (textareaLineHeight * (lineCount-1)) + 'px');
                    } else {
                        scrollToggleButton.css('top', scrollToggleButtonTop - (textareaLineHeight * (lineCount-1)) + 'px');
                    }
                } else {
                    container.css('height', chatContainerDivHeight - (textareaLineHeight * 4) + 'px');
                    container.css('max-height', chatContainerDivMaxHeight - (textareaLineHeight * 4) + 'px');
                    chatDiv.css('top', chatDivTop - (textareaLineHeight * 4) + 'px');
                    chatDiv.css('height', chatDivHeight + (textareaLineHeight * 4) + 'px');
                    textarea.css('height', textareaHeight + (textareaLineHeight * 4) + 'px');
                    if(scrollToggleButton.hasClass('showed')){
                        scrollToggleButton.css('top', scrollToggleButtonTop - 64 - (textareaLineHeight * 4) + 'px');
                    } else {
                        scrollToggleButton.css('top', scrollToggleButtonTop - (textareaLineHeight * 4) + 'px');
                    }
                }

                if (Math.floor(distanceFromBottom) <= 16) {
                    container.scrollTop(container[0].scrollHeight);
                }
            });

            $('#searchInput').on('input', function () {
                var searchTerm = $(this).val().toLowerCase();
                
                $('.user-item').each(function () {
                    var userName = $(this).text().toLowerCase();
                
                    if (userName.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            var textareaInput = $('textarea#input');
            var buttonSTT = $('button#stt');
            var SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            
            if(SpeechRecognition) {
                var recognition = new SpeechRecognition();
                recognition.continuous = true;
            } else {
                buttonSTT.css('color', '#888888');
                buttonSTT.css('cursor','not-allowed');
            }

            buttonSTT.on('mousedown', function () {
                recognition.start();
                textareaInput.focus();
            });
            buttonSTT.on('mouseup', function () {
                recognition.stop();
                textareaInput.focus();
            });

            recognition.onresult = function(event) {
                var current = event.resultIndex;
                var transcript = event.results[current][0].transcript;

                textareaInput.val(transcript);
            };
        });
        
        function showActionsMenu(iconElement, event) {
            event.stopPropagation();
            event.preventDefault();

            var menu = document.getElementById('actionsMenu');

            var chatbot = $('.chatbot');
            var chatbotHeight = parseFloat(chatbot.css('height').replace('px',''));

            var icon = event.target;

            var liElement = iconElement.closest('li');
            var index = Array.from(liElement.parentElement.children).indexOf(liElement);
        
            menu.style.display = 'flex';
            menu.style.position = 'absolute';
            menu.style.top = chatbotHeight + (36 * index) + 'px';
            menu.style.left = 225 + 'px';

            var chatId = iconElement.getAttribute('data-chat-id');

            var renameAction = 'renameChat("' + chatId + '", event)';
            var deleteAction = 'deleteChat("' + chatId + '", event)';

            var renameLink = menu.querySelector('ol li:nth-child(1) a');
            var deleteLink = menu.querySelector('ol li:nth-child(2) a');

            var deleteUrl = "{{ route('deleteAiChat', ['chatId' => ':chatId']) }}"
            deleteUrl = deleteUrl.replace(':chatId', chatId);

            if (renameLink) {
                renameLink.setAttribute('onclick', renameAction);
            }

            if (deleteLink) {
                deleteLink.setAttribute('href', deleteUrl);
            }

            document.addEventListener('click', function hideMenu(e) {
                if (!menu.contains(e.target) && !icon.contains(e.target)) {
                    menu.style.display = 'none';
                    document.removeEventListener('click', hideMenu);
                }
            });
        }

        function renameChat(chatId, event) {
            event.stopPropagation();
            event.preventDefault();

            var newTitle = prompt('Enter a new title for the chat:');

            if (newTitle !== null) {
                $.ajax({
                    type: 'get',
                    url: '{{ route('renameAiChat', ['chatId' => ':chatId']) }}'.replace(':chatId', chatId),
                    data: {
                        chatId: chatId,
                        newTitle: newTitle,
                    },
                    success: function(response) {
                        console.log('Chat renamed successfully.');
                        $('li:has([data-chat-id="' + chatId + '"]) div').text(newTitle);
                    },
                    error: function(error) {
                        console.error('Error renaming chat:', error);
                    }
                });
            }
        }
    </script>

@endsection
