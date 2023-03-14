<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - {{ ENV('APP_NAME') }}</title>
        <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('template/admin/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('template/admin/dist/css/adminlte.min.css') }}">
        {!! htmlScriptTagJsApi() !!}

        <style>
            #showPassword{
                display: none;
            }

            .fa{
                color: #333;
            
                margin: 8px 0 0 0;
                margin-left: -30px;
                padding: 4px 9px 25px 0px;
                border-radius: 0px 5px 5px 0px;
            
                float: right;
                position: relative;
                right: 1%;
                top: -.2%;
                z-index: 5;
                
                cursor: pointer;
            }


        </style>
    </head>
    <body class="hold-transition login-page">
        @php
            if (!$errors->isEmpty()) {
                alert()->error('Pemberitahuan', implode('<br>', $errors->all()))->toToast()->toHtml();
            }
        @endphp
        <div class="login-box">
        <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="{{ route('login') }}" class="h1"><b>{{ ENV('APP_NAME') }}</b></a>
                </div>
                <div class="card-body">
                    <form method="POST" id="#recaptcha-form" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                            <span class="eye" onclick="showPassword()">
                                <i id="showPassword" class="fa fa-eye"></i>
                                <i id="hidePassword" class="fa fa-eye-slash"></i>
                            </span>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        {{-- <div class="form-group mb-3">
                            <div class="col-md-12">
                                {!! htmlFormSnippet([
                                    "theme" => "light",
                                    "size" => "normal",
                                    "tabindex" => "3",
                                    "callback" => "callbackFunction",
                                    "expired-callback" => "expiredCallbackFunction",
                                    "error-callback" => "errorCallbackFunction",
                                ]) !!}
                            </div>
                        </div> --}}
                        <div class="row">
                            {{-- <div class="col-4">
                                <div class="icheck-primary">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div> --}}
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Log In') }}</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        @include('sweetalert::alert')
        <!-- /.login-box -->
        <!-- jQuery -->
        <script src="{{ asset('template/admin/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
            <script src="{{ asset('template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('template/admin/dist/js/adminlte.js') }}"></script>
        <script>
            function showPassword(){
                var x = document.getElementById("password");
                var y = document.getElementById("showPassword");
                var z = document.getElementById("hidePassword");

                if(x.type === 'password'){
                    x.type = "text";
                    y.style.display = "block";
                    z.style.display = "none";
                }
                else{
                    x.type = "password";
                    y.style.display = "none";
                    z.style.display = "block";
                }
            }
        </script>
    </body>
</html>
