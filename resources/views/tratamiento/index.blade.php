@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.tratamiento') }}
@endsection

@section('contentheader_title')
  {{ trans('adminlte_lang::message.tratamiento') }}
@endsection

@section('breadcrumb_nivel')  
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.atencion') }}</li>
    <li class="active">{{ trans('adminlte_lang::message.tratamiento') }}</li>
@endsection

@section('main-content')
  <!-- Este botón sólo será visto por Secretaria y Asistente -->
  @if(Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 4)
    <a class="btn btn-default"  href="{{ url('home') }}" role="button">Volver al inicio</a>
  @endif
    @if(Auth::user()->perfil_id <= 3)
      <a class="btn btn-success"  href="{{ url('tratamiento/create') }}" role="button">Agregar nuevo tratamiento</a>
    @endif
    <br>
    <br>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-header with-border">
              <h3 class="box-title">Búsqueda</h3>
          </div>
          {{ Form::open(array('method' => 'GET')) }}
            <div class="box-body">
              <div class="row">
                <div class="form-group col-md-4">
                    {!! Form::label('folioB', 'N° de Folio:' ) !!}
                    {!! Form::text('folioB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off'] ) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('nombre_tratamientoB', 'Nombre del tratamiento:' ) !!}
                    {!! Form::text('nombre_tratamientoB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del tratamiento', 'maxlength' => '50', 'autocomplete' => 'off']  ) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('tipoB', 'Tipo de tratamiento:' ) !!}
                    {!! Form::select('tipoB', $tipo_tratamientos, null, array('class' => 'form-control', 'placeholder' => 'Seleccione el tipo de tratamiento')) !!}
                </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-4">
                      {!! Form::label('rut_pacienteB', 'RUT paciente:' ) !!}
                      {!! Form::text('rut_pacienteB', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'pattern' => '^[0-9]{7,8}', 'maxlength' => '8', 'title' => 'Ingrese RUT sin puntos', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off']  ) !!}
                  </div>
                  <div class="form-group col-md-4">
                      {!! Form::label('apellido_paterno_pacienteB', 'Apellido paterno del paciente:' ) !!}
                      {!! Form::text('apellido_paterno_pacienteB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                  </div>
              </div>
            </div>
            <div class="box-footer">
                {!! Form::reset('Limpiar', array('onClick'=> 'limpiarSelects()', 'class' => 'btn btn-default')) !!}
                {!! Form::submit('Buscar', array('class' => 'btn btn-info')) !!}
            </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="box box-info">
            <div class="box-header">
              Listado de tratamientos
            </div>
            <div class="box-body table-responsive">
              {!! Form::open([ 'route' => 'tratamiento.exportExcel', 'method' => 'POST']) !!}
                  {!! Form::text('folioExcel', null , ['class' => 'hidden', 'id' => 'folioExcel'] ) !!}
                  {!! Form::text('nombreExcel', null , ['class' => 'hidden', 'id' => 'nombreExcel'] ) !!}
                  {!! Form::text('tipoExcel', null , ['class' => 'hidden', 'id' => 'tipoExcel'] ) !!}
                  {!! Form::text('pacienteExcel', null , ['class' => 'hidden', 'id' => 'pacienteExcel'] ) !!}
                  {!! Form::text('rutExcel', null , ['class' => 'hidden', 'id' => 'rutExcel'] ) !!}
                  {!! Form::text('apellidoExcel', null , ['class' => 'hidden', 'id' => 'apellidoExcel'] ) !!}
                  <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                      <span class="fa fa-download"></span>
                  </button>
              {!! Form::close() !!}
              <br>
              <table class="table table-bordered table-striped" id="tableTratamiento">
                <thead>
                    <tr>
                        <th class="text-center">N° folio</th>
                        <th class="text-center">Última atención</th>
                        <th class="text-center">Tratamiento</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Paciente</th>
                        <th class="text-center">Número de atenciones</th>
                        @if(Auth::user()->perfil_id != 4)
                          <th class="text-center">Valor total</th>
                          <th class="text-center">Deuda</th>
                        @endif
                        <th class="text-center">Acciones</th>
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

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token               =  "{{ csrf_token() }}";
    var folio               =  $('#folioB').val();
    var nombre_tratamiento  =  $('#nombre_tratamientoB').val();
    var tipo                =  $('#tipoB').val();
    var rut_paciente        =  $('#rut_pacienteB').val();
    var apellido_paterno    =  $('#apellido_paterno_pacienteB').val();


    function limpiarSelects() {
        $("#folioB").removeAttr('value');
        $("#nombre_tratamientoB").removeAttr('value');
        $("#tipoB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
        $("#rut_pacienteB").removeAttr('value');
        $("#apellido_paterno_pacienteB").removeAttr('value');
    }
    
    function GuardarValores(){
        var folioExcel = $('#folioB').val();
        var nombreExcel = $('#nombre_tratamientoB').val();
        var tipoExcel = $('#tipoB').val();
        var rutExcel = $('#rut_pacienteB').val();
        var apellidoExcel = $('#apellido_paterno_pacienteB').val();
      
        if(folioExcel != ''){
            $('#folioExcel').val(folioExcel);
        }
      
        if(nombreExcel != ''){
            $('#nombreExcel').val(nombreExcel);
        }

        if(tipoExcel != ''){
            $('#tipoExcel').val(tipoExcel);
        }

        if(rutExcel != ''){
            $('#rutExcel').val(rutExcel);
        }

        if(apellidoExcel != ''){
            $('#apellidoExcel').val(apellidoExcel);
        }
    }

    $(document).ready(function() {
        
        $('#fecha_inicio').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true
        });  
        $('#fecha_fin').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true

        }); 

        var tableTratamiento = $('#tableTratamiento').DataTable({
          processing: true,
          pageLength: 10,
          searching   : false,
          language: {
                      "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                    },
          order: [ 0, "asc" ],
          ajax: {
                url: "tratamiento.getTabla",
                type: "POST",
                data:{
                        folio               : folio,
                        nombre_tratamiento  : nombre_tratamiento,
                        tipo                : tipo,
                        rut_paciente        : rut_paciente,
                        apellido_paterno    : apellido_paterno,
                        "_token"  : token,                     
                    },
            },
          columns: [
                    {class : "text-center",
                     data: 'folio'},
                     {class : "text-center",
                     data: 'ultima_fecha'},
                    {class : "text-center",
                     data: 'nombre'},
                    {class : "text-center",
                     data: 'tipo'},
                    {class : "text-center",
                     data: 'paciente'},
                     {class : "text-center",
                     data: 'numero'},                     
                    @if(Auth::user()->perfil_id != 4)
                      {class : "text-center",
                       data: 'valor'},
                     {class : "text-center",
                     data: 'deuda'},
                    @endif
                    {class : "text-center",
                     data: 'action', name: 'action', orderable: false, searchable: false}
                    
                ],
          colReorder: true,
        });

        
      });

  </script>

@endsection