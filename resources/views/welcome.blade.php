<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <!-- begin::Head -->
    <head>
        <meta charset="utf-8" />
        <title>
            {{ env('APP_NAME') }}
        </title>
        <meta name="description" content="{{ env('APP_DESC') }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!--begin:: Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/vendors.css') }}" rel="stylesheet">
        <link href="{{ asset('themes/metronic/style.bundle.css') }}" rel="stylesheet">
        <!--end:: Styles -->
        <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" />
    </head>
    <!-- end::Head -->
    <!-- begin::Body -->
    <body  class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
            <!-- BEGIN: Header -->
            @include('templates.header')
            <!-- END: Header -->        
            <!-- begin::Body -->
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                <!-- BEGIN: Left Aside -->
                @include('templates.sidebar')
                <!-- END: Left Aside -->
                @yield('content')
            </div>
            <!-- end:: Body -->
            <!-- begin::Footer -->
            @include('templates.footer')
            <!-- end::Footer -->
        </div>
        <!-- end:: Page -->
        <!-- end::Quick Sidebar -->         
        <!-- begin::Scroll Top -->
        <div id="m_scroll_top" class="m-scroll-top">
            <i class="la la-arrow-up"></i>
        </div>
        <!-- end::Scroll Top --> 
        <!--begin::Base Scripts -->
        <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/vendors.js') }}" type="text/javascript"></script>
        <!--end::Base Scripts -->
    </body>
    <!-- end::Body -->
</html>
