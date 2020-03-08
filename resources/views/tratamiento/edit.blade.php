@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Editar tratamiento
@endsection

@section('contentheader_title')
    Editar tratamiento
@endsection

@section('breadcrumb_nivel')  
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.atencion') }}</li>
    <li class="active">{{ trans('adminlte_lang::message.tratamiento') }}</li>
@endsection

@section('main-content')
    @if($tratamiento->tipo_tratamiento_id == 3)
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-info">
                    {!! Form::model($tratamiento, [ 'route' => ['tratamiento.update', $tratamiento->folio], 'method' => 'PUT']) !!}
                    <div class="box-body table-responsive">
                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label('folio', 'Número de folio:', ['for' => 'folio'] ) !!}
                                {!! Form::text('folio', null , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el número de folio', 'maxlength' => '50']  ) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('nombre', 'Nombre del tratamiento:', ['for' => 'nombre'] ) !!}
                                {!! Form::text('nombre', $tratamiento->nombre , ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre de tratamiento', 'maxlength' => '50', 'disabled', 'autocomplete' => 'off']  ) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('num_control', 'Número de control:', ['for' => 'num_control'] ) !!}
                                {!! Form::number('num_control', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el número de control', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)',  'min' => '0', 'disabled']  ) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('valor', 'Valor:', ['for' => 'valor'] ) !!}
                                {!! Form::number('valor', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el valor', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)', 'min' => '0', 'disabled']  ) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('tipo_tratamiento_id', 'Tipo de tratamiento:', ['for' => 'tipo_tratamiento_id'] ) !!}
                                {!! Form::text('tipo_tratamiento_id', 'General' , ['class' => 'form-control',  'min' => '0', 'disabled']  ) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="mensajeCliente"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('rut_paciente', 'RUT:', ['for' => 'rut_paciente'] ) !!}
                                {!! Form::text('rut_paciente', $tratamiento->rut.'-'.$tratamiento->dv , ['class' => 'form-control', 'placeholder' => 'Ingrese RUT de paciente', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'disabled']  ) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::label('nombre_paciente', 'Nombre:', ['for' => 'nombre_paciente'] ) !!}
                                {!! Form::text('nombre_paciente', $tratamiento->nombres.' '.$tratamiento->apellido_paterno.' '.$tratamiento->apellido_materno, ['class' => 'form-control', 'disabled', 'placeholder' => 'Nombre del paciente', 'maxlength' => '50']  ) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('correo_paciente', 'Correo electrónico:', ['for' => 'correo_paciente'] ) !!}
                                {!! Form::text('correo_paciente', $tratamiento->email, ['class' => 'form-control', 'disabled', 'placeholder' => 'Correo electrónico del paciente', 'maxlength' => '50']  ) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('telefono_paciente', 'Teléfono:', ['for' => 'telefono_paciente'] ) !!}
                                {!! Form::text('telefono_paciente', $tratamiento->telefono, ['class' => 'form-control', 'disabled', 'placeholder' => 'Teléfono del paciente', 'maxlength' => '50']  ) !!}
                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="box-footer">
                      <a href="{{ url('/tratamiento') }}" role="button" class="btn btn-default pull-left">Volver</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>     
        </div>
    @else
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-info">
                    {!! Form::model($tratamiento, [ 'route' => ['tratamiento.update', $tratamiento->folio], 'method' => 'PUT']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                {!! Form::label('folio', 'Número de folio:', ['for' => 'folio'] ) !!}
                                {!! Form::text('folio', null , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el número de folio', 'maxlength' => '50']  ) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('nombre', 'Nombre del tratamiento:', ['for' => 'nombre'] ) !!}
                                {!! Form::text('nombre',  $tratamiento->nombre , ['class' => 'form-control', 'placeholder' => 'Escribe el nombre de tratamiento', 'maxlength' => '50', 'autocomplete' => 'off','required']  ) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('num_control', 'Número de control:', ['for' => 'num_control'] ) !!}
                                {!! Form::number('num_control', $tratamiento->num_control , ['class' => 'form-control', 'placeholder' => 'Escribe el número de control', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)',  'min' => '0','required']  ) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('valor', 'Valor:', ['for' => 'valor'] ) !!}
                                {!! Form::number('valor', null , ['class' => 'form-control', 'placeholder' => 'Escribe el valor', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)', 'min' => '0', 'required']  ) !!}
                            </div>
                            <div class="form-group col-md-2">
                                {!! Form::label('tipo_tratamiento_id', 'Tipo de tratamiento:', ['for' => 'tipo_tratamiento_id'] ) !!}
                                {!! Form::text('tipo_tratamiento_id', $tratamiento->tipo , ['class' => 'form-control',  'min' => '0', 'disabled']  ) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="mensajeCliente"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                {!! Form::label('rut_paciente', 'RUT:', ['for' => 'rut_paciente'] ) !!}
                                {!! Form::text('rut_paciente', $tratamiento->rut.'-'.$tratamiento->dv , ['class' => 'form-control', 'placeholder' => 'Escribe RUT de paciente', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'disabled']  ) !!}
                            </div>
                            <div class="col-md-4">
                                {!! Form::label('nombre_paciente', 'Nombre:', ['for' => 'nombre_paciente'] ) !!}
                                {!! Form::text('nombre_paciente', $tratamiento->nombres.' '.$tratamiento->apellido_paterno.' '.$tratamiento->apellido_materno, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre del paciente', 'maxlength' => '50']  ) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('correo_paciente', 'Correo electrónico:', ['for' => 'correo_paciente'] ) !!}
                                {!! Form::text('correo_paciente', $tratamiento->email, ['class' => 'form-control', 'disabled', 'placeholder' => 'Correo del paciente', 'maxlength' => '50']  ) !!}
                            </div>
                            <div class="col-md-2">
                                {!! Form::label('telefono_paciente', 'Teléfono:', ['for' => 'telefono_paciente'] ) !!}
                                {!! Form::text('telefono_paciente', $tratamiento->telefono, ['class' => 'form-control', 'disabled', 'placeholder' => 'Teléfono del paciente', 'maxlength' => '50']  ) !!}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::label('observacion', 'Observación:', ['for' => 'observacion'] ) !!}
                                {!! Form::textarea('observacion', $tratamiento->observacion, ['class' => 'form-control', 'rows' => 10, 'cols' => 20, 'style' => 'resize:none; width: 100%', 'placeholder' => 'Escribe una observación', 'maxlength' => '500', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                      <a href="{{ url('/tratamiento') }}" role="button" class="btn btn-default">Volver</a>
                        {!! Form::submit('Guardar', array('id' => 'agregar_button', 'class' => 'btn btn-info pull-right')) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>     
        </div>
    @endif
@endsection

@section('scripts')
@parent

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token                =  "{{ csrf_token() }}";
    var rut_pacienteN        =  $('#rut_pacienteN').val();
  </script>

@endsection