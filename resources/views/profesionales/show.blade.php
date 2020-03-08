@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.profesional') }}
@endsection

@section('contentheader_title')
    Detalle profesional
@endsection

@section('breadcrumb_nivel')
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.administracion') }}</li>
    <li>{{ trans('adminlte_lang::message.profesional') }}</li>
    <li class="active">Detalle profesional</li>
@endsection

@section('main-content')
	
	<div> 
		<a href="{{ url('/profesionales') }}" type="button" class="btn btn-default">Volver</a>
		@foreach($profesionales As $profesional)
			@if($profesional->estado == 'Activo')
				<a href="{{ url('/profesionales/'.$profesional->rut.'/edit') }}" class="btn btn-info" role="button">Editar</a>
				<a href="" class="btn btn-success" data-toggle="modal" data-target="#modalEliminarProfesional-{{ $profesional->rut }}" title="Eliminar profesional">Eliminar
		        </a>
		        <div class="modal fade" id="modalEliminarProfesional-{{ $profesional->rut }}">
			        <div class="modal-dialog">
			            <div class="modal-content">
			                <div class="modal-header bg-red">
			                    <h4 class="modal-title text-center">Confirmar eliminación</h4>
			                </div>
			                <div class="modal-body">
			                    <h3 class="text-center">¿Está seguro de eliminar este profesional?</h3>
			                </div>
			                <div class="modal-footer">
			                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
			                    <a href="{{ url('/profesionales/destroy').'/'.$profesional->rut }}" type="submit" class="btn btn-danger" role="button">Aceptar</a>
			                </div>
			            </div>
			        </div>
			    </div>
		    @else
		    	<a href="" class="btn btn-success" data-toggle="modal" data-target="#modal-activar_{{ $profesional->rut }}" title="Activar profesional">Activar
		        </a>
		        <div class="modal fade" id="modal-activar_{{ $profesional->rut }}" style="display: none;">
	                <div class="modal-dialog">
	                    <div class="modal-content">
	                        <div class="modal-header bg-green">
	                            <h4 class="modal-title text-center">Confirmar activación</h4>
	                        </div>

	                        <div class="modal-body">
	                            <h3 class="text-center">¿Está seguro de activar este profesional?</h3>
	                        </div>
	                        
	                        <div class="modal-footer">
	                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
	                            <a href="{{ url('/profesionales/activate').'/'.$profesional->rut }}" type="submit" class="btn btn-success" role="button">Aceptar</a>
	                        </div>
	                    </div>
	                </div>
	            </div>'
	        @endif
		@endforeach
	</div>
	
	<br>

	<div class="row">
		<div class="col-md-12">
		<div class="box box-info">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="box-body table-responsive">
				@foreach($profesionales As $profesional)
				<table class="dataTables_wrapper table table-bordered">
					<tbody>
						<tr>
						    <th class="text-left" width="25%">RUT</th>
						    <td class="text-left" width="25%">{{ $profesional->rut }}-{{ $profesional->dv }}</td>
						    <th class="text-left" width="25%">Nombre</th>
						    <td class="text-left" width="25%">{{ $profesional->nombres }} {{ $profesional->apellido_paterno }} {{ $profesional->apellido_materno }}</td>
						</tr>
						<tr>
						    <th class="text-left" width="25%">Correo electrónico</th>
						    <td class="text-left" width="25%">{{ $profesional->email }}</td>
						    <th class="text-left" width="25%">Dirección</th>
						    <td class="text-left" width="25%">{{ $profesional->direccion }}</td>
						</tr>
						<tr>
						    <th class="text-left" width="25%">Teléfono</th>
						    <td class="text-left" width="25%">{{ $profesional->telefono }}</td>
						    <th class="text-left" width="25%">Sucursal</th>
						    <td class="text-left" width="25%">{{ $sucursales }}</td>
						</tr>
						<tr>
						    <th class="text-left" width="25%">Profesión</th>
						    <td class="text-left" width="25%">{{ $profesional->profesion }}</td>
						    <th class="text-left" width="25%">Tipo de contrato</th>
						    <td class="text-left" width="25%">{{ $profesional->tipo_contrato }}</td>
						</tr>
						<tr>
						    <th class="text-left">Estado</th>
						    <td class="text-left" colspan="3">{{ $profesional->estado }}</td>
						</tr>
						<tr>
						    <th class="text-left">Observación</th>
						    <td class="text-left" colspan="3">{{ $profesional->observacion }}</td>
						</tr>
					</tbody>
				</table>
				@endforeach
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Detalle de atención</h3>
				</div>
				<div class="box-body table-responsive">
		              {!! Form::open(['route' => 'profesionales.exportExcelAtenciones',  'method' => 'POST']) !!}
		                  {!! Form::text('rutExcel', null , ['class' => 'hidden', 'id' => 'rutExcel'] ) !!}
		                  <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
		                      <span class="fa fa-download"></span>
		                  </button>
		              {!! Form::close() !!}
		              <br>
					<table id="tableAtencion" class="table table-bordered">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Hora</th>
								<th>Sucursal</th>
								<th>Paciente</th>
								<th>Abono</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
@parent

  <script type="text/javascript">

    var token               = "{{ csrf_token() }}";

    @foreach($profesionales As $profesional)
    	var rut                	= '{{ $profesional->rut }}';
    @endforeach

	// datatable grilla TablaVentas
    $ ('#tableAtencion').DataTable({
	    processing: true,
	    pageLength: 10,
	    searching   : false,
	    language: {
	        "url": '{!! asset('/plugins/datatables/latino.json') !!}'
	    },
	    order: [[ 0, "asc" ], [ 2, "asc" ]],
	    ajax: {
            url: "{{ url('profesionales.getTableAtencion')}}",
            type: "post",
            data:{
                    rut                	: rut,
                    "_token"            : token,                     
                },
        },
        columns: [
                {class : "text-center",
                 data: 'fecha'},
                {class : "text-center",
                 data: 'hora'},
                {class : "text-center",
                 data: 'sucursal'},
                {class : "text-center",
                 data: 'paciente'},
                {class : "text-center",
                 data: 'abono'}
            ],
    });

    function GuardarValores(){
        var rutExcel                =   rut;
  
        if(rutExcel != ''){
            $('#rutExcel').val(rutExcel);
        }
    }

    </script> 

@endsection