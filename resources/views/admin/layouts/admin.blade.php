@extends('admin.layouts.master')

@section('content')
<!-- Begin page -->
<div id="layout-wrapper">
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    @include('admin.layouts.partial.header')
    @include('admin.layouts.partial.sidebar')
    <div class="main-content">
        @yield('page-content')
        @include('admin.layouts.partial.footer')
    </div>


    
<!--start back-to-top-->
<button
      onclick="topFunction()"
      class="btn btn-danger btn-icon"
      id="back-to-top"
    >
      <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
      <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>

    


</div>
@endsection