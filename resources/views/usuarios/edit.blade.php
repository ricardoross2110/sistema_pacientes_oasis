@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.usarios') }}
@endsection

@section('contentheader_title')
    Editar usuario
@endsection

@section('breadcrumb_nivel')
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.administracion') }}</li>
    <li>{{ trans('adminlte_lang::message.usuarios') }}</li>
    <li class="active">Editar usaurio</li>
@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="mensaje"></div>
            <div class="box box-info">

                {!! Form::model($usuario, [ 'route' => ['usuarios.update', $usuario], 'method' => 'PUT']) !!}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                {!! Form::label('rut', 'RUT:', ['for' => 'rut'] ) !!}
                                <div class="row">
                                    <div class="col-md-9">
                                        {!! Form::text('rut', null , ['class' => 'form-control', 'readonly', 'id' => 'rut', 'required', 'placeholder' => 'Ej:(12345678-9)', 'pattern' => '^[0-9]{7,8}[\-][0-9, k, K]{1}', 'maxlength' => '10' ] ) !!}
                                    </div>
                                    <div class="col-md-3">
                                        {!! Form::text('dv', null , ['class' => 'form-control', 'id' => 'dv', 'readonly', 'placeholder' => 'Ej:(12345678-9)', 'maxlength' => '10', 'onblur' => 'getTrabajador(this)', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();', 'title' => 'Sin puntos, con guión'] ) !!}        
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                {!! Form::label('email', 'Correo electrónico:', ['for' => 'email'] ) !!}
                                {!! Form::email('email', null , ['class' => 'form-control', 'id' => 'email', 'required', 'placeholder' => 'Ingrese el cooreo electrónico', 'maxlength' => '100', 'onblur' => 'getTrabajadorCorreoEdit(this)' , 'autocomplete' => 'off']  ) !!}
                            </div>

                            <div class="form-group col-md-4">
                                {!! Form::label('nombres', 'Nombres:', ['for' => 'nombres'] ) !!}
                                {!! Form::text('nombres', null , ['class' => 'form-control', 'id' => 'nombres', 'required', 'placeholder' => 'Ingrese los nombres', 'maxlength' => '25', 'pattern' => '[A-Za-záéíóúñÑÁÉÍÓÚ0-9 ]+' , 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                            </div>                     
                            
                            <div class="form-group col-md-3">
                                {!! Form::label('apellido_paterno', 'Apellido paterno:', ['for' => 'apellido_paterno'] ) !!}
                                {!! Form::text('apellido_paterno', null , ['class' => 'form-control', 'id' => 'apellido_paterno', 'required', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '25', 'pattern' => '[A-Za-záéíóúñÑÁÉÍÓÚ0-9 ]+' , 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                            </div>
                        
                            <div class="form-group col-md-3">
                                {!! Form::label('apellido_materno', 'Apellido materno:', ['for' => 'apellido_materno'] ) !!}
                                {!! Form::text('apellido_materno', null , ['class' => 'form-control', 'id' => 'apellido_materno', 'required', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '25', 'pattern' => '[A-Za-záéíóúñÑÁÉÍÓÚ0-9 ]+' , 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                            </div>
                            
                            @if($usuario->rut != Auth::user()->rut)
                                <div class="form-group col-md-3">
                                    {!! Form::label('perfil_id', 'Perfil:', ['for' => 'perfil_id'] ) !!}
                                    {!! Form::select('perfil_id', $perfiles, null, array('class' => 'form-control', 'placeholder' => 'Seleccione perfil')) !!}
                                </div>
                                <div class="form-group col-md-3">
                                    {!! Form::label('sucursal', 'Sucursal:', ['for' => 'sucursal'] ) !!}
                                    {!! Form::select('sucursal', $sucursales, $sucursalActual, array('class' => 'form-control', 'placeholder' => 'Seleccione sucursal', 'required')) !!}
                                </div>
                            @endif
                            
                            <div class="form-group col-md-3">
                                <br>
                                 <a class="btn btn-primary"  href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#exampleModal"  role="button" style="width: 100%">Cambiar contraseña</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! Form::submit('Guardar', array('class' => 'btn btn-info pull-right')) !!} 
                        <a href="javascript:history.back()" type="button" class="btn btn-default pull-left">Volver</a>
                    </div>
                {!! Form::close() !!}

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    {!! Form::open([ 'route' => 'usuarios.changePassword', 'method' => 'POST' ]) !!}
                    <div class="modal-content">
                      <div class="modal-header bg-blue">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Cambiar contraseña</h5>
                      </div>
                      <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    {!! Form::label('password', 'Cambiar contraseña:', ['for' => 'password'] ) !!}
                                    {!! Form::text('rut_usuario', $usuario->rut , ['class' => 'hidden' ]  ) !!}
                                    {!! Form::password('contrasena', array('class' => 'form-control', 'id' => 'contrasena', 'placeholder' => 'Escribe la contraseña', 'minlength' => '6', 'maxlength' => '25', 'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.])([A-Za-z\d.]|[^ ]){6,25}$', 'autocomplete' => 'off', 'title' => 'Debe contener: una mayúscula, un número, letras y punto' )  ) !!}
                                </div>  
                                <div class="form-group col-md-6">
                                    {!! Form::label('repassword', 'Cambiar contraseña:', ['for' => 'repassword'] ) !!}
                                    {!! Form::password('recontrasena', array('class' => 'form-control', 'id' => 'recontrasena', 'placeholder' => 'Repite la contraseña', 'minlength' => '6', 'maxlength' => '25', 'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.])([A-Za-z\d.]|[^ ]){6,25}$', 'autocomplete' => 'off', 'title' => 'Debe contener: una mayúscula, un número, letras y punto' )  ) !!}
                                </div>
                            </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Volver</button>
                        {!! Form::submit('Guardar', array('class' => 'btn btn-primary pull-right')) !!} 
                      </div>
                    </div>
                    {!! Form::close() !!}
                  </div>
                </div>
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
