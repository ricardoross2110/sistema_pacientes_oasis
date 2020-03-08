@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Error 403
@endsection

@section('contentheader_title')
    Error 403
@endsection

@section('contentheader_description')    
    Error 403
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
      		<h3><i class="fa fa-warning text-warning" style="color:black"></i> Lo sentimos, no puedes acceder a esta página</h3>
	        <p>
        		Lamentablemente no tienes acceso a la página que buscas.
        		Puedes regresar al inicio <a href="{{ url('/home') }}">haciendo clic aquí</a>.
      		</p>
        </div>
  	</div>

@endsection

