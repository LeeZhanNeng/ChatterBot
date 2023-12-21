<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col md-12" style="padding: 15px; text-align: right;">
                <a class="btn btn-light btn-lg" href="{{ route('/') }}">Home</a>
                <a class="btn btn-light btn-lg" href="{{ route('aboutus') }}">About Us</a>
            </div>
            <div class="col-md-12">
                <p style="font-weight: bold; font-size: 30px;">What is ChatterBot?</p>
                <p style="font-size: 20px;">ChatterBot, your indispensable AI companion for IT Project Management, revolutionizes the learning and teaching experience. Tailored for both students and lecturers, ChatterBot combines cutting-edge AI capabilities with project management expertise. Students benefit from personalized assistance, instant access to resources, and seamless assessment interactions, while lecturers find a versatile tool to plan, manage, and assess projects efficiently. With real-time insights, interactive guidance, and streamlined communication, ChatterBot redefines project management education, enhancing collaboration, efficiency, and success for all.</p>
            </div>
            <div class="col-md-9">
                <p style="font-weight: bold; font-size: 30px;">Our Team</p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card border-0" id="aboutus">
                            <img src="{{asset('images/member1.jpg')}}" alt="" class="img-fluid" height="100" width="100" style="margin-left: auto; margin-right: auto;">
                            <div class="card-header border-0" style="text-align: center; font-size: 20px;">
                                Lim Jie Lyn
                                <h5 style="text-align: center; font-size: 12px;">Project Manager</h5>
                            </div>
                            <div class="card-body">
                                <p>As a project manager, my expertise lies in strategic planning, stakeholder communication, and risk management, enabling me to drive projects from inception to completion while fostering collaboration and ensuring high-quality results.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0" id="aboutus">
                            <img src="{{asset('images/member2.jpeg')}}" alt="" class="img-fluid" height="100" width="100" style="margin-left: auto; margin-right: auto;">
                            <div class="card-header border-0" style="text-align: center; font-size: 20px;">
                                Wong Ji Xuan
                                <h5 style="text-align: center; font-size: 12px;">UI Developer</h5>
                            </div>
                            <div class="card-body">
                                <p>With a keen eye for design aesthetics and a proficiency in front-end technologies, I bring concepts to life through intuitive user interfaces. My commitment to pixel-perfect precision and a user-centered approach ensures seamless navigation and visually appealing interfaces that captivate and engage users.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0" id="aboutus">
                            <img src="{{asset('images/member3.jpeg')}}" alt="" class="img-fluid" height="100" width="100" style="margin-left: auto; margin-right: auto;">
                            <div class="card-header border-0" style="background-color: transparent; text-align: center; font-size: 20px;">
                                Lee Zhan Neng
                                <h5 style="text-align: center; font-size: 12px;">Front-End & Back-End Coder</h5>
                            </div>
                            <div class="card-body">
                                <p>As a front-end & back-end coder, my expertise extends to robust back-end development, ensuring seamless data management and efficient system functionality. Through a holistic approach, I contribute to the team with comprehensive solutions that deliver impactful results.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">&nbsp;</div>
        </div>
    </div>
</body>
</html>
