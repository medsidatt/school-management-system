<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title', 'Hello')</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{  asset('assets/img/apple-touch-icon.png') }}'" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/jquery-confirm.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/datatable.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dataTables.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/buttons.dataTables.css') }}" rel="stylesheet">

    <script src="{{ asset('assets/vendor/bootstrap/js/jspdf.umd.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/jspdf.plugin.autotable.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/jquery.min.js') }}"></script>
    <link href="{{ asset('assets/vendor/bootstrap/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/vendor/bootstrap/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/jquery-confirm.js') }}"></script>

</head>

<body>
