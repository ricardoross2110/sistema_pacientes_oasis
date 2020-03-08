<div class="modal fade " id="createpaciente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            @if(Auth::user()->perfil_id == 3)
                <div class="modal-header bg-green">
            @else
                <div class="modal-header bg-aqua">
            @endif
                <center><h2 class="box-title">Agregar nuevo paciente</h2></center>
            </div>
            {!! Form::open([ 'route' => 'pacientes.store', 'method' => 'POST' ]) !!}
          	    <div id="mensajeCliente"></div>
                <div class="modal-body col-md-12">
                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('rut', 'RUT:', ['for' => 'rut'] ) !!}
                            <div class="row">
                                <div class="form-group col-md-8">
                                    {!! Form::text('rutN', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678' , 'pattern' => '^[0-9]{7,8}', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8' ,'required', 'autocomplete' => 'off']  ) !!}
                                </div>
                                <div class="form-group col-md-4">
                                    {!! Form::text('dvN', null , ['class' => 'form-control','required', 'placeholder' => 'DV', 'maxlength' => '1', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return digitoverificador(event)', 'autocomplete' => 'off'] ) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('nombreN', 'Nombres:', ['for' => 'nombreN'] ) !!}
                            {!! Form::text('nombreN', null , ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese los nombres', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                        </div>  
                        <div class="form-group col-md-4">
                            {!! Form::label('apellido_paternoN', 'Apellido paterno:', ['for' => 'nombreN'] ) !!}
                            {!! Form::text('apellido_paternoN', null , ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '25', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                        </div>  
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            {!! Form::label('apellido_maternoN', 'Apellido materno:', ['for' => 'nombreN'] ) !!}
                            {!! Form::text('apellido_maternoN', null , ['class' => 'form-control','required', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '25', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('correoN', 'Correo electrónico:', ['for' => 'correoN'] ) !!}
                            {!! Form::email('correoN', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el correo electrónico', 'maxlength' => '150', 'autocomplete' => 'off']  ) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('telefonoN', 'Teléfono:', ['for' => 'telefonoN'] ) !!}
                            {!! Form::text('telefonoN', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el número de télefono', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '12','required', 'autocomplete' => 'off']  ) !!}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-8">
                            {!! Form::label('direccionN', 'Dirección:', ['for' => 'direccionN'] ) !!}
                            {!! Form::text('direccionN', null , ['class' => 'form-control', 'placeholder' => 'Ingrese la dirección', 'maxlength' => '50', 'autocomplete' => 'off']  ) !!}
                        </div>
                        <div class="form-group col-md-4">
                            {!! Form::label('fecha_nacimientoN', 'Fecha nacimiento:', ['for' => 'fecha_nacimientoN'] ) !!}
                            {!! Form::text('fecha_nacimientoN', null , ['class' => 'form-control', 'placeholder' => 'Seleccione fecha de nacimiento', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off','required']  ) !!}
                        </div> 
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('facebookN', 'Facebook (Opcional):', ['for' => 'facebookN'] ) !!}
                            <div class="form-group has-feedback">
                                {!! Form::text('facebookN', null , ['class' => 'form-control', 'maxlength' => '500', 'placeholder' => 'Ingrese link de Facebook', 'autocomplete' => 'off']  ) !!}
                                <span class="fa fa-facebook-square form-control-feedback"></span>
                            </div>
                        </div>  
                        <div class="form-group col-md-6">
                            {!! Form::label('instagramN', 'Instagram (Opcional):', ['for' => 'instagramN'] ) !!}
                            <div class="form-group has-feedback">
                                {!! Form::text('instagramN', null , ['class' => 'form-control', 'maxlength' => '500', 'placeholder' => 'Ingrese link de Instagram', 'autocomplete' => 'off']  ) !!}
                                <span class="fa fa-instagram form-control-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="form-group col-md-12">
                            {!! Form::label('observacionN', 'Observación:', ['for' => 'observacionN'] ) !!}
                            {!! Form::textarea('observacionN', null, ['class' => 'form-control', 'rows' => 10, 'cols' => 20, 'style' => 'resize:none; width: 100%', 'placeholder' => 'Ingrese una observación', 'maxlength' => '500', 'autocomplete' => 'off']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    @if(Auth::user()->perfil_id == 3)                        
                        {!! Form::submit('Agregar', array('id' => 'agregar_button', 'class' => 'btn btn-success')) !!}
                    @else
                        {!! Form::submit('Agregar', array('id' => 'agregar_button', 'class' => 'btn btn-info')) !!}
                    @endif
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>