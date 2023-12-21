<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo-details">
            <img src="{{asset('images/chatbot.png')}}" alt="" class="icon" height="50" width="50">
            <input type="text" class="logoName" value="ChatterBot" readonly>
            <i class="bx bx-menu" id="sidebarbtn"></i>
        </div>
        <ul class="nav-list">
            @if(Auth::user()->user_type == 'admin')
            <li>
                <a href="{{ route('loadAdminRegister') }}">
                <i class="bx bx-file"></i>
                <span class="itemName">Register</span>
                </a>
                <span class="item">Register</span>
            </li>
            <li>
                <a href="{{ route('reviewUser') }}">
                <i class="bx bx-user"></i>
                <span class="itemName">Review User</span>
                </a>
                <span class="item">Review User</span>
            </li>
            @elseif(Auth::user()->user_type == 'lecturer')
            <li>
                <a href="{{ route('home') }}">
                <i class="bx bx-home"></i>
                <span class="itemName">Home</span>
                </a>
                <span class="item">Home</span>
            </li>
            <li>
                <a href="{{ route('aiChat') }}">
                <i class="bx bx-chat"></i>
                <span class="itemName">Chat</span>
                </a>
                <span class="item">Chat</span>
            </li>
            <li>
                <a href="{{ route('subject') }}">
                <i class="bx bx-book"></i>
                <span class="itemName">Category</span>
                </a>
                <span class="item">Category</span>
            </li>
            <li>
                <a href="{{ route('exam') }}">
                <i class="bx bx-task"></i>
                <span class="itemName">Exams</span>
                </a>
                <span class="item">Exams</span>
            </li>
            <li>
                <a href="{{ route('questionAnswer') }}">
                <i class="bx bx-help-circle"></i>
                <span class="itemName">Q&A</span>
                </a>
                <span class="item">Q&A</span>
            </li>
            <li>
                <a href="{{ route('mark') }}">
                <i class="bx bx-check"></i>
                <span class="itemName">Marks</span>
                </a>
                <span class="item">Marks</span>
            </li>
            <li>
                <a href="{{ route('reviewExam') }}">
                <i class="bx bx-file"></i>
                <span class="itemName">Review</span>
                </a>
                <span class="item">Review</span>
            </li>
            @else
            <li>
                <a href="{{ route('home') }}">
                <i class="bx bx-home"></i>
                <span class="itemName">Home</span>
                </a>
                <span class="item">Home</span>
            </li>
            <li>
                <a href="{{ route('aiChat') }}">
                <i class="bx bx-chat"></i>
                <span class="itemName">Chat</span>
                </a>
                <span class="item">Chat</span>
            </li>
            <li>
                <a href="{{ route('studentExamIndex') }}">
                <i class="bx bx-task"></i>
                <span class="itemName">Exam</span>
                </a>
                <span class="item">Exam</span>
            </li>
            <li>
                <a href="{{ route('resultIndex') }}">
                <i class="bx bx-book"></i>
                <span class="itemName">Result</span>
                </a>
                <span class="item">Result</span>
            </li>
            @endif
            <li class="profile">
                <div class="user">
                    <div class="username">
                        @guest
                            <input type="text" class="username" value="Username" readonly>
                        @else
                            <input type="text" class="username" value="{{ Auth::user()->name }}" readonly>
                        @endguest
                    </div>
                    <!--<img src="{{asset('images/member3.jpeg')}}" alt="profileImg">-->
                    <i class='bx bx-user-circle' ></i>
                </div>
                @guest
                @else
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="bx bx-log-out" id="log_out"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
            </li>
        </ul>
    </div>
    <div class="section">
        @yield('content')
    </div>
    
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
    <script>
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#sidebarbtn");
        closeBtn.addEventListener("click", ()=>{
            sidebar.classList.toggle("open");
            menuBtnChange();
        });
        function menuBtnChange() {
            if(sidebar.classList.contains("open")){
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            }else {
                closeBtn.classList.replace("bx-menu-alt-right","bx-menu");
            }
        }
    </script>
</body>
</html>
