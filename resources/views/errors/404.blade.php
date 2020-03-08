@extends('adminlte::layouts.app')

@section('htmlheader_title')
  Error
@endsection

@section('contentheader_title')
    Error 404
@endsection

@section('breadcrumb_nivel')
    <li><a href="{{ url('/login') }}"><i class="fa fa-home"></i>Home</a></li>  
    <li class="active">Error</li>
@endsection

@section('main-content')
    <br>
    <div class="error-page">
      <h2 class="headline text-danger">
        <img src="{{ asset('/img/logo_oasis.png') }}" style="height: 80px; padding-right: 10px" alt="Oasis Logo" >
      </h2>
      <br>
      <div class="error-content">
        <h3><i class="fa fa-warning text-danger" style="color:black"></i> Lo sentimos, la página que buscas no funciona :(</h3>

        <p>
            No logramos encontrar la página que estabas buscando.
            Mientras tanto, puedes regresar al inicio <a href="{{ url('/home') }}">haciendo clic aquí</a>.
        </p>
      </div>
    </div>
@endsection