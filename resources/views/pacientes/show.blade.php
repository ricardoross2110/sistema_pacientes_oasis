@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.pacientes') }}
@endsection

@section('contentheader_title')
    Detalle Paciente
@endsection

@section('breadcrumb_nivel')
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.administracion') }}</li>
    <li>{{ trans('adminlte_lang::message.pacientes') }}</li>
    <li class="active">Detalle paciente</li>
@endsection

@section('main-content')
	
	@foreach($pacientes As $paciente)
	<div> 
		<a href="javascript:history.back()" type="button" class="btn btn-default">Volver</a>
		@if(Auth::user()->perfil_id <= 2)
			@if($paciente->estado == 'Activo')
				<a href="{{ url('/pacientes/'.$paciente->rut.'/edit') }}" class="btn btn-info" role="button">Editar</a>
				<a href="" class="btn btn-success" data-toggle="modal" data-target="#modalEliminarCliente-{{ $paciente->rut }}" title="Eliminar paciente">Eliminar
		        </a>
		        <div class="modal fade" id="modalEliminarCliente-{{ $paciente->rut }}">
			        <div class="modal-dialog">
			            <div class="modal-content">
			                <div class="modal-header bg-red">
			                    <h4 class="modal-title text-center">Confirmar eliminación</h4>
			                </div>
			                <div class="modal-body">
			                    <h3 class="text-center">¿Está seguro de eliminar este paciente?</h3>
			                </div>
			                <div class="modal-footer">
			                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
			                    <a href="{{ url('/pacientes/destroy').'/'.$paciente->rut }}" type="submit" class="btn btn-danger" role="button">Aceptar</a>
			                </div>
			            </div>
			        </div>
			    </div>
		    @else
				<a href="" class="btn btn-success" data-toggle="modal" data-target="#modal-activar_{{ $paciente->rut }}" title="Eliminar paciente">Activar
		        </a>
		        <div class="modal fade" id="modal-activar_{{ $paciente->rut }}" style="display: none;">
	                <div class="modal-dialog">
	                    <div class="modal-content">
	                        <div class="modal-header bg-green">
	                            <h4 class="modal-title text-center">Confirmar activación</h4>
	                        </div>

	                        <div class="modal-body">
	                            <h3 class="text-center">¿Está seguro de activar este paciente?</h3>
	                        </div>
	                        
	                        <div class="modal-footer">
	                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
	                            <a href="{{ url('/pacientes/activate').'/'.$paciente->rut }}" type="submit" class="btn btn-success" role="button">Aceptar</a>
	                        </div>
	                    </div>
	                </div>
	            </div>'
		    @endif
		@endif
	</div>
    @endforeach
	
	<br>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="box-body table-responsive">
					@foreach($pacientes As $paciente)
						<table class="dataTables_wrapper table table-bordered">
							<tbody>
								<tr>
								    <th class="text-left" width="25%">RUT</th>
								    <td class="text-left" width="25%">{{ $paciente->rut }}-{{ $paciente->dv }}</td>
								    <th class="text-left" width="25%">Facebook</th>
								    <td class="text-left" width="25%">
								    	@if(is_null($paciente->facebook))
								    		No ingresó Facebook.
								    	@else
									    	<a href="{{ $paciente->facebook }}" target="_blank" class="btn btn-primary"><i class="fa fa-facebook-square"></i> Ir a Facebook</a>
								    	@endif
								    </td>
								</tr>
								<tr>
								    <th class="text-left" width="25%">Nombre</th>
								    <td class="text-left" width="25%">{{ $paciente->nombres }} {{ $paciente->apellido_paterno }} {{ $paciente->apellido_materno }}</td>
								    <th class="text-left" width="25%">Instagram</th>
								    <td class="text-left" width="25%">
								    	@if(is_null($paciente->instagram))
								    		No ingresó Instagram.
								    	@else
									    	<a href="{{ $paciente->instagram }}" target="_blank" class="btn btn-danger"><i class="fa fa-instagram"></i> Ir a Instagram</a>
								    	@endif
								    </td>
								</tr>
								<tr>
								    <th class="text-left" width="25%">Correo electrónico</th>
								    <td class="text-left" width="25%">{{ $paciente->email }}</td>
								    <th class="text-left" width="25%">Fecha de registro</th>
								    <td class="text-left" width="25%">{{ date_format(date_create($paciente->fecha_registro), 'd/m/Y') }}</td>
								</tr>
								<tr>
								    <th class="text-left">Dirección</th>
								    <td class="text-left">{{ $paciente->direccion }}</td>
								    <th class="text-left">Estado</th>
								    <td class="text-left">{{ $paciente->estado }}</td>
								</tr>
								<tr>
								    <th class="text-left">Télefono</th>
								    <td class="text-left">{{ $paciente->telefono }}</td>
								    <th class="text-left">Fecha de nacimiento</th>
								    <td class="text-left">{{ date_format(date_create($paciente->fecha_nacimiento), 'd/m/Y') }} <strong>({{ $paciente->edad }} Años)</strong></td>
								</tr>
								@if(!is_null($paciente->observacion))
								<tr>
								    <th colspan="1" class="text-left">Observación:</th>
								    <td colspan="3" class="text-left">{{ $paciente->observacion }}</td>
								</tr>
								@endif
							</tbody>
						</table>
					@endforeach
				</div>
			</div>
		</div>
	</div>
	@if(Auth::user()->perfil_id <= 2)
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Detalle de atención</h3>
					</div>
					<div class="box-body table-responsive">
			              {!! Form::open(['route' => 'pacientes.exportExcelAtenciones',  'method' => 'POST']) !!}
			                  {!! Form::text('rutExcel', null , ['class' => 'hidden', 'id' => 'rutExcel'] ) !!}
			                  <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
			                      <span class="fa fa-download"></span>
			                  </button>
			              {!! Form::close() !!}
			              <br>
						<table id="tableAtencion" class="table table-bordered">
							<thead>
								<tr>
									<th></th>
			                        <th class="text-center">N° folio</th>
			                        <th class="text-center">Tratamiento</th>
			                        <th class="text-center">N° control</th>
			                        <th class="text-center">Precio total</th>
			                        <th class="text-center">Deuda</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	@endif
@endsection

@section('scripts')
@parent

  <script type="text/javascript">

    var token               = "{{ csrf_token() }}";

    @foreach($pacientes As $paciente)
    	var rut                	= '{{ $paciente->rut }}';
    @endforeach

	// datatable grilla TablaVentas
    var table = $ ('#tableAtencion').DataTable({
	    processing: true,
	    pageLength: 10,
	    searching   : false,
	    language: {
	        "url": '{!! asset('/plugins/datatables/latino.json') !!}'
	    },
	    order: [ 1, "asc" ],
	    ajax: {
            url: "{{ url('pacientes.getTableAtencion')}}",
            type: "post",
            data:{
                    rut                	: rut,
                    "_token"            : token,                     
                },
        },
        columns: [
                {
                  "className":      'details-control',
                  "orderable":      false,
                  "data":           null,
                  "defaultContent": ''
                },
                {class : "text-center",
                  data: 'folio'},
                {class : "text-center",
                  data: 'nombre'},
                {class : "text-center",
                  data: 'num_control'},
                {class : "text-center",
                  data: 'total'},
                {class : "text-center",
                  data: 'deuda'}
            ],
    });

    $('#tableAtencion tbody').on('click', 'td.details-control', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr);
   
          if ( row.child.isShown() ) {
              row.child.hide();
              tr.removeClass('shown');
          }else {
            row.child('<table class="table table-bordered table-striped" id="tablaAtenciones_' + row.data().folio + '">' +
                '<thead>' +
                    '<tr>' +
                        '<th class="text-center">N° control</th>' +
                        '<th class="text-center">Fecha</th>' +
                        '<th class="text-center">Hora</th>' +
                        '<th class="text-center">Profesional</th>' +
                        '<th class="text-center">Sucursal</th>' +
                        '<th class="text-center">Abono</th>' +
                    '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
              '</table>').show();

            var folio = row.data().folio;

            $('#tablaAtenciones_' + row.data().folio + '').DataTable({
              processing: true,
              pageLength: 10,
              searching   : false,
              language: {
                          "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                        },
                        order: [0, "asc"],
              ajax: {
                  url: "{{ url('tratamiento.getTableAtenciones')}}",
                  type: "POST",
                  data:{
                          folio     : folio,
                          "_token" : token,                     
                        },
              },
              columns: [
                      {class : "text-center",
                       data: 'num_atencion'},
                      {class : "text-center",
                       data: 'fecha'},
                      {class : "text-center",
                       data: 'hora'},
                      {class : "text-center",
                       data: 'profesional'},
                      {class : "text-center",
                       data: 'sucursal'},
                      {class : "text-center",
                       data: 'abono'}
                  ],
              colReorder: true,
            });
            tr.addClass('shown');
          }
      } );

    function GuardarValores(){
        var rutExcel                =   rut;
  
        if(rutExcel != ''){
            $('#rutExcel').val(rutExcel);
        }
    }

    </script> 

@endsection