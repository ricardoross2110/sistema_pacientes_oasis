<div class="modal fade " id="createprofesional">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-aqua">
                <center><h2 class="box-title">Agregar nuevo profesional</h2></center>
            </div>
            <?php echo Form::open([ 'route' => 'profesionales.store', 'method' => 'POST' ]); ?>

      	    <div id="mensajeCliente"></div>
            <div class="modal-body col-md-12">
                <div class="row">
                    <div class="form-group col-md-4">
                        <?php echo Form::label('rut', 'RUT:', ['for' => 'rut'] ); ?>

                        <div class="row">
                            <div class="form-group col-md-8">
                                <?php echo Form::text('rutN', null , ['class' => 'form-control', 'id' => 'rutN', 'placeholder' => 'Ej: 12345678' , 'pattern' => '^[0-9]{7,8}' , 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8','required' , 'autocomplete' => 'off'] ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::text('dvN', null , ['class' => 'form-control', 'id' => 'dvN', 'required', 'placeholder' => 'DV', 'maxlength' => '1', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();','onkeypress' => 'return digitoverificador(event)', 'autocomplete' => 'off'] ); ?>

                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-8">
                        <?php echo Form::label('nombreN', 'Nombres:', ['for' => 'nombreN'] ); ?>

                        <?php echo Form::text('nombreN', null , ['class' => 'form-control', 'id' => 'nombreN', 'required', 'placeholder' => 'Ingrese los nombres', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                    </div> 
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <?php echo Form::label('apellido_paternoN', 'Apellido paterno:', ['for' => 'nombreN'] ); ?>

                        <?php echo Form::text('apellido_paternoN', null , ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                    </div> 
                    <div class="form-group col-md-4">
                            <?php echo Form::label('apellido_maternoN', 'Apellido materno:', ['for' => 'nombreN'] ); ?>

                            <?php echo Form::text('apellido_maternoN', null , ['class' => 'form-control','required', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('telefonoN', 'Teléfono:', ['for' => 'telefonoN'] ); ?>

                        <?php echo Form::text('telefonoN', null , ['class' => 'form-control', 'id' => 'telefonoN', 'placeholder' => 'Ingrese el número de teléfono', 'maxlength' => '12', 'onkeypress' => 'return onlyNumbers(event)', 'required', 'autocomplete' => 'off']  ); ?>

                    </div> 
                </div>
                <br>
                <div class="row"> 
                    <div class="form-group col-md-4">
                        <?php echo Form::label('correoN', 'Correo electrónico:', ['for' => 'correoN'] ); ?>

                        <?php echo Form::email('correoN', null , ['class' => 'form-control', 'id' => 'correoN', 'placeholder' => 'Ingrese el correo electrónico', 'maxlength' => '50', 'required', 'autocomplete' => 'off']  ); ?>

                    </div>      
                    <div class="form-group col-md-8">
                        <?php echo Form::label('direccionN', 'Dirección:', ['for' => 'direccionN'] ); ?>

                        <?php echo Form::text('direccionN', null , ['class' => 'form-control', 'id' => 'direccionN', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'required', 'autocomplete' => 'off']  ); ?>

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-md-4">
                        <?php echo Form::label('sucursalN', 'Sucursal:', ['for' => 'sucursalN'] ); ?>

                        <br>
                        <?php echo Form::select('sucursalN[]', $sucursales, null, array('class' => 'form-control sucursal', 'data-placeholder' => 'Sucursal', 'required', 'multiple', 'style' => 'width: 100%')); ?>

                    </div> 
                    <div class="form-group col-md-4">
                        <?php echo Form::label('profesionN', 'Profesión:', ['for' => 'profesionN'] ); ?>

                        <?php echo Form::select('profesionN', $profesiones, null, array('class' => 'form-control', 'placeholder' => 'Seleccione profesión', 'required')); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('tipoContratoN', 'Tipo de contrato:', ['for' => 'tipoContratoN'] ); ?>

                        <?php echo Form::select('tipoContratoN', $tipoContrato, null, array('class' => 'form-control', 'placeholder' => 'Seleccione tipo de contrato', 'required')); ?>

                    </div>
                </div>
                <br>
                <div class="row">
                        <div class="form-group col-md-12">
                            <?php echo Form::label('observacionN', 'Observación:', ['for' => 'observacionN'] ); ?>

                            <?php echo Form::textarea('observacionN', null, ['class' => 'form-control', 'rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%', 'placeholder' => 'Ingrese una observación', 'autocomplete' => 'off']); ?>

                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <button id="guardar_cliente" type="submit" class="btn btn-info">Agregar</button>
            </div>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div>