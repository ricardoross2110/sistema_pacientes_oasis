@extends('adminlte::layouts.app')

@section('htmlheader_title')
  Detalle atención
@endsection

@section('contentheader_title')
  Detalle atención
@endsection

@section('breadcrumb_nivel')  
  <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
  <li>{{ trans('adminlte_lang::message.atencion') }}</li>
  <li class="active">Detalle atención</li>
@endsection

@section('main-content')
 
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-body table-responsive">
          <div class="box-body">
            <div class="row">
              <div class="col-md-2">
                {!! Form::label('n_folio', 'N° folio:', ['for' => 'n_folio'] ) !!}
                {!! Form::text('n_folio', $atenciones->tratamiento_folio, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
              </div>
              <div class="col-md-4">
                {!! Form::label('tratamiento', 'Tratamiento:', ['for' => 'tratamiento'] ) !!}
                {!! Form::text('tratamiento', $atenciones->nombre, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el nombre de tratamiento', 'maxlength' => '50']  ) !!}
              </div>
              <div class="col-md-4">
                {!! Form::label('paciente', 'Nombre paciente:', ['for' => 'paciente'] ) !!}
                {!! Form::text('paciente', $atenciones->paciente, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre paciente', 'maxlength' => '50']  ) !!}
              </div>
              <div class="col-md-2">
                {!! Form::label('controles', 'Controles:', ['for' => 'controles'] ) !!}
                {!! Form::text('controles', $atenciones->control , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ) !!}
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
        <div class="box-body table-responsive">
          <div class="box-body">
            <div class="row">
              <div class="col-md-2">
                {!! Form::label('n_folio', 'N° atención:', ['for' => 'n_folio'] ) !!}
                {!! Form::text('n_folio', $atenciones->num_atencion, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
              </div>
              <div class="col-md-2">
                {!! Form::label('tratamiento', 'Fecha:', ['for' => 'tratamiento'] ) !!}
                {!! Form::text('tratamiento', $atenciones->fecha, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el nombre de tratamiento', 'maxlength' => '50']  ) !!}
              </div>
              <div class="col-md-2">
                {!! Form::label('paciente', 'Hora:', ['for' => 'paciente'] ) !!}
                {!! Form::text('paciente', $atenciones->hora, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre paciente', 'maxlength' => '50']  ) !!}
              </div>
              <div class="col-md-6">
                {!! Form::label('controles', 'Sucursal:', ['for' => 'controles'] ) !!}
                {!! Form::text('controles', $atenciones->sucursal , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ) !!}
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
              {!! Form::text('nombreProfesional', $atenciones->profesional, ['class' => 'form-control', 'disabled','placeholder' => 'Seleccione profesional']) !!}
            </div>
            <div class="col-md-3">
              {!! Form::label('profesion', 'Profesión:', ['for' => 'profesion'] ) !!}
              {!! Form::text('profesion', $atenciones->profesion , ['class' => 'form-control', 'disabled', 'placeholder' => 'Profesión', 'maxlength' => '50']  ) !!}
            </div>
            <div class="col-md-3">
              {!! Form::label('cargoProfesional', 'Tipo contrato:', ['for' => 'cargoProfesional'] ) !!}
              {!! Form::text('cargoProfesional', $atenciones->tipo , ['class' => 'form-control', 'disabled', 'placeholder' => 'Tipo contrato', 'maxlength' => '50']  ) !!}
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">                
              <h4>
                <strong>
                  {!! Form::label('observacionB', 'Observaciones:', ['for' => 'observacionB'] ) !!}
                </strong>
              </h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              {!! Form::textarea('observacion', $atenciones->observacion, ['rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%', 'placeholder' => '', 'disabled']) !!}
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
          <h3><strong>Observaciones registradas</strong></h3>
        </div>
        <div class="box-body">
          @foreach($observaciones As $observacion)
            <div class="row">
              <div class="col-md-6">
                  {!! Form::label('fechaob-{{ $observacion->id }}', 'Fecha:' ) !!}
                  {!! Form::text('fechaob-{{ $observacion->id }}', $observacion->fecha , ['class' => 'form-control', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ) !!}
              </div>
              <div class="col-md-6">                
                  {!! Form::label('horaob-{{ $observacion->id }}', 'Hora:' ) !!}
                  {!! Form::text('horaob-{{ $observacion->id }}', $observacion->hora , ['class' => 'form-control', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ) !!}
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                {!! Form::textarea('observacion-', $observacion->observacion, ['rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%', 'placeholder' => '', 'disabled']) !!}
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>     
  </div>

  @if(Auth::user()->perfil_id <= 3)
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3><strong>Detalle pago</strong></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">                  
              <div class="row">
                <div class="col-md-3 col-md-offset-3">
                  <strong class="pull-right">Total:</strong>
                </div>
                <div class="col-md-3">         
                  {!! Form::text('total', $atenciones->abono , ['class' => 'form-control', 'disabled']  ) !!}         
                  <br>
                </div>
              </div>
              @if(!is_null($pagos))
                <div class="row">
                  <div class="col-md-3 col-md-offset-3">
                    <strong class="pull-right">Formas de pago:</strong>
                  </div>
                </div>
                @foreach($pagos as $pago)
                  <br>                            
                  <div class="row">
                    <div class="col-md-offset-3 col-md-3">
                     {!! Form::text('cargoProfesional', $pago->nombre , ['class' => 'form-control', 'disabled', 'placeholder' => 'Tipo contrato', 'maxlength' => '50']  ) !!}
                    </div>
                    <div class="col-md-3">
                      {!! Form::text('total1', $pago->monto , ['class' => 'form-control',  'id' => 'total1','disabled', 'placeholder' => 'Ingrese Total']  ) !!}
                    </div>
                  </div>
                @endforeach
              @endif  
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="javascript:history.back()" role="button" class="btn btn-default pull-left">Volver</a>
        </div>
      </div>
    </div>     
  </div>
  @else
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-footer">
          {!! Form::button('Imprimir', array('onclick' => 'window.print();', 'name' => 'imprimir', 'class' => 'btn btn-info pull-right')) !!}
          <a href="javascript:history.back()" role="button" class="btn btn-default pull-left">Volver</a>
        </div>
      </div>
    </div>     
  </div>
  @endif


@endsection

@section('scripts')
@parent

  <script type="text/javascript">
    var token                =  "{{ csrf_token() }}";

    $(document).ready(function() {
      $('#rut_paciente').keypress(function(e) {
        if(e.which == 13) {
          if ($(this).val() == '11111111') {
            $('#nombreB').val('Paciente Prueba Uno');
          }else{
            $('#mensajeCliente').html('');
            $('#mensajeCliente').html('<div class="alert alert-danger fade in"><strong>No se encuentra el paciente</strong>, el rut ingresado no corresponde a ningún paciente de nuestra base de datos.</div>');
            $(this).val('');
            $('#nombreB').val('');
          }
        }
      });

      $('#rut_profesional').keypress(function(e) {
        if(e.which == 13) {
          if ($(this).val() == '11111111') {
            $('#nombreProfesionalB').val('Profesional Prueba Uno');
            $('#cargoProfesionalB').val('Cargo');
            $('#profesionB').val('Profesión 1');
            $('#mensajePago').html('');
          }else{
            $('#mensajeProfesional').html('');
            $('#mensajeProfesional').html('<div class="alert alert-danger fade in"><strong>No se encuentra el profesional</strong>, el rut ingresado no corresponde a ningún profesional de nuestra base de datos.</div>');
            $(this).val('');
            $('#nombreProfesionalB').val('');
            $('#cargoProfesionalB').val('');
            $('#profesionB').val('');
          }
        }
      });

      $('#confirmarPago').click(function(event) {
        if ($('#total').val() != '') {
          $('#divPago').removeClass('hidden');
          $('#total1').val($('#total').val());
          $('#mensajePago').html('');
        }else{
          $('#mensajePago').html('');
          $('#mensajePago').html('<div class="alert alert-danger fade in"><strong>El monto está en blanco</strong>, Ingrese un monto para confirmar.</div>');
        }
      });
    });

  </script>

@endsection