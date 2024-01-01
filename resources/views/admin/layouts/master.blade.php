<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
  data-layout="vertical"
  data-topbar="light"
  data-sidebar="light"
  data-sidebar-size="lg"
  data-sidebar-image="none"
  data-preloader="disable"
>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <!-- jsvectormap css -->
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />
    <!--Swiper slider css-->
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    
    @include('admin.layouts.partial.css')
</head>
<body>
    @yield('content')
    @include('admin.layouts.partial.script')
    @include('admin.layouts.partial.modal')
    @yield('page-script')
</body>

</html>