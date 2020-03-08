@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Login
@endsection

@section('content')


    
    <!-- Main Header -->
    <body class="hold-transition skin-black-light sidebar-mini login-page">
        <!-- Main Header -->
        <header class="main-header">
            <!-- Logo -->
            <a href="{{ url('/home') }}" class="logo" >
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <img src="{{ asset('/img/logo_clinicaoasis.png') }}" width="150" height="45"  alt="Clinica Oasis Logo">
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>logo_clinicaoasis</b></span>
                <span class="logo-mini"><img src="{{ asset('/img/logo_clinicaoasis.png') }}" width="150" height="45" alt="Clinica Oasis Logo"></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><img src="{{ asset('/img/logo_clinicaoasis.png') }}" width="150" height="45" alt="Clinica Oasis Logo"></span>
            </a>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation"></nav>
        </header>
        <div id="app">
            <div class="login-box">
                <div class="login-logo">
                    <b>Iniciar sesión</b>
                </div>
                @if(isset($error))
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif                
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                        <ul>
                            <li>{{ session('error') }}</li>
                        </ul>
                    </div>
                @endif
                <div id="mensaje"></div>
                <div class="box box-info">
                    <div class="login-box-body">
                        <form action="{{ url('/login') }}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" required="required" placeholder="Ingrese RUT sin puntos, sin guion y sin DV" id="rut" name="rut" maxlength="8" onkeypress="return onlyNumbers(event)" />
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="input-group">
                                <input type="password" class="form-control" required="required" placeholder="Ingrese contraseña" name="password" />
                                <span id="show-hide-passwd" action="hide" class="input-group-addon glyphicon glyphicon glyphicon-eye-open"></span>
                                
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-info btn-block btn-flat">{{ trans('adminlte_lang::message.buttonsign') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <!-- Al presionar el botón, cambiará de estado. Si es tipo password pasará a tipo text -->
    <script>
        $(document).on('ready', function() {
            $('#show-hide-passwd').on('click', function(e) {
                e.preventDefault();
                var current = $(this).attr('action');
                if (current == 'hide') {
                    $(this).prev().attr('type','text');
                    $(this).removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close').attr('action','show');
                }
                if (current == 'show') {
                    $(this).prev().attr('type','password');
                    $(this).removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open').attr('action','hide');
                }
            })
        })
    </script>

@endsection