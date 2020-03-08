<?php $__env->startSection('htmlheader_title'); ?>
    <?php echo e(trans('adminlte_lang::message.usarios')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    Editar paciente
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.administracion')); ?></li>
    <li><?php echo e(trans('adminlte_lang::message.pacientes')); ?></li>
    <li class="active">Editar paciente</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="mensaje"></div>
            <div class="box box-info">

                <?php echo Form::model($paciente, [ 'route' => ['pacientes.update', $paciente->rut], 'method' => 'PUT']); ?>

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <?php echo Form::label('rut', 'RUT:', ['for' => 'rut'] ); ?>

                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <?php echo Form::number('rut',null, ['disabled', 'class' => 'form-control', 'placeholder' => '123456789' , 'pattern' => '^[0-9]{7,8}', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8' ]  ); ?>

                                    </div>
                                    <div class="form-group col-md-4">
                                        <?php echo Form::text('dv', null , ['disabled', 'class' => 'form-control', 'required', 'placeholder' => 'D', 'maxlength' => '1',  'onkeypress' => 'return digitoverificador(event)'] ); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('nombres', 'Nombres:', ['for' => 'nombres'] ); ?>

                                <?php echo Form::text('nombres', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese los nombres', 'maxlength' => '50' , 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                            </div>  
                            <div class="form-group col-md-4">
                                <?php echo Form::label('apellido_paterno', 'Apellido paterno:', ['for' => 'apellido_paterno'] ); ?>

                                <?php echo Form::text('apellido_paterno', null, ['class' => 'form-control','required', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                            </div>  
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <?php echo Form::label('apellido_materno', 'Apellido materno:', ['for' => 'apellido_materno'] ); ?>

                                <?php echo Form::text('apellido_materno', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('email', 'Correo electrónico:', ['for' => 'email'] ); ?>

                                <?php echo Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el correo electrónico', 'maxlength' => '50', 'autocomplete' => 'off']  ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('telefono', 'Teléfono:', ['for' => 'telefono'] ); ?>

                                <?php echo Form::text('telefono', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el número de télefono', 'maxlength' => '12', 'onkeypress' => 'return onlyNumbers(event)' , 'required', 'autocomplete' => 'off' ] ); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <?php echo Form::label('direccion', 'Dirección:', ['for' => 'direccion'] ); ?>

                                <?php echo Form::text('direccion', null , ['class' => 'form-control', 'id' => 'correoN', 'placeholder' => 'Ingrese la direccion', 'maxlength' => '150', 'autocomplete' => 'off']  ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('fecha_nacimiento', 'Fecha nacimiento:', ['for' => 'fecha_nacimiento'] ); ?>

                                <?php echo Form::text('fecha_nacimiento', $fecha_nacimiento , ['class' => 'form-control', 'placeholder' => 'Seleccione fecha de nacimiento','autocomplete' => 'off', 'maxlength' => '150', 'required']); ?>

                            </div> 
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <?php echo Form::label('facebook', 'Facebook (Opcional):', ['for' => 'facebook'] ); ?>

                                <div class="form-group has-feedback">
                                    <?php echo Form::text('facebook', null, ['class' => 'form-control', 'maxlength' => '500', 'placeholder' => 'Ingrese link de Facebook', 'autocomplete' => 'off']  ); ?>

                                    <span class="fa fa-facebook-square form-control-feedback"></span>
                                </div>
                            </div>  
                            <div class="form-group col-md-6">
                                <?php echo Form::label('instagram', 'Instagram (Opcional):', ['for' => 'instagram'] ); ?>

                                <div class="form-group has-feedback">
                                    <?php echo Form::text('instagram', null, ['class' => 'form-control', 'maxlength' => '500', 'placeholder' => 'Ingrese link de Instagram', 'autocomplete' => 'off']  ); ?>

                                    <span class="fa fa-instagram form-control-feedback"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <?php echo Form::label('observacion', 'Observación:', ['for' => 'observacionN'] ); ?>

                                <?php echo Form::textarea('observacion', null, ['class' => 'form-control', 'rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%', 'placeholder' => 'Ingrese una observación', 'autocomplete' => 'off']); ?>

                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php echo Form::submit('Guardar', array('class' => 'btn btn-info pull-right')); ?> 
                        <a href="javascript:history.back()" type="button" class="btn btn-default pull-left">Volver</a>
                    </div>
                <?php echo Form::close(); ?>

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