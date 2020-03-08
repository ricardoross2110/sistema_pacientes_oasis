@extends('adminlte::layouts.app')

@section('htmlheader_title')
  Error
@endsection

@section('contentheader_title')
    Error 400
@endsection

@section('breadcrumb_nivel')
    <li><a href="{{ url('/login') }}"><i class="fa fa-home"></i>Home</a></li>  
    <li class="active">Error</li>
@endsection

@section('main-content')
    <br>
    <div class="error-page">
      <h2 class="headline text-danger">
        <img src="{{ asset('/img/logo_ucsc.png') }}" style="height: 130px" alt="Cummins Logo" >
      </h2>

      <div class="error-content">
        <h3><i class="fa fa-warning text-danger" style="color:black"></i> Lo sentimos pero la página que busca no funciona.</h3>

        <p>
            No pudimos encontrar la página que estabas buscando.
            Mientras tanto, puedes regresar al home <a href="{{ url('/home') }}">haciendo click aquí</a>.
        </p>
      </div>
    </div>
@endsection
