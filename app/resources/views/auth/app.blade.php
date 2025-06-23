<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min.css?v=3.2.0') }}">
</head>
<body class="hold-transition login-page">
<div class="login-box">

    <div class="card card-outline card-red">
        <div class="card-header text-center">
            <a href="" class="h1"><b>Support </b>App</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }} "></script>
<script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
<script src="{{ asset('assets/backend/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
</body>
</html>
