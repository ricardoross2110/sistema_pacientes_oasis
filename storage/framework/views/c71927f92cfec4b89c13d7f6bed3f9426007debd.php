<?php $__env->startSection('htmlheader_title'); ?>
    Editar tratamiento
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    Editar tratamiento
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.atencion')); ?></li>
    <li class="active"><?php echo e(trans('adminlte_lang::message.tratamiento')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    <?php if($tratamiento->tipo_tratamiento_id == 3): ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-info">
                    <?php echo Form::model($tratamiento, [ 'route' => ['tratamiento.update', $tratamiento->folio], 'method' => 'PUT']); ?>

                    <div class="box-body table-responsive">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <?php echo Form::label('folio', 'Número de folio:', ['for' => 'folio'] ); ?>

                                <?php echo Form::text('folio', null , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el número de folio', 'maxlength' => '50']  ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('nombre', 'Nombre del tratamiento:', ['for' => 'nombre'] ); ?>

                                <?php echo Form::text('nombre', $tratamiento->nombre , ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre de tratamiento', 'maxlength' => '50', 'disabled', 'autocomplete' => 'off']  ); ?>

                            </div>
                            <div class="form-group col-md-2">
                                <?php echo Form::label('num_control', 'Número de control:', ['for' => 'num_control'] ); ?>

                                <?php echo Form::number('num_control', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el número de control', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)',  'min' => '0', 'disabled']  ); ?>

                            </div>
                            <div class="form-group col-md-2">
                                <?php echo Form::label('valor', 'Valor:', ['for' => 'valor'] ); ?>

                                <?php echo Form::number('valor', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el valor', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)', 'min' => '0', 'disabled']  ); ?>

                            </div>
                            <div class="form-group col-md-2">
                                <?php echo Form::label('tipo_tratamiento_id', 'Tipo de tratamiento:', ['for' => 'tipo_tratamiento_id'] ); ?>

                                <?php echo Form::text('tipo_tratamiento_id', 'General' , ['class' => 'form-control',  'min' => '0', 'disabled']  ); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="mensajeCliente"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <?php echo Form::label('rut_paciente', 'RUT:', ['for' => 'rut_paciente'] ); ?>

                                <?php echo Form::text('rut_paciente', $tratamiento->rut.'-'.$tratamiento->dv , ['class' => 'form-control', 'placeholder' => 'Ingrese RUT de paciente', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'disabled']  ); ?>

                            </div>
                            <div class="col-md-4">
                                <?php echo Form::label('nombre_paciente', 'Nombre:', ['for' => 'nombre_paciente'] ); ?>

                                <?php echo Form::text('nombre_paciente', $tratamiento->nombres.' '.$tratamiento->apellido_paterno.' '.$tratamiento->apellido_materno, ['class' => 'form-control', 'disabled', 'placeholder' => 'Nombre del paciente', 'maxlength' => '50']  ); ?>

                            </div>
                            <div class="col-md-3">
                                <?php echo Form::label('correo_paciente', 'Correo electrónico:', ['for' => 'correo_paciente'] ); ?>

                                <?php echo Form::text('correo_paciente', $tratamiento->email, ['class' => 'form-control', 'disabled', 'placeholder' => 'Correo electrónico del paciente', 'maxlength' => '50']  ); ?>

                            </div>
                            <div class="col-md-2">
                                <?php echo Form::label('telefono_paciente', 'Teléfono:', ['for' => 'telefono_paciente'] ); ?>

                                <?php echo Form::text('telefono_paciente', $tratamiento->telefono, ['class' => 'form-control', 'disabled', 'placeholder' => 'Teléfono del paciente', 'maxlength' => '50']  ); ?>

                            </div>
                        </div>
                        <br>
                    </div>
                    <div class="box-footer">
                      <a href="<?php echo e(url('/tratamiento')); ?>" role="button" class="btn btn-default pull-left">Volver</a>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>     
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="box box-info">
                    <?php echo Form::model($tratamiento, [ 'route' => ['tratamiento.update', $tratamiento->folio], 'method' => 'PUT']); ?>

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-2">
                                <?php echo Form::label('folio', 'Número de folio:', ['for' => 'folio'] ); ?>

                                <?php echo Form::text('folio', null , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el número de folio', 'maxlength' => '50']  ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('nombre', 'Nombre del tratamiento:', ['for' => 'nombre'] ); ?>

                                <?php echo Form::text('nombre',  $tratamiento->nombre , ['class' => 'form-control', 'placeholder' => 'Escribe el nombre de tratamiento', 'maxlength' => '50', 'autocomplete' => 'off','required']  ); ?>

                            </div>
                            <div class="form-group col-md-2">
                                <?php echo Form::label('num_control', 'Número de control:', ['for' => 'num_control'] ); ?>

                                <?php echo Form::number('num_control', $tratamiento->num_control , ['class' => 'form-control', 'placeholder' => 'Escribe el número de control', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)',  'min' => '0','required']  ); ?>

                            </div>
                            <div class="form-group col-md-2">
                                <?php echo Form::label('valor', 'Valor:', ['for' => 'valor'] ); ?>

                                <?php echo Form::number('valor', null , ['class' => 'form-control', 'placeholder' => 'Escribe el valor', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)', 'min' => '0', 'required']  ); ?>

                            </div>
                            <div class="form-group col-md-2">
                                <?php echo Form::label('tipo_tratamiento_id', 'Tipo de tratamiento:', ['for' => 'tipo_tratamiento_id'] ); ?>

                                <?php echo Form::text('tipo_tratamiento_id', $tratamiento->tipo , ['class' => 'form-control',  'min' => '0', 'disabled']  ); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="mensajeCliente"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <?php echo Form::label('rut_paciente', 'RUT:', ['for' => 'rut_paciente'] ); ?>

                                <?php echo Form::text('rut_paciente', $tratamiento->rut.'-'.$tratamiento->dv , ['class' => 'form-control', 'placeholder' => 'Escribe RUT de paciente', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'disabled']  ); ?>

                            </div>
                            <div class="col-md-4">
                                <?php echo Form::label('nombre_paciente', 'Nombre:', ['for' => 'nombre_paciente'] ); ?>

                                <?php echo Form::text('nombre_paciente', $tratamiento->nombres.' '.$tratamiento->apellido_paterno.' '.$tratamiento->apellido_materno, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre del paciente', 'maxlength' => '50']  ); ?>

                            </div>
                            <div class="col-md-3">
                                <?php echo Form::label('correo_paciente', 'Correo electrónico:', ['for' => 'correo_paciente'] ); ?>

                                <?php echo Form::text('correo_paciente', $tratamiento->email, ['class' => 'form-control', 'disabled', 'placeholder' => 'Correo del paciente', 'maxlength' => '50']  ); ?>

                            </div>
                            <div class="col-md-2">
                                <?php echo Form::label('telefono_paciente', 'Teléfono:', ['for' => 'telefono_paciente'] ); ?>

                                <?php echo Form::text('telefono_paciente', $tratamiento->telefono, ['class' => 'form-control', 'disabled', 'placeholder' => 'Teléfono del paciente', 'maxlength' => '50']  ); ?>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo Form::label('observacion', 'Observación:', ['for' => 'observacion'] ); ?>

                                <?php echo Form::textarea('observacion', $tratamiento->observacion, ['class' => 'form-control', 'rows' => 10, 'cols' => 20, 'style' => 'resize:none; width: 100%', 'placeholder' => 'Escribe una observación', 'maxlength' => '500', 'autocomplete' => 'off']); ?>

                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                      <a href="<?php echo e(url('/tratamiento')); ?>" role="button" class="btn btn-default">Volver</a>
                        <?php echo Form::submit('Guardar', array('id' => 'agregar_button', 'class' => 'btn btn-info pull-right')); ?>

                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>     
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token                =  "<?php echo e(csrf_token()); ?>";
    var rut_pacienteN        =  $('#rut_pacienteN').val();
  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>