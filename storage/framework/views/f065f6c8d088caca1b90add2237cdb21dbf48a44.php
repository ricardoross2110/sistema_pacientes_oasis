<?php $__env->startSection('htmlheader_title'); ?>
    <?php echo e(trans('adminlte_lang::message.usarios')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    Editar usuario
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.administracion')); ?></li>
    <li><?php echo e(trans('adminlte_lang::message.usuarios')); ?></li>
    <li class="active">Editar usaurio</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="mensaje"></div>
            <div class="box box-info">

                <?php echo Form::model($usuario, [ 'route' => ['usuarios.update', $usuario], 'method' => 'PUT']); ?>

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <?php echo Form::label('rut', 'RUT:', ['for' => 'rut'] ); ?>

                                <div class="row">
                                    <div class="col-md-9">
                                        <?php echo Form::text('rut', null , ['class' => 'form-control', 'readonly', 'id' => 'rut', 'required', 'placeholder' => 'Ej:(12345678-9)', 'pattern' => '^[0-9]{7,8}[\-][0-9, k, K]{1}', 'maxlength' => '10' ] ); ?>

                                    </div>
                                    <div class="col-md-3">
                                        <?php echo Form::text('dv', null , ['class' => 'form-control', 'id' => 'dv', 'readonly', 'placeholder' => 'Ej:(12345678-9)', 'maxlength' => '10', 'onblur' => 'getTrabajador(this)', 'onkeyup'=>'javascript:this.value=this.value.toUpperCase();', 'title' => 'Sin puntos, con guión'] ); ?>        
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <?php echo Form::label('email', 'Correo electrónico:', ['for' => 'email'] ); ?>

                                <?php echo Form::email('email', null , ['class' => 'form-control', 'id' => 'email', 'required', 'placeholder' => 'Ingrese el cooreo electrónico', 'maxlength' => '100', 'onblur' => 'getTrabajadorCorreoEdit(this)' , 'autocomplete' => 'off']  ); ?>

                            </div>

                            <div class="form-group col-md-4">
                                <?php echo Form::label('nombres', 'Nombres:', ['for' => 'nombres'] ); ?>

                                <?php echo Form::text('nombres', null , ['class' => 'form-control', 'id' => 'nombres', 'required', 'placeholder' => 'Ingrese los nombres', 'maxlength' => '25', 'pattern' => '[A-Za-záéíóúñÑÁÉÍÓÚ0-9 ]+' , 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                            </div>                     
                            
                            <div class="form-group col-md-3">
                                <?php echo Form::label('apellido_paterno', 'Apellido paterno:', ['for' => 'apellido_paterno'] ); ?>

                                <?php echo Form::text('apellido_paterno', null , ['class' => 'form-control', 'id' => 'apellido_paterno', 'required', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '25', 'pattern' => '[A-Za-záéíóúñÑÁÉÍÓÚ0-9 ]+' , 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                            </div>
                        
                            <div class="form-group col-md-3">
                                <?php echo Form::label('apellido_materno', 'Apellido materno:', ['for' => 'apellido_materno'] ); ?>

                                <?php echo Form::text('apellido_materno', null , ['class' => 'form-control', 'id' => 'apellido_materno', 'required', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '25', 'pattern' => '[A-Za-záéíóúñÑÁÉÍÓÚ0-9 ]+' , 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                            </div>
                            
                            <?php if($usuario->rut != Auth::user()->rut): ?>
                                <div class="form-group col-md-3">
                                    <?php echo Form::label('perfil_id', 'Perfil:', ['for' => 'perfil_id'] ); ?>

                                    <?php echo Form::select('perfil_id', $perfiles, null, array('class' => 'form-control', 'placeholder' => 'Seleccione perfil')); ?>

                                </div>
                                <div class="form-group col-md-3">
                                    <?php echo Form::label('sucursal', 'Sucursal:', ['for' => 'sucursal'] ); ?>

                                    <?php echo Form::select('sucursal', $sucursales, $sucursalActual, array('class' => 'form-control', 'placeholder' => 'Seleccione sucursal', 'required')); ?>

                                </div>
                            <?php endif; ?>
                            
                            <div class="form-group col-md-3">
                                <br>
                                 <a class="btn btn-primary"  href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#exampleModal"  role="button" style="width: 100%">Cambiar contraseña</a>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php echo Form::submit('Guardar', array('class' => 'btn btn-info pull-right')); ?> 
                        <a href="javascript:history.back()" type="button" class="btn btn-default pull-left">Volver</a>
                    </div>
                <?php echo Form::close(); ?>


                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <?php echo Form::open([ 'route' => 'usuarios.changePassword', 'method' => 'POST' ]); ?>

                    <div class="modal-content">
                      <div class="modal-header bg-blue">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Cambiar contraseña</h5>
                      </div>
                      <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <?php echo Form::label('password', 'Cambiar contraseña:', ['for' => 'password'] ); ?>

                                    <?php echo Form::text('rut_usuario', $usuario->rut , ['class' => 'hidden' ]  ); ?>

                                    <?php echo Form::password('contrasena', array('class' => 'form-control', 'id' => 'contrasena', 'placeholder' => 'Escribe la contraseña', 'minlength' => '6', 'maxlength' => '25', 'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.])([A-Za-z\d.]|[^ ]){6,25}$', 'autocomplete' => 'off', 'title' => 'Debe contener: una mayúscula, un número, letras y punto' )  ); ?>

                                </div>  
                                <div class="form-group col-md-6">
                                    <?php echo Form::label('repassword', 'Cambiar contraseña:', ['for' => 'repassword'] ); ?>

                                    <?php echo Form::password('recontrasena', array('class' => 'form-control', 'id' => 'recontrasena', 'placeholder' => 'Repite la contraseña', 'minlength' => '6', 'maxlength' => '25', 'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.])([A-Za-z\d.]|[^ ]){6,25}$', 'autocomplete' => 'off', 'title' => 'Debe contener: una mayúscula, un número, letras y punto' )  ); ?>

                                </div>
                            </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Volver</button>
                        <?php echo Form::submit('Guardar', array('class' => 'btn btn-primary pull-right')); ?> 
                      </div>
                    </div>
                    <?php echo Form::close(); ?>

                  </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

  <script type="text/javascript">

    $('#fecha_nacimiento').datepicker({
        format: "dd/mm/yyyy",
        language: 'es',
        todayHighlight: true,
        autoclose: true,
    }); 

    var token   = "<?php echo e(csrf_token()); ?>";
    var rut     = $('#rut').val();

    
  </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>