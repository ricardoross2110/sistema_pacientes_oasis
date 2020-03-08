@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.usarios') }}
@endsection

@section('contentheader_title')
    Editar profesional
@endsection

@section('breadcrumb_nivel')
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.administracion') }}</li>
    <li>{{ trans('adminlte_lang::message.pacientes') }}</li>
    <li class="active">Editar profesional</li>
@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="mensaje"></div>
            <div class="box box-info">
                {!! Form::model($profesional, [ 'route' => ['profesionales.update', $profesional->rut], 'method' => 'PUT']) !!}
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('rut', 'RUT:', ['for' => 'rut'] ) !!}
                            <div class="row">
                                <div class="form-group col-md-8">
                                    {!! Form::number('rut', null , ['disabled', 'class' => 'form-control', 'id' => 'rut', 'placeholder' => '12345678' , 'pattern' => '^[0-9]{7,8}']  ) !!}
                                </div>
                                <div class="form-group col-md-4">
                                    {!! Form::text('dv', null , ['disabled', 'class' => 'form-control', 'id' => 'dv', 'required', 'placeholder' => 'D', 'maxlength' => '1'] ) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-8">
                            {!! Form::label('nombre', 'Nombres:', ['for' => 'nombre'] ) !!}
                            {!! Form::text('nombres', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese los nombres', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                        </div>  
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('apellido_paterno', 'Apellido paterno:', ['for' => 'apellido_paterno'] ) !!}
                            {!! Form::text('apellido_paterno', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)', 'required']  ) !!}
                        </div>  
                        <div class="form-group col-md-4">
                            {!! Form::label('apellido_materno', 'Apellido materno:', ['for' => 'apellido_materno'] ) !!}
                            {!! Form::text('apellido_materno', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)', 'required']  ) !!}
                        </div>  
                        <div class="form-group col-md-4">
                            {!! Form::label('email', 'Correo electrónico:', ['for' => 'email'] ) !!}
                            {!! Form::text('email', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el correo electrónico', 'maxlength' => '50', 'autocomplete' => 'off', 'required']  ) !!}
                        </div>
                    </div>
                    <div class = "row">
                        <div class="form-group col-md-4">
                            {!! Form::label('direccion', 'Dirección:', ['for' => 'direccion'] ) !!}
                            {!! Form::text('direccion', null , ['class' => 'form-control', 'id' => 'direccion', 'placeholder' => 'Ingrese la dirección', 'maxlength' => '50', 'autocomplete' => 'off', 'required']  ) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('telefono', 'Teléfono:', ['for' => 'telefonoN'] ) !!}
                            {!! Form::text('telefono', null, ['class' => 'form-control', 'id' => 'telefono', 'placeholder' => 'Ingrese el número de teléfono', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'required']  ) !!}
                        </div> 
                        <div class="form-group col-md-4">
                            {!! Form::label('sucursal', 'Sucursal:', ['for' => 'sucursal'] ) !!}
                            <br>
                            {!! Form::select('sucursal[]', $sucursales, null, array('class' => 'form-control sucursal', 'data-placeholder' => 'Seleccione sucursal', 'multiple', 'style' => 'width: 100%', 'required')) !!}
                        </div> 
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('profesion_id', 'Profesión:', ['for' => 'profesion_id'] ) !!}
                            {!! Form::select('profesion_id', $profesiones, null, array('class' => 'form-control', 'placeholder' => 'Seleccione profesión')) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('tipo_contrato_id', 'Tipo de contrato:', ['for' => 'tipo_contrato_id'] ) !!}
                            {!! Form::select('tipo_contrato_id', $tipoContrato, null, array('class' => 'form-control', 'placeholder' => 'Seleccione tipo de contrato')) !!}
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
                    <a href="javascript:history.back()" type="button" class="btn btn-default pull-left ">Volver</a>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('scripts')
@parent

  <script type="text/javascript">

        var token               = "{{ csrf_token() }}";
        var sucursal          = [];

        $('.sucursal').select2();

        @if(isset($sucursalesProfesional))
          @foreach ($sucursalesProfesional as $sucursal_p)
                sucursal.push({{ $sucursal_p->sucursal_id }});
          @endforeach
        @endif

        console.log(sucursal);

        function cargarSelects() {
            cargarSelectSucursal();
        }

        function cargarSelectSucursal() {
            var sucursal_select      =   $('.sucursal');
            sucursal_select.empty().trigger("change");
            $.ajax({
                type    : 'POST',
                url     : "{{ url('sucursal.cargarSucursales') }}",
                data    : {
                            "_token"   : token,
                          },
                dataType: 'json'
            })
            .done(function(data) {
                $.each(data.sucursales, function(index, val) {
                    console.log(sucursal);
                    console.log(index);
                    console.log(val);
                    console.log(sucursal.includes(val));
                    if (sucursal.includes(val) === true) {
                        var option = new Option(index, val, true, true);
                    }else{
                        var option = new Option(index, val, false, false);
                    }
                    sucursal_select.append(option).trigger('change');
                });
            })
            .fail(function() {
                console.log("error");
            });
        }

        $(document).ready(function() {
            cargarSelects();
        });
  </script>

@endsection
