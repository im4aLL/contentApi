<!doctype html>
<html lang="en">
<head>
    <!-- =========================================
    This is custom application for manage website/application.
    Please don't do anything unexpected.
    author: Habib Hadi <hadicse[at]gmail.com>
    ============================================= -->
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - @yield('title')</title>

    <!-- stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/admin/admin.css') }}">
    @yield('inpagecss')
</head>
<body>

    <!-- header -->
    @if (Auth::check())
        @include('admin.shared.header')
    @endif
    <!-- header -->

    <!-- body -->
    @if (Auth::check())
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4 col-md-2 col-lg-1">@include('admin.shared.left')</div>
                <div class="col-sm-8 col-md-10 col-lg-11">
                    @include('admin.shared.breadcrumb')
                    @include('admin.shared.error')
                    @include('admin.shared.message')
                    @yield('content')
                </div>
            </div>
        </div>
    @else
        <div class="container">
            @yield('content')
        </div>
    @endif
    <!-- body -->

    <!-- scripts -->
    <script src="{{ asset('assets/admin/admin.js') }}"></script>
    @yield('inpagescripts')
</body>
</html>
