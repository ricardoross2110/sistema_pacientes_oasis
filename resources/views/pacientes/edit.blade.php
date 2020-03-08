@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.usarios') }}
@endsection

@section('contentheader_title')
    Editar paciente
@endsection

@section('breadcrumb_nivel')
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.administracion') }}</li>
    <li>{{ trans('adminlte_lang::message.pacientes') }}</li>
    <li class="active">Editar paciente</li>
@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="mensaje"></div>
            <div class="box box-info">

                {!! Form::model($paciente, [ 'route' => ['pacientes.update', $paciente->rut], 'method' => 'PUT']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                {!! Form::label('rut', 'RUT:', ['for' => 'rut'] ) !!}
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        {!! Form::number('rut',null, ['disabled', 'class' => 'form-control', 'placeholder' => '123456789' , 'pattern' => '^[0-9]{7,8}', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8' ]  ) !!}
                                    </div>
                                    <div class="form-group col-md-4">
                                        {!! Form::text('dv', null , ['disabled', 'class' => 'form-control', 'required', 'placeholder' => 'D', 'maxlength' => '1',  'onkeypress' => 'return digitoverificador(event)'] ) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('nombres', 'Nombres:', ['for' => 'nombres'] ) !!}
                                {!! Form::text('nombres', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese los nombres', 'maxlength' => '50' , 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                            </div>  
                            <div class="form-group col-md-4">
                                {!! Form::label('apellido_paterno', 'Apellido paterno:', ['for' => 'apellido_paterno'] ) !!}
                                {!! Form::text('apellido_paterno', null, ['class' => 'form-control','required', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                            </div>  
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                {!! Form::label('apellido_materno', 'Apellido materno:', ['for' => 'apellido_materno'] ) !!}
                                {!! Form::text('apellido_materno', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('email', 'Correo electrónico:', ['for' => 'email'] ) !!}
                                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el correo electrónico', 'maxlength' => '50', 'autocomplete' => 'off']  ) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('telefono', 'Teléfono:', ['for' => 'telefono'] ) !!}
                                {!! Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el número de télefono', 'maxlength' => '12', 'onkeypress' => 'return onlyNumbers(event)' , 'required', 'autocomplete' => 'off' ] ) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                {!! Form::label('direccion', 'Dirección:', ['for' => 'direccion'] ) !!}
                                {!! Form::text('direccion', null , ['class' => 'form-control', 'id' => 'correoN', 'placeholder' => 'Ingrese la direccion', 'maxlength' => '150', 'autocomplete' => 'off']  ) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('fecha_nacimiento', 'Fecha nacimiento:', ['for' => 'fecha_nacimiento'] ) !!}
                                {!! Form::text('fecha_nacimiento', $fecha_nacimiento , ['class' => 'form-control', 'placeholder' => 'Seleccione fecha de nacimiento','autocomplete' => 'off', 'maxlength' => '150', 'required']) !!}
                            </div> 
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                {!! Form::label('facebook', 'Facebook (Opcional):', ['for' => 'facebook'] ) !!}
                                <div class="form-group has-feedback">
                                    {!! Form::text('facebook', null, ['class' => 'form-control', 'maxlength' => '500', 'placeholder' => 'Ingrese link de Facebook', 'autocomplete' => 'off']  ) !!}
                                    <span class="fa fa-facebook-square form-control-feedback"></span>
                                </div>
                            </div>  
                            <div class="form-group col-md-6">
                                {!! Form::label('instagram', 'Instagram (Opcional):', ['for' => 'instagram'] ) !!}
                                <div class="form-group has-feedback">
                                    {!! Form::text('instagram', null, ['class' => 'form-control', 'maxlength' => '500', 'placeholder' => 'Ingrese link de Instagram', 'autocomplete' => 'off']  ) !!}
                                    <span class="fa fa-instagram form-control-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                {!! Form::label('observacion', 'Observación:', ['for' => 'observacionN'] ) !!}
                                {!! Form::textarea('observacion', null, ['class' => 'form-control', 'rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%', 'placeholder' => 'Ingrese una observación', 'autocomplete' => 'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! Form::submit('Guardar', array('class' => 'btn btn-info pull-right')) !!} 
                        <a href="javascript:history.back()" type="button" class="btn btn-default pull-left">Volver</a>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('scripts')
@parent

  <script type="text/javascript">

    $('#fecha_nacimiento').datepicker({
        format: "dd/mm/yyyy",
        language: 'es',
        todayHighlight: true,
        autoclose: true,
    }); 

    var token   = "{{ csrf_token() }}";
    var rut     = $('#rut').val();


  </script>

@endsection
