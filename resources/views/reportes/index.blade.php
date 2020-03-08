@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
    Reportes
@endsection

@section('breadcrumb_nivel')
    <li><a href="{{ url('/login') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>  
@endsection

@section('main-content')
 
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h4>Reportes</h4>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            </div>
          </div>
        </div>
      </div>
    </div>

@endsection