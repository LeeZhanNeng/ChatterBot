<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $data['title'] }}</title>
    </head>
    <body>
        <p><b>Greetings {{ $data['name'] }}, </b></p>
        <br>
        <p>Your ({{ $data['exam_name'] }}) review has been approved!</p>
        <br>
        <p>Now you are able to check the results. </p>

        <a href="{{ $data['url'] }}">Click here to access the results page.</a>
        
        <p> </p>
        <br>
        <p> </p>
        <br>
        <p> </p>
        <br>
        <p>Best regards,</p>
        <br>
        <p>Kolej Universiti Selatan DKU 019 (J) (198704v)</p>
        <p>PTD 64888, Jalan Selatan Utama, KM 15, Off Jalan Skudai, 81300 Skudai, Johor, Malaysia.</p>
        <p>Phone: 07-558 6605 Ext: 117        Fax: 07-556 3306 Website: www.southern.edu.my</p>

    </body>
</html>