@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.regreserva') }}
@endsection

@section('contentheader_title')
  {{ trans('adminlte_lang::message.regreserva') }}
@endsection

@section('breadcrumb_nivel')  
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.reserva') }}</li>
    <li class="active">{{ trans('adminlte_lang::message.regreserva') }}</li>
@endsection

@section('main-content')
  <div>
    <!-- Este botón sólo aparece si el usuario es secretaria o asistente -->
    <a class="btn btn-default" href="javascript:history.back()" role="button">Volver</a>
  </div>

  <br>
  @if(isset($folio))
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-body">
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  {!! Form::label('n_folio', 'N° folio:', ['for' => 'n_folio'] ) !!}
                  {!! Form::text('n_folio', $folio, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off']  ) !!}
                </div>
                <div class="col-md-6">
                  {!! Form::label('tratamiento', 'Tratamiento:', ['for' => 'tratamiento'] ) !!}
                  {!! Form::text('tratamiento', $tratamiento->nombre, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el nombre de tratamiento', 'maxlength' => '50']  ) !!}
                </div>
                <div class="col-md-2">
                  {!! Form::label('controles', 'Controles:', ['for' => 'controles'] ) !!}
                  {!! Form::text('controles', $tratamiento->num_control , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ) !!}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-body">
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  {!! Form::label('rut_pacienteN', 'RUT del paciente:', ['for' => 'rut_pacienteN'] ) !!}
                  @if(isset($paciente))
                    {!! Form::text('rut_pacienteN', $paciente->rut , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ej: 12345678', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'required', 'autocomplete' => 'off']  ) !!}
                  @else
                    {!! Form::text('rut_pacienteN', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'required', 'autocomplete' => 'off']  ) !!}
                  @endif
              </div>
              <div class="col-md-4">
                  {!! Form::label('nombre_paciente', 'Nombre:', ['for' => 'nombre_paciente'] ) !!}
                  @if(isset($paciente))
                      {!! Form::text('nombre_paciente', $paciente->nombres.' '.$paciente->apellido_paterno.' '.$paciente->apellido_materno, ['class' => 'form-control', 'disabled', 'placeholder' => 'Nombre del paciente', 'maxlength' => '50']  ) !!}
                  @else
                      {!! Form::text('nombre_paciente', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'Nombre del paciente', 'maxlength' => '50']  ) !!}
                  @endif
              </div>
              <div class="col-md-3">
                  {!! Form::label('correo_paciente', 'Correo:', ['for' => 'correo_paciente'] ) !!}
                  @if(isset($paciente))
                      {!! Form::text('correo_paciente', $paciente->email, ['class' => 'form-control', 'disabled', 'placeholder' => 'Correo electrónico del paciente', 'maxlength' => '50']  ) !!}
                  @else
                      {!! Form::text('correo_paciente', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'Correo electrónico del paciente', 'maxlength' => '50']  ) !!}
                  @endif
              </div>
              <div class="col-md-2">
                  {!! Form::label('telefono_paciente', 'Teléfono:', ['for' => 'telefono_paciente'] ) !!}
                  @if(isset($paciente))
                      {!! Form::text('telefono_paciente', $paciente->telefono, ['class' => 'form-control', 'disabled', 'placeholder' => 'Teléfono del paciente', 'maxlength' => '50']  ) !!}
                  @else
                      {!! Form::text('telefono_paciente', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'Teléfono del paciente', 'maxlength' => '50']  ) !!}
                  @endif
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            Nueva atención
          </div>
          <div class="box-body table-responsive" style="height: 150px">
            <div class="box-body">
              <div class="row">
                <div class="form-group col-md-4">
                  {!! Form::label('fecha', 'Fecha:', ['for' => 'fecha'] ) !!}
                  {!! Form::text('fecha', null , ['class' => 'form-control pull-right', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ) !!}
                </div>

                <div class="form-group col-md-4">
                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                      {!! Form::label('hora', 'Hora:', ['for' => 'hora'] ) !!}
                        {!! Form::text('hora', null , ['class' => 'form-control pull-right timepicker', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'HH:MM']  ) !!}
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-4">
                  @if (Auth::user()->perfil_id >= 3)
                    {!! Form::label('sucursal', 'Sucursal:', ['for' => 'sucursal'] ) !!}
                    {!! Form::text('sucursal', $sucursales->nombre, ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingrese sucursal', 'maxlength' => '50']  ) !!}
                  @else
                    {!! Form::label('sucursal', 'Sucursal:', ['for' => 'sucursal'] ) !!}
                    {!! Form::select('sucursal', $sucursales, null, array('class' => 'form-control', 'placeholder' => 'Seleccione sucursal')) !!}
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="div_profesional" class="row hidden">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="box box-info">
            <div class="box-header">
              Detalle
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">                
                  <h4><strong>Datos del Profesional</strong></h4>
                  <div id="mensajeProfesional">

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  {!! Form::label('nombreProfesional', 'Nombre:', ['for' => 'nombreProfesional'] ) !!}
                  <br>
                  {!! Form::select('nombreProfesional', [], null, array('class' => 'form-control profesional_select', 'data-placeholder' => 'Seleccione profesional', 'style' => 'width: 100%' )) !!}
                </div>
                <div class="col-md-3">
                  {!! Form::label('profesion', 'Profesión:', ['for' => 'profesion'] ) !!}
                  {!! Form::text('profesion', '' , ['class' => 'form-control', 'disabled', 'placeholder' => 'Profesión', 'maxlength' => '50']  ) !!}
                </div>
                <div class="col-md-3">
                  {!! Form::label('cargoProfesional', 'Tipo contrato:', ['for' => 'cargoProfesional'] ) !!}
                  {!! Form::text('cargoProfesional', '' , ['class' => 'form-control', 'disabled', 'placeholder' => 'Tipo contrato', 'maxlength' => '50']  ) !!}
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">                
                  <h4>
                    <strong>
                      {!! Form::label('observacion', 'Observaciones:' ) !!}
                    </strong>
                  </h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  {!! Form::textarea('observacion', null, ['rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%']) !!}
                </div>
              </div>
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-md-12">
                  <div id="mensajeAtencion">
                  </div>
                </div>
              </div>
              {!! Form::button('Confirmar', array('id' => 'confirmar', 'class' => 'btn btn-info pull-right')) !!}
            </div>
          </div>
      </div>     
    </div>

@endsection

@section('scripts')
@parent

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token                 =   "{{ csrf_token() }}";

    var tipo_pagos            =   [];
    var total;
    var total_pago;
    var total_restante;
    var pago1Guardado;
    var pago2Guardado;
    var pago3Guardado;
    var pago4Guardado;

    var selectPagos           =   "";

    @if(isset($tipo_pago))
      @foreach($tipo_pago as $pago)
        tipo_pagos.push('{{ $pago->id }}');
        selectPagos           =   selectPagos.concat('<option value="{{ $pago->id }}">{{ $pago->nombre }}</option>');
      @endforeach
    @endif

    $(document).ready(function() {
      @if (Auth::user()->perfil_id >= 3)
        $.ajax({
          type    : 'POST',
          url     : "{{ url('atencion.getProfesionales') }}",
          data    : {
                      sucursal_id : {{ Session()->get('sucursal_id') }},
                      "_token"    : token,
                    },
          dataType: 'json'
        })
        .done(function(data) {
          var profesional_select      =   $('.profesional_select');
          profesional_select.empty().trigger("change");
          $.each(data.profesionales, function(index, val) {
            var option = new Option(val, index, false, false);
            profesional_select.append(option).trigger('change');
          });
          $('#div_profesional').removeClass('hidden');
          profesional_select.val(null).trigger('change');
        })
        .fail(function(data) {
          console.log(data);
        });
      @endif

      $('#sucursal').change(function(event) {

        $.ajax({
          type    : 'POST',
          url     : "{{ url('atencion.getProfesionales') }}",
          data    : {
                      sucursal_id : $(this).val(),
                      "_token"    : token,
                    },
          dataType: 'json'
        })
        .done(function(data) {
          var profesional_select      =   $('.profesional_select');
          profesional_select.empty().trigger("change");
          $.each(data.profesionales, function(index, val) {
            var option = new Option(val, index, false, false);
            profesional_select.append(option).trigger('change');
          });
          $('#div_profesional').removeClass('hidden');
          profesional_select.val(null).trigger('change');
        })
        .fail(function(data) {
          console.log(data);
        });
      });

      //Timepicker
      $('.timepicker').timepicker({
        showInputs: false
      });

      $('#rut_pacienteN').keypress(function(e) {
        if(e.which == 13) {
            if ($(this).val() == '') {
                $('#mensajeCliente').html('');
                $('#mensajeCliente').html('<div class="alert alert-danger fade in"><center><strong>No ha ingresado RUT del paciente</strong></center></div>');
                $('#mensajeCliente').show('fold',5000);
                
            }else{
                $.ajax({
                    url: '{{ url("tratamiento.getPaciente") }}',
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

      $('#fecha').datepicker({
          format: "dd/mm/yyyy",
          language: 'es',
          startDate: '+0d',
          todayHighlight: true,
          autoclose: true
      }); 

      $('.profesional_select').select2();

      $('.profesional_select').on('select2:select', function (e) {
        console.log($(this).val());
        $.ajax({
          type    : 'POST',
          url     : "{{ url('atencion.getDatosProfesional') }}",
          data    : {
                      rut_profesional : $(this).val(),
                      "_token"    : token,
                    },
          dataType: 'json'
        })
        .done(function(data) {
          $('#div_abono').removeClass('hidden');
          $('#profesion').val(data.profesion);
          $('#cargoProfesional').val(data.tipo_contrato);
        })
        .fail(function(data) {
          console.log(data);
        });
      });

      $('#confirmar').click(function(e) {
        var rut_pacienteN       = $('#rut_pacienteN').val();
        var num_atencion        = $('#n_atencion').val();
        var observacion         = $('#observacion').val();
        var fecha               = $('#fecha').val();
        var hora                = $('#hora').val();
        var tratamiento_folio   = $('#n_folio').val();
        var profesional_rut     = $('#nombreProfesional').val();
        @if (Auth::user()->perfil_id >= 3)
          var sucursal_id         = "{{ Session()->get('sucursal_id') }}";
        @else
          var sucursal_id         = $('#sucursal').val();
        @endif
        /*Abono*/
        var abono               = $('#total').val();

        $.ajax({
          url: "{{ url('atencion.guardarAtencion') }}",
          type: 'post',
          dataType: 'json',
          data: {
                  num_atencion        :   num_atencion,
                  observacion         :   observacion,
                  fecha               :   fecha,
                  hora                :   hora,
                  tratamiento_folio   :   tratamiento_folio,
                  paciente_rut        :   rut_pacienteN,
                  profesional_rut     :   profesional_rut,
                  sucursal_id         :   sucursal_id,
                  abono               :   abono,
                  tipo                :   'reserva',
                  "_token"            : token
                },
        })
        .done(function(data) {
          if (data.tipo_mensaje == "error") {
            $('#mensajeAtencion').html('<div class="alert alert-danger">' + data.mensaje +'</div>');
          }else if (data.tipo_mensaje == "success") {
            $('#mensajeAtencion').html('<div class="alert alert-success">' + data.mensaje +'</div>');
            $("#confirmar").attr('disabled', 'disabled');
            $("#mensajeAtencion").animate({
              marginTop:'toggle',
              display:'block'},
              2000, function() {
                window.location.replace("/reserva");
            });
          }
        })
        .fail(function(data) {
          console.log(data);
        });
      });
    });

  </script>

@endsection