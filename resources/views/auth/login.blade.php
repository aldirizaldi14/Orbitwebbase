<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>
    <meta name="description" content="{{ env('APP_DESC') }}">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/metronic/style.bundle.css') }}" rel="stylesheet">
    
    <link rel="shortcut icon" href="{{ asset('images/icon.png') }}" />
</head>
<body  class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-3" id="m_login" style="background-image: url({{ asset('images/bg.jpg') }});">
            <div class="m-grid__item m-grid__item--fluid    m-login__wrapper">
                <div class="m-login__container">
                    <div style="text-align: center;">
                        <a href="#">
                            <img src="{{ asset('images/logo.png') }}">
                        </a>
                    </div>
                    <div class="m-login__signin">
                        <div class="m-login__head">
                            <h3 class="m-login__title">
                                UNIFIED PROCESS
                            </h3>
                        </div>
                        <form class="m-login__form m-form"  method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group m-form__group">
                                <input class="form-control m-input" type="text" placeholder="{{ __('Username') }}" name="user_username" autocomplete="off" value="{{ old('user_username') }}" autofocus required>
                            </div>
                            <div class="form-group m-form__group">
                                <input class="form-control m-input m-login__form-input--last" type="password" placeholder="{{ __('Password') }}" name="password" required autocomplete="current-password">
                            </div>
                            <div class="form-group m-form__group" style="text-align: center;">
                                @if($errors->any())
                                    @foreach ($errors->all() as $error)
                                       <span class="form-control-feedback" role="alert"><strong>{{ $error }}</strong></span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="m-login__form-action">
                                <button id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn">
                                    Sign In
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/vendors.js') }}" type="text/javascript"></script>
</body>
</html>