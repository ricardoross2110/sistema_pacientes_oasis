@extends('adminlte::layouts.app')

@section('htmlheader_title')
  {{ trans('adminlte_lang::message.regobservaciones') }}
@endsection

@section('contentheader_title')
  {{ trans('adminlte_lang::message.regobservaciones') }}
@endsection

@section('breadcrumb_nivel')  
  <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
  <li>{{ trans('adminlte_lang::message.atencion') }}</li>
  <li class="active">{{ trans('adminlte_lang::message.observaciones') }}</li>
@endsection

@section('main-content')

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        {!! Form::open(['route'=>'observacion.store', 'method' => 'POST' ]) !!}
        <div class="box-header">
          <h3><strong>Detalle atención</strong></h3>
        </div>
        <div class="box-body">
          <div class="row">
            {!! Form::text('atencion_id', $atenciones->id, ['class' => 'hidden']  ) !!}
            {!! Form::text('num_folio', $atenciones->tratamiento_folio, ['class' => 'hidden']  ) !!}
            <div class="col-md-2">
              {!! Form::label('n_folio', 'N° folio:', ['for' => 'n_folio'] ) !!}
              {!! Form::text('n_folio', $atenciones->tratamiento_folio, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
            </div>
            <div class="col-md-2">
              {!! Form::label('n_atencion', 'N° atención:' ) !!}
              {!! Form::text('n_atencion', $atenciones->num_atencion, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
            </div>
            <div class="col-md-3">
              {!! Form::label('paciente', 'Paciente:', ['for' => 'paciente'] ) !!}
              {!! Form::text('paciente', $atenciones->paciente, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre paciente', 'maxlength' => '50']  ) !!}
            </div>
            <div class="col-md-3">
              {!! Form::label('nombreProfesional', 'Profesional:', ['for' => 'nombreProfesional'] ) !!}
              {!! Form::text('nombreProfesional', $atenciones->profesional, ['class' => 'form-control', 'disabled','placeholder' => 'Seleccione profesional']) !!}
            </div>
            <div class="col-md-2">
              {!! Form::label('controles', 'Sucursal:', ['for' => 'controles'] ) !!}
              {!! Form::text('controles', $atenciones->sucursal , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ) !!}
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">                
              {!! Form::label('texto_observacion', 'Observaciones:' ) !!}
              {!! Form::textarea('texto_observacion', null, ['rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%', 'placeholder' => 'Ingrese una observación','maxlength' => '500']) !!}
            </div>
          </div>
        </div>
        <div class="box-footer text-center">
          <a href="javascript:history.back()" role="button" class="btn btn-default pull-left">Volver</a>
          <!--Se utiliza para registrar una observación para el asistente y secretaria -->
          {!! Form::button('Imprimir', array('onclick' => 'window.print();', 'name' => 'imprimir', 'class' => 'btn btn-info')) !!}
          {!! Form::submit('Guardar', array('class' => 'btn btn-info pull-right')) !!}
        </div>
        {!! Form::close() !!}
      </div>
    </div>     
  </div>


@endsection

@section('scripts')
@parent

  <script type="text/javascript">
    var token                =  "{{ csrf_token() }}";

    $(document).ready(function() {

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