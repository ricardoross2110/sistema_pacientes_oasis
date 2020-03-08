<div class="modal fade " id="createusuario">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-aqua">
                <center><h2 class="box-title">Agregar nuevo usuario</h2></center>
            </div>

            <div id="mensaje"></div>

            <div class="modal-body col-md-12">
                <div class="row">
                    <div class="form-group col-md-4">
                        <?php echo Form::label('rut', 'RUT:', ['for' => 'rut'] ); ?>

                        <div class="row">
                            <div class="form-group col-md-8">
                                <?php echo Form::text('rut', null , ['class' => 'form-control', 'required', 'placeholder' => 'Ej: 12345678', 'pattern' => '^[0-9]{7,8}', 'maxlength' => '8', 'title' => 'Ingresa RUT sin puntos', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off'] ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::text('dv', null , ['class' => 'form-control', 'id' => 'dv', 'required', 'placeholder' => 'DV', 'pattern' => '^[0-9, K]{1}', 'maxlength' => '1', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();', 'onkeypress' => 'return digitoverificador(event)', 'autocomplete' => 'off'] ); ?>

                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('email', 'Correo electrónico:', ['for' => 'email'] ); ?>

                        <?php echo Form::email('email', null , ['class' => 'form-control', 'id' => 'email', 'required', 'placeholder' => 'Ingrese el correo electrónico', 'maxlength' => '100' , 'autocomplete' => 'off']  ); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('nombres', 'Nombres:', ['for' => 'nombres'] ); ?>

                        <?php echo Form::text('nombres', null , ['class' => 'form-control', 'id' => 'nombres', 'required', 'placeholder' => 'Ingrese los nombres', 'maxlength' => '25', 'pattern' => '[A-Za-záéíóúñÑÁÉÍÓÚ0-9 ]+' , 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <?php echo Form::label('apellidoPaterno', 'Apellido paterno:', ['for' => 'apellidoPaterno'] ); ?>

                        <?php echo Form::text('apellidoPaterno', null , ['class' => 'form-control', 'id' => 'apellidoPaterno', 'required', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '25', 'pattern' => '[A-Za-záéíóúñÑÁÉÍÓÚ0-9 ]+' , 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                    </div>
                    
                    <div class="form-group col-md-4">
                        <?php echo Form::label('apellidoMaterno', 'Apellido materno:', ['for' => 'apellidoMaterno'] ); ?>

                        <?php echo Form::text('apellidoMaterno', null , ['class' => 'form-control', 'id' => 'apellidoMaterno', 'required', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '25', 'pattern' => '[A-Za-záéíóúñÑÁÉÍÓÚ0-9 ]+' , 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('perfil', 'Perfil:', ['for' => 'perfil'] ); ?>

                                <?php echo Form::select('perfil', $perfiles, null, array('class' => 'form-control', 'placeholder' => 'Seleccione perfil', 'required')); ?>

                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="form-group col-md-4">
                        <?php echo Form::label('password', 'Contraseña:', ['for' => 'password'] ); ?>

                        <?php echo Form::password('contrasena', array('class' => 'form-control', 'required', 'id' => 'contrasena', 'placeholder' => 'Ingrese la contraseña', 'minlength' => '6', 'maxlength' => '25', 'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.])([A-Za-z\d.]|[^ ]){6,25}$', 'autocomplete' => 'off', 'title' => 'Debe contener: una mayúscula, un número, letras y punto' )  ); ?>

                    </div>  
                    <div class="form-group col-md-4">
                        <?php echo Form::label('repassword', 'Repite contraseña:', ['for' => 'repassword'] ); ?>

                        <?php echo Form::password('recontrasena', array('class' => 'form-control', 'id' => 'recontrasena', 'placeholder' => 'Repite la contraseña', 'minlength' => '6', 'maxlength' => '25', 'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.])([A-Za-z\d.]|[^ ]){6,25}$', 'autocomplete' => 'off', 'title' => 'Debe contener: una mayúscula, un número, letras y punto' , 'required')  ); ?>

                        
                    </div>
                    <div class="form-group col-md-4">
                        <?php echo Form::label('sucursal', 'Sucursal:', ['for' => 'sucursal'] ); ?>

                        <?php echo Form::select('sucursal', $sucursales, null, array('class' => 'form-control', 'placeholder' => 'Seleccione sucursal', 'required')); ?>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                <?php echo Form::submit('Agregar', array('id' => 'agregar_button', 'class' => 'btn btn-info')); ?>

            </div>
        </div>
    </div>
</div>