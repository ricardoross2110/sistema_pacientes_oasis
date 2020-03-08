@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.reserva') }}
@endsection

@section('contentheader_title')
  {{ trans('adminlte_lang::message.reserva') }}
@endsection

@section('breadcrumb_nivel')  
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li class="active">{{ trans('adminlte_lang::message.reserva') }}</li>
@endsection

@section('main-content')
  <!-- Este botón sólo será visto por Secretaria y Asistente -->
  @if(Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 4)
    <a class="btn btn-default"  href="{{ url('home') }}" role="button">Volver al inicio</a>
  @endif
    
    <a class="btn btn-success"  href="{{ url('/RegistrarReserva/') }}" role="button">Agregar reserva</a>
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
                    {!! Form::label('rut_pacienteB', 'RUT paciente:' ) !!}
                    {!! Form::text('rut_pacienteB', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'pattern' => '^[0-9]{7,8}', 'maxlength' => '8', 'title' => 'Ingrese RUT sin puntos', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off']  ) !!}
                  </div>
                  <div class="form-group col-md-4">
                    {!! Form::label('apellido_paterno_pacienteB', 'Apellido paterno del paciente:' ) !!}
                    {!! Form::text('apellido_paterno_pacienteB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                  </div>
                  @if (Auth::user()->perfil_id <= 2)
                    <div class="form-group col-md-2">
                      {!! Form::label('fechaB', 'Fecha:' ) !!}
                      {!! Form::text('fechaB', null, ['class' => 'form-control pull-right', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ) !!}
                    </div>
                    <div class="form-group col-md-2">
                      {!! Form::label('sucursalB', 'Sucursal:' ) !!}
                      {!! Form::select('sucursalB', $sucursal, null, array('class' => 'form-control', 'placeholder' => 'Seleccione sucursal')) !!}
                    </div>
                  @else
                    <div class="form-group col-md-4">
                      {!! Form::label('fechaB', 'Fecha:' ) !!}
                      {!! Form::text('fechaB', null, ['class' => 'form-control pull-right', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ) !!}
                    </div>
                  @endif
              </div>
              <div class="row">
                <div class="form-group col-md-3">
                  {!! Form::label('rut_profesionalB', 'Rut Profesional:', ['for' => 'rut_profesionalB'] ) !!}
                  {!! Form::text('rut_profesionalB', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678' , 'pattern' => '^[0-9]{7,8}', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'autocomplete' => 'off']  ) !!}
                </div>
                <div class="form-group col-md-3">
                  {!! Form::label('nombres_profesionalB', 'Nombre profesional:', ['for' => 'nombres_profesionalB'] ) !!}
                  {!! Form::text('nombres_profesionalB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese nombres del profesional', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                </div>
                <div class="form-group col-md-3">
                  {!! Form::label('apellido_paterno_profesionalB', 'Apellido paterno profesional:', ['for' => 'apellido_paterno_profesionalB'] ) !!}
                  {!! Form::text('apellido_paterno_profesionalB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                </div>
                <div class="form-group col-md-3">
                  {!! Form::label('apellido_materno_profesionalB', 'Apellido materno profesional:', ['for' => 'apellido_materno_profesionalB'] ) !!}
                  {!! Form::text('apellido_materno_profesionalB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
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
      <div class="col-md-6">
         <div class="box box-info">
          <div class="box-header text-center">
            <h3 class="box-title">Calendario</h3>
            <br>
          </div>
          <div class="box-body no-padding">
            <div class="row text-center">
              @if(Auth::user()->perfil_id <= 2)
                @foreach($sucursales As $s)
                  <div class="col-md-3">
                    <span class="fa fa-circle" style="color: {{ $s->color }}"></span> <label>{{ $s->nombre }}</label> 
                  </div>
                @endforeach
              @endif
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                {!! $calendar->calendar() !!}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <div class="box box-info">
          <div class="box-header text-center">
            <h3 class="box-title">Listado de reservas</h3>
            <br>
          </div>
          <div class="box-body table-responsive">
            {!! Form::open([ 'route' => 'reservas.exportExcel', 'method' => 'POST']) !!}
              {!! Form::text('rut_pacienteE', null , ['class' => 'hidden', 'id' => 'rut_pacienteE'] ) !!}
              {!! Form::text('apellido_paternoE', null , ['class' => 'hidden', 'id' => 'apellido_paternoE'] ) !!}
              {!! Form::text('rut_profesionalE', null , ['class' => 'hidden', 'id' => 'rut_profesionalE'] ) !!}
              {!! Form::text('nombres_profesionalE', null , ['class' => 'hidden', 'id' => 'nombres_profesionalE'] ) !!}
              {!! Form::text('apellido_materno_profesionalE', null , ['class' => 'hidden', 'id' => 'apellido_materno_profesionalE'] ) !!}
              {!! Form::text('apellido_paterno_profesionalE', null , ['class' => 'hidden', 'id' => 'apellido_paterno_profesionalE'] ) !!}
              {!! Form::text('fechaE', null , ['class' => 'hidden', 'id' => 'fechaE'] ) !!}
              @if (Auth::user()->perfil_id <= 2)
                {!! Form::text('sucursalE', null , ['class' => 'hidden', 'id' => 'sucursalE'] ) !!}
              @endif
              <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                  <span class="fa fa-download"></span>
              </button>
            {!! Form::close() !!}
            <br>
            <table class="table table-bordered table-striped" id="tableTratamiento">
              <thead>
                <tr>
                  <th class="text-center">Rut Paciente</th>
                  <th class="text-center">Paciente</th>
                  <th class="text-center">Fecha</th>
                  <th class="text-center">Hora</th>       
                  <th class="text-center">Rut Profesional</th>
                  <th class="text-center">Profesional</th>
                  <th class="text-center">Sucursal</th>        
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

  {!! $calendar->script() !!}

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token               =  "{{ csrf_token() }}";
    var paciente_rut        =  $('#rut_pacienteB').val();
    var apellido_paterno    =  $('#apellido_paterno_pacienteB').val();
    var fecha               =  $('#fechaB').val();

    @if (Auth::user()->perfil_id <= 2)
     var sucursal_id         =  $('#sucursalB').val();
    @endif

    var profesional_rut     =  $('#rut_profesionalB').val();
    var apellido_paternop   =  $('#apellido_paterno_profesionalB').val();

    function limpiarSelects() {
      $("#folioB").removeAttr('value');
      $("#nombre_tratamientoB").removeAttr('value');
      $("#tipoB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
      $("#rut_pacienteB").removeAttr('value');
      $("#apellido_paterno_pacienteB").removeAttr('value');
    }
    
    function GuardarValores(){
      var rut_pacienteE      =  $('#rut_pacienteB').val();
      var apellido_paternoE  =  $('#apellido_paterno_pacienteB').val();
      var rut_profesionalE   =  $('#rut_profesionalB').val();
      var nombrespE          =  $('#nombres_profesionalB').val();
      var apellido_paternopE =  $('#apellido_paterno_profesionalB').val();
      var apellido_maternopE =  $('#apellido_materno_profesionalB').val();
      var fechaE             =  $('#fechaB').val();
      
      if(rut_pacienteE != ''){
        $('#rut_pacienteE').val(rut_pacienteE);
      }
    
      if(apellido_paternoE != ''){
        $('#apellido_paternoE').val(apellido_paternoE);
      }

      if(rut_profesionalE != ''){
        $('#rut_profesionalE').val(rut_profesionalE);
      }
    
      if(nombrespE != ''){
        $('#nombres_profesionalE').val(nombrespE);
      }
    
      if(apellido_paternopE != ''){
        $('#apellido_paterno_profesionalE').val(apellido_paternopE);
      }
    
      if(apellido_maternopE != ''){
        $('#apellido_materno_profesionalE').val(apellido_maternopE);
      }

      @if (Auth::user()->perfil_id <= 2)
      
      var sucursalE          =  $('#sucursalB').val();
      
      if(sucursalE != ''){
        $('#sucursalE').val(sucursalE);
      }
      
      @endif

      if(fechaE != ''){
        $('#fechaE').val(fechaE);
      }
    }

    $(document).ready(function() {

        $('#fechaB').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true
        });  

        var tableTratamiento = $('#tableTratamiento').DataTable({
          "searching": false,
          processing: true,
          pageLength: 10,
          language: {
                      "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                    },
          order: [ 2, "asc" ],
          ajax: {
                url: "reserva.getTableReservas",
                type: "POST",
                data:{
                        paciente_rut      : paciente_rut,
                        apellido_paterno  : apellido_paterno,
                        profesional_rut   : profesional_rut,
                        apellido_paternop : apellido_paternop,
                        fecha             : fecha,
                        @if (Auth::user()->perfil_id <= 2)
                          sucursal_id       : sucursal_id,
                        @endif
                        "_token"          : token,                     
                    },
            },
          columns: [
                    {class : "text-center",
                     data: 'paciente_rut'},
                     {class : "text-center",
                     data: 'paciente'},
                    {class : "text-center",
                     data: 'fecha'},
                    {class : "text-center",
                     data: 'hora'},
                    {class : "text-center",
                     data: 'profesional_rut'},
                    {class : "text-center",
                     data: 'profesional'},
                    {class : "text-center",
                     data: 'sucursal'},
                    {class : "text-center",
                     data: 'action', name: 'action', orderable: false, searchable: false}
                    
                ],
          colReorder: true,
        });

        
      });

  </script>

@endsection