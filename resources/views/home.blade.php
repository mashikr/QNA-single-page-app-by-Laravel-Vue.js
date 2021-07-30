<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sigle Page App</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <style>
            body {
                font-family: 'Nunito';
            }
        </style>
    </head>
    <body>
        <div id="app">
            <base-component></base-component>
        </div>

       
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
