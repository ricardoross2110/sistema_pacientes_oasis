<div class="modal fade " id="createprofesional">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-aqua">
                <center><h2 class="box-title">Agregar nuevo profesional</h2></center>
            </div>
            {!! Form::open([ 'route' => 'profesionales.store', 'method' => 'POST' ]) !!}
      	    <div id="mensajeCliente"></div>
            <div class="modal-body col-md-12">
                <div class="row">
                    <div class="form-group col-md-4">
                        {!! Form::label('rut', 'RUT:', ['for' => 'rut'] ) !!}
                        <div class="row">
                            <div class="form-group col-md-8">
                                {!! Form::text('rutN', null , ['class' => 'form-control', 'id' => 'rutN', 'placeholder' => 'Ej: 12345678' , 'pattern' => '^[0-9]{7,8}' , 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8','required' , 'autocomplete' => 'off'] ) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::text('dvN', null , ['class' => 'form-control', 'id' => 'dvN', 'required', 'placeholder' => 'DV', 'maxlength' => '1', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();','onkeypress' => 'return digitoverificador(event)', 'autocomplete' => 'off'] ) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-8">
                        {!! Form::label('nombreN', 'Nombres:', ['for' => 'nombreN'] ) !!}
                        {!! Form::text('nombreN', null , ['class' => 'form-control', 'id' => 'nombreN', 'required', 'placeholder' => 'Ingrese los nombres', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                    </div> 
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        {!! Form::label('apellido_paternoN', 'Apellido paterno:', ['for' => 'nombreN'] ) !!}
                        {!! Form::text('apellido_paternoN', null , ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                    </div> 
                    <div class="form-group col-md-4">
                            {!! Form::label('apellido_maternoN', 'Apellido materno:', ['for' => 'nombreN'] ) !!}
                            {!! Form::text('apellido_maternoN', null , ['class' => 'form-control','required', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('telefonoN', 'Teléfono:', ['for' => 'telefonoN'] ) !!}
                        {!! Form::text('telefonoN', null , ['class' => 'form-control', 'id' => 'telefonoN', 'placeholder' => 'Ingrese el número de teléfono', 'maxlength' => '12', 'onkeypress' => 'return onlyNumbers(event)', 'required', 'autocomplete' => 'off']  ) !!}
                    </div> 
                </div>
                <br>
                <div class="row"> 
                    <div class="form-group col-md-4">
                        {!! Form::label('correoN', 'Correo electrónico:', ['for' => 'correoN'] ) !!}
                        {!! Form::email('correoN', null , ['class' => 'form-control', 'id' => 'correoN', 'placeholder' => 'Ingrese el correo electrónico', 'maxlength' => '50', 'required', 'autocomplete' => 'off']  ) !!}
                    </div>      
                    <div class="form-group col-md-8">
                        {!! Form::label('direccionN', 'Dirección:', ['for' => 'direccionN'] ) !!}
                        {!! Form::text('direccionN', null , ['class' => 'form-control', 'id' => 'direccionN', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'required', 'autocomplete' => 'off']  ) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-md-4">
                        {!! Form::label('sucursalN', 'Sucursal:', ['for' => 'sucursalN'] ) !!}
                        <br>
                        {!! Form::select('sucursalN[]', $sucursales, null, array('class' => 'form-control sucursal', 'data-placeholder' => 'Sucursal', 'required', 'multiple', 'style' => 'width: 100%')) !!}
                    </div> 
                    <div class="form-group col-md-4">
                        {!! Form::label('profesionN', 'Profesión:', ['for' => 'profesionN'] ) !!}
                        {!! Form::select('profesionN', $profesiones, null, array('class' => 'form-control', 'placeholder' => 'Seleccione profesión', 'required')) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::label('tipoContratoN', 'Tipo de contrato:', ['for' => 'tipoContratoN'] ) !!}
                        {!! Form::select('tipoContratoN', $tipoContrato, null, array('class' => 'form-control', 'placeholder' => 'Seleccione tipo de contrato', 'required')) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                        <div class="form-group col-md-12">
                            {!! Form::label('observacionN', 'Observación:', ['for' => 'observacionN'] ) !!}
                            {!! Form::textarea('observacionN', null, ['class' => 'form-control', 'rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%', 'placeholder' => 'Ingrese una observación', 'autocomplete' => 'off']) !!}
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button id="guardar_cliente" type="submit" class="btn btn-info">Agregar</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>