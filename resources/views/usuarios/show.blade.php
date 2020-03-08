@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.usuarios') }}
@endsection

@section('contentheader_title')
    Detalle usuario
@endsection

@section('breadcrumb_nivel')
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.administracion') }}</li>
    <li>{{ trans('adminlte_lang::message.usuarios') }}</li>
    <li class="active">Detalle usuario</li>
@endsection

@section('main-content')

	<div> 
		<a href="{{ url('/usuarios') }}" type="button" class="btn btn-default">Volver</a>
		@if($usuario->estado == 'Activo')
			@if($usuario->rut == Auth::user()->rut)
				<a href="{{ url('/usuarios/'.$usuario->rut.'/edit') }}" class="btn btn-info" role="button">Editar</a>
			@else
				<a href="{{ url('/usuarios/'.$usuario->rut.'/edit') }}" class="btn btn-info" role="button">Editar</a>
				<a href="" class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-eliminar_{{ $usuario->rut }}" title="Eliminar usuario">Eliminar
		        </a>
		        <div class="modal fade" id="modal-eliminar_{{ $usuario->rut }}" style="display: none;">
	                <div class="modal-dialog">
	                    <div class="modal-content">
	                        <div class="modal-header bg-red">
	                            <h4 class="modal-title text-center">Confirmar eliminación</h4>
	                        </div>

	                        <div class="modal-body">
	                            <h3 class="text-center">¿Está seguro de eliminar a este usuario?</h3>
	                        </div>
	                        
	                        <div class="modal-footer">
	                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
	                            <a href="{{ url('/usuarios/destroy').'/'.$usuario->rut }}" type="submit" class="btn btn-danger" role="button">Aceptar</a>
	                        </div>
	                    </div>
	                </div>
	            </div>
            @endif
	    @else
	    	<a href="" class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-activar_{{ $usuario->rut }}" title="Activar usuario">Activar</a>
	    	<div class="modal fade" id="modal-activar_{{ $usuario->rut }}" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-green">
                            <h4 class="modal-title text-center">Confirmar activación</h4>
                        </div>
                        <div class="modal-body">
                            <h3 class="text-center">¿Está seguro de activar a este usuario?</h3>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <a href="{{ url('/usuarios/activate').'/'.$usuario->rut }}" type="submit" class="btn btn-success" role="button">Aceptar</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
	</div>
	
	<br>

	<div class="col-md-6">
		<div class="box box-info">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="box-body table-responsive">
				<table class="dataTables_wrapper table table-bordered">
					<tbody>
						<tr>
						    <th class="text-left">RUT</th>
						    <td class="text-left">{{ $usuario->rut.'-'.$usuario->dv }}</td>
						</tr>
						<tr>
						    <th class="text-left">Nombre</th>
						    <td class="text-left">{{ $usuario->nombres.' '.$usuario->apellido_paterno.' '.$usuario->apellido_materno }}</td>	
						</tr>
						<tr>
						    <th class="text-left">Correo electrónico</th>
						    <td class="text-left">{{ $usuario->email }}</td>
						</tr>
						<tr>
						    <th class="text-left">Perfil</th>
						    <td class="text-left">{{ $usuario->perfil->nombre }}</td>
						</tr>
						<tr>
						    <th class="text-left">Fecha de registro</th>
						    <td class="text-left">{{ $usuario->fecha_registro }}</td>
						</tr>
						<tr>
						    <th class="text-left">Estado</th>
						    <td class="text-left">{{ $usuario->estado }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
@parent

  <script type="text/javascript">

    </script> 

@endsection