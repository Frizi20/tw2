@extends('layouts.app')
@section('content')
{{-- <div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4">
                <h1>{{ trans('panel.site_title') }}</h1>

                <p class="text-muted">{{ trans('global.login') }}</p>

                @if(session('message'))
                <div class="alert alert-info" role="alert">
                    {{ session('message') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>

                        <input id="email" name="email" type="text"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required
                            autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}"
                            value="{{ old('email', null) }}">

                        @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>

                        <input id="password" name="password" type="password"
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required
                            placeholder="{{ trans('global.login_password') }}">

                        @if($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                        @endif
                    </div>

                    <div class="input-group mb-4">
                        <div class="form-check checkbox">
                            <input class="form-check-input" name="remember" type="checkbox" id="remember"
                                style="vertical-align: middle;" />
                            <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                {{ trans('global.remember_me') }}
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary px-4">
                                {{ trans('global.login') }}
                            </button>
                        </div>
                        <div class="col-6 text-right">
                            @if(Route::has('password.request'))
                            <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                {{ trans('global.forgot_password') }}
                            </a><br>
                            @endif
                            <a class="btn btn-link px-0" href="{{ route('register') }}">
                                {{ trans('global.register') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}

{{-- Page Css files --}}

@section('styles')

<link rel="stylesheet" href="{{ asset(('css/form-validation.css')) }}">
<link rel="stylesheet" href="{{ asset(('css/authentication.css')) }}">
<link rel="stylesheet" href="{{ asset(('css/core.css')) }}">

@endsection

<div class="auth-wrapper auth-cover">
    <div class="auth-inner row m-0">
        <!-- Brand logo-->
        <a class="brand-logo" href="#" style="text-decoration: none;">
            {{-- <svg viewBox="0 0 139 95" version="1.1" xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink" height="28">
                <defs>
                    <lineargradient id="linearGradient-1" x1="100%" y1="10.5120544%" x2="50%" y2="89.4879456%">
                        <stop stop-color="#000000" offset="0%"></stop>
                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                    </lineargradient>
                    <lineargradient id="linearGradient-2" x1="64.0437835%" y1="46.3276743%" x2="37.373316%" y2="100%">
                        <stop stop-color="#EEEEEE" stop-opacity="0" offset="0%"></stop>
                        <stop stop-color="#FFFFFF" offset="100%"></stop>
                    </lineargradient>
                </defs>
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Artboard" transform="translate(-400.000000, -178.000000)">
                        <g id="Group" transform="translate(400.000000, 178.000000)">
                            <path class="text-primary" id="Path"
                                d="M-5.68434189e-14,2.84217094e-14 L39.1816085,2.84217094e-14 L69.3453773,32.2519224 L101.428699,2.84217094e-14 L138.784583,2.84217094e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L6.71554594,44.4188507 C2.46876683,39.9813776 0.345377275,35.1089553 0.345377275,29.8015838 C0.345377275,24.4942122 0.230251516,14.560351 -5.68434189e-14,2.84217094e-14 Z"
                                style="fill: currentColor"></path>
                            <path id="Path1"
                                d="M69.3453773,32.2519224 L101.428699,1.42108547e-14 L138.784583,1.42108547e-14 L138.784199,29.8015838 C137.958931,37.3510206 135.784352,42.5567762 132.260463,45.4188507 C128.736573,48.2809251 112.33867,64.5239941 83.0667527,94.1480575 L56.2750821,94.1480575 L32.8435758,70.5039241 L69.3453773,32.2519224 Z"
                                fill="url(#linearGradient-1)" opacity="0.2"></path>
                            <polygon id="Path-2" fill="#000000" opacity="0.049999997"
                                points="69.3922914 32.4202615 32.8435758 70.5039241 54.0490008 16.1851325"></polygon>
                            <polygon id="Path-21" fill="#000000" opacity="0.099999994"
                                points="69.3922914 32.4202615 32.8435758 70.5039241 58.3683556 20.7402338"></polygon>
                            <polygon id="Path-3" fill="url(#linearGradient-2)" opacity="0.099999994"
                                points="101.428699 0 83.0667527 94.1480575 130.378721 47.0740288"></polygon>
                        </g>
                    </g>
                </g>
            </svg> --}}
            <h2 class="brand-text text-primary ms-1" style="color: #303c54 !important;">Twosavi</h2>
        </a>
        <!-- /Brand logo-->

        <!-- Left Text-->
        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5" style="background-color: #f8f8f8">
            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">

                <img class="img-fluid" src="{{asset('images/pages/login-v2.svg')}}" alt="Login V2" />
            </div>
        </div>
        <!-- /Left Text-->

        <!-- Login-->
        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                <h2 class="card-title fw-bold mb-1">Welcome to twosavy ! 👋</h2>
                <p class="card-text mb-2">Please sign-in to your account and start the adventure</p>
                <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-1">
                        <label class="form-label" for="login-email">Email</label>
                        <input id="email" name="email" type="text"
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required
                            autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}"
                            value="{{ old('email', null) }}">
                        @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                        {{-- <input class="form-control" id="login-email" type="text" name="login-email"
                            placeholder="john@example.com" aria-describedby="login-email" autofocus="" tabindex="1" />
                        --}}
                    </div>
                    <div class="mb-1">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="login-password">Password</label>
                            <a href="{{ route('password.request') }}">
                                <small>Forgot Password?</small>
                            </a>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">

                            {{-- <input class="form-control form-control-merge" id="login-password" type="password"
                                name="login-password" placeholder="············" aria-describedby="login-password"
                                tabindex="2" /> --}}


                            <input id="password" name="password" type="password"
                                class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required
                                placeholder="{{ trans('global.login_password') }}">
                            @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                            @endif
                            <span class="input-group-text icon cursor-pointer"><i class="fa fa-eye"
                                    aria-hidden="true"></i>
                                {{-- <i class="fa fa-eye-slash" aria-hidden="true"></i> --}}
                            </span>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="form-check">

                            <input class="form-check-input" name="remember" type="checkbox" id="remember"
                                style="vertical-align: middle;" />
                            <label class="form-check-label ml-2" for="remember" style="vertical-align: middle;">
                                {{ trans('global.remember_me') }}
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" tabindex="4"
                        style="background-color: #303c54">Sign in</button>

                </form>
                <p class="text-center mt-2">
                    <span>New on our platform?</span>
                    <a href="{{ route('register') }}"><span>&nbsp; {{ trans('global.register') }}</span></a>
                </p>
                {{-- <div class="divider my-2">
                    <div class="divider-text">or</div>
                </div>
                <div class="auth-footer-btn d-flex justify-content-center">
                    <a class="btn btn-facebook" href="#"><i data-feather="facebook"></i></a>
                    <a class="btn btn-twitter white" href="#"><i data-feather="twitter"></i></a>
                    <a class="btn btn-google" href="#"><i data-feather="mail"></i></a>
                    <a class="btn btn-github" href="#"><i data-feather="github"></i></a>
                </div> --}}
            </div>
        </div>
        <!-- /Login-->
    </div>
</div>

@section('scripts')
@parent
<script>
    const container = document.querySelector('.container')
    const eyeIcon = document.querySelector('.input-group-text.icon')
    const passwrodInput = document.querySelector('#password')

    container.classList.remove('container')
    container.classList.add('page-wrapper')

    eyeIcon.addEventListener('click',(e)=>{
        const clicked = e.target.closest('.input-group-text')
        if(!clicked) return

        const eyeClosedClass = 'fa fa-eye-slash'
        const eyeOpenedClass = 'fa fa-eye'
        const icon = clicked.children[0]

        if(icon.className == eyeOpenedClass){
            icon.className = eyeClosedClass
            passwrodInput.type = 'text'
            // passwrodInput.placeholder = ''
        }else{
            icon.className = eyeOpenedClass
            passwrodInput.type = 'password'
            // passwrodInput.placeholder = "············"
        }


    })
</script>

@endsection

@endsection
