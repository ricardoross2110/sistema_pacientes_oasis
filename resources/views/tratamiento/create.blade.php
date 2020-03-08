@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Registrar tratamiento
@endsection

@section('contentheader_title')
    Registrar tratamiento
@endsection

@section('breadcrumb_nivel')  
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.atencion') }}</li>
    <li class="active">Registrar tratamiento</li>
@endsection

@section('main-content')

    @if(Auth::user()->perfil_id == 3)
        <a class="btn btn-success"  href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#createpaciente"  role="button">Agregar nuevo paciente</a>
        @include('pacientes.create')
        <br>
        <br>
    @endif

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box box-info">
                {!! Form::open([ 'route' => 'tratamiento.store', 'method' => 'POST' ]) !!}
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            {!! Form::label('folioN', 'N° folio:', ['for' => 'folioN'] ) !!}
                            {!! Form::text('folioN', $num_folio , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingrese el número de folio', 'maxlength' => '50']  ) !!}
                        </div>
                        <div class="form-group col-md-3">
                            {!! Form::label('nombreN', 'Tratamiento:', ['for' => 'nombreN'] ) !!}
                            {!! Form::text('nombreN', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre de tratamiento', 'maxlength' => '50', 'required', 'autocomplete' => 'off']  ) !!}
                        </div>              
                        <div class="form-group col-md-3">
                            {!! Form::label('tipo_tratamientoN', 'Tipo de tratamiento:', ['for' => 'tipo_tratamientoN'] ) !!}
                            {!! Form::select('tipo_tratamientoN',  $tipoTratamiento, null, array('class' => 'form-control', 'placeholder' => 'Seleccione tipo de tratamiento', 'required')) !!}
                        </div>
                        <div class="form-group col-md-2">
                            {!! Form::label('num_controlN', 'Número de control:', ['for' => 'num_controlN'] ) !!}
                            {!! Form::number('num_controlN', null , ['class' => 'form-control', 'placeholder' => 'Ingrese número', 'max' => '36', 'onkeypress' => 'return onlyNumbers(event)',  'min' => '1', 'required']  ) !!}
                        </div>
                        <!-- <div class="form-group col-md-2">
                            {!! Form::label('num_controlN', 'Número de control:', ['for' => 'num_controlN'] ) !!}
                            {!! Form::select('num_controlN', array('1' => '1','12' => '12', '18' => '18', '24' => '24','36' => '36'), null , ['class' => 'form-control', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)',  'min' => '1', 'required']  ) !!}
                        </div> -->
                        <div class="form-group col-md-2">
                            {!! Form::label('valorN', 'Valor:', ['for' => 'valorN'] ) !!}
                            {!! Form::number('valorN', null , ['class' => 'form-control', 'placeholder' => 'Ingrese valor', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)', 'min' => '0', 'required']  ) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="mensajeCliente"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {!! Form::label('rut_pacienteN', 'RUT del paciente:', ['for' => 'rut_pacienteN'] ) !!}
                            @if(isset($rut))
                                {!! Form::text('rut_pacienteN', $rut , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'required', 'autocomplete' => 'off']  ) !!}
                            @else
                                {!! Form::text('rut_pacienteN', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'required', 'autocomplete' => 'off']  ) !!}
                            @endif
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('nombre_paciente', 'Nombre:', ['for' => 'nombre_paciente'] ) !!}
                            @if(isset($nombre))
                                {!! Form::text('nombre_paciente', $nombre, ['class' => 'form-control', 'disabled', 'placeholder' => 'Nombre del paciente', 'maxlength' => '50']  ) !!}
                            @else
                                {!! Form::text('nombre_paciente', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'Nombre del paciente', 'maxlength' => '50']  ) !!}
                            @endif
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('correo_paciente', 'Correo:', ['for' => 'correo_paciente'] ) !!}
                            @if(isset($correo))
                                {!! Form::text('correo_paciente', $correo, ['class' => 'form-control', 'disabled', 'placeholder' => 'Correo electrónico del paciente', 'maxlength' => '50']  ) !!}
                            @else
                                {!! Form::text('correo_paciente', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'Correo electrónico del paciente', 'maxlength' => '50']  ) !!}
                            @endif
                        </div>
                        <div class="col-md-2">
                            {!! Form::label('telefono_paciente', 'Teléfono:', ['for' => 'telefono_paciente'] ) !!}
                            @if(isset($telefono))
                                {!! Form::text('telefono_paciente', $telefono, ['class' => 'form-control', 'disabled', 'placeholder' => 'Teléfono del paciente', 'maxlength' => '50']  ) !!}
                            @else
                                {!! Form::text('telefono_paciente', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'Teléfono del paciente', 'maxlength' => '50']  ) !!}
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::label('observacionN', 'Observación:', ['for' => 'observacionN'] ) !!}
                            {!! Form::textarea('observacionN', null, ['class' => 'form-control', 'rows' => 10, 'cols' => 20, 'style' => 'resize:none; width: 100%', 'placeholder' => 'Ingrese una observación', 'maxlength' => '500', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="box-footer">


                    <a href="javascript:history.back()" role="button" class="btn btn-default pull-left">Volver</a>

                    {!! Form::submit('Guardar', array('id' => 'agregar_button', 'class' => 'btn btn-info pull-right')) !!}
                </div>
            </div>
            <div class="modal fade" id="advertenciaTratamiento" tabindex="-1" role="dialog" aria-labelledby="advertenciaTratamientoLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-yellow">
                            <h2 class="modal-title" id="advertenciaTratamientoLabel"><center>Atención</center></h2>
                        </div>
                        <div class="modal-body">
                            <h3><center>Al seleccionar la opción General Ortodoncia se crearán dos folios</center></h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Aceptar</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>     
    </div>
@endsection

@section('scripts')
@parent

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    $('#fecha_nacimiento').datepicker({
        format: "dd/mm/yyyy",
        language: 'es',
        todayHighlight: true,
        autoclose: true,
    }); 
    var token                =  "{{ csrf_token() }}";
    var rut_pacienteN        =  $('#rut_pacienteN').val();
    var tipo_tratamientoN    =  $('#tipo_tratamientoN').val();
    $(document).ready(function() {
        $('#fecha_nacimientoN').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true,
          });

      $('#rut_pacienteN').keypress(function(e) {
        if(e.which == 13) {
            if ($(this).val() == '') {
                $('#mensajeCliente').html('');
                $('#mensajeCliente').html('<div class="alert alert-danger fade in"><center><strong>No ha ingresado RUT del paciente</strong></center></div>');
                $('#mensajeCliente').show('fold',5000);
                
            }else{
                $.ajax({
                    url: '{{ url('tratamiento.getPaciente') }}',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        rut_pacienteN : $(this).val(),
                        "_token"      : token,
                    },
                    
                })
                .done(function(data) {
                    console.log(data);
                    $('#nombre_paciente').val(data.pacientes[0].nombre_paciente);
                    $('#correo_paciente').val(data.pacientes[0].email);
                    $('#telefono_paciente').val(data.pacientes[0].telefono);
                })
                .fail(function(data) {
                    console.log(data);
                });
            }
        }
      });

      $('#tipo_tratamientoN').change(function(e) {
          var tipo_tratamiento = $(this).val();
          if(tipo_tratamiento == '1'){
            $('#num_controlN').val(1);
            $('#num_controlN').attr('disabled', true);
            $('#num_controlN').attr('max', 1);
          }else if(tipo_tratamiento == '2'){
            $('#num_controlN').val(1);
            $('#num_controlN').attr('disabled', false);
            $('#num_controlN').attr('max', 2);
          }else{
            $('#num_controlN').val(1);
            $('#num_controlN').attr('disabled', false);
            $('#num_controlN').attr('max', 36);
          }
          
          /*if(tipo_tratamiento == '2'){
            $('#advertenciaTratamiento').modal('show'); 
          }*/
      });
    });
  </script>

@endsection