<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel</title>
    <link href="{{ asset('css/app.css?='.time()) }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css?='.time()) }}" rel="stylesheet">
    <link href="{{ asset('css/common.css?='.time()) }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            @include('include.admin_header')
        </nav>

        <div class="container-fluid" style="margin-top: 40px;">
            <div class="row">

                <div class="side col-sm-4 col-md-3 col-lg-2 sidebar" style="padding: 0;">
                    @include('include.admin_sidebar')
                </div>

                <div class="content col-sm-8 col-md-9 col-lg-10" style="margin-top: 40px;">
                    @include('include.status')
                    @yield('content')
                </div>

            </div>
        </div>
    </div>
    <script src="{{ asset('js/custom.js?p='.time()) }}"></script>
</body>
</html>
