<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/dist/css/adminlte.min.css?v=3.2.0') }}">
    <link href="{{ asset('assets/backend/vendors/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/vendors/sweetalert2/animate.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/notiflix/notiflix-3.2.7.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/fullcalendar/main.css') }}">
    <script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>

</head>
<body class="hold-transition layout-top-nav">
@include('component.navbar')


<div class="wrapper">
    @yield('content')
</div>


<aside class="control-sidebar control-sidebar-dark">
</aside>


@include('component.footer')

<script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/backend/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
<script src="{{ asset('assets/backend/dist/js/demo.js') }}"></script>
<script src="{{ asset('assets/backend/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/notiflix/notiflix-report-aio-3.2.7.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/select2/js/select2.full.min.js') }}"></script>


<script src="{{ asset('assets/backend/plugins/fullcalendar/main.js') }}"></script>
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2563EB',
            });
        });
    </script>
@endif
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#2563EB',
            });
        });
    </script>
@endif
<script>
    window.addEventListener('beforeunload', function () {
        const session = {{ session()->has('imported_excel_data') ? true : false }};

        if(!window.shouldClearTemp &&  session) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const data = new Blob(
                [JSON.stringify({_token: token})],
                {type: 'application/json'}
            );
            navigator.sendBeacon('/clear-temp-session', data);
        }
    });
    </script>
</body>
</html>
