<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vocards</title>

    <!-- <link href="/fonts/fonts.css" rel="stylesheet"> -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    
</head>

<body>
    <div id="app">
        <router-view></router-view>
    </div>
    <script src="/dist/app.js"></script>
</body>

</html>