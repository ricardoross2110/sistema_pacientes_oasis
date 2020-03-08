<?php $__env->startSection('htmlheader_title'); ?>
    <?php echo e(trans('adminlte_lang::message.usarios')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    Editar profesional
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.administracion')); ?></li>
    <li><?php echo e(trans('adminlte_lang::message.pacientes')); ?></li>
    <li class="active">Editar profesional</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="mensaje"></div>
            <div class="box box-info">
                <?php echo Form::model($profesional, [ 'route' => ['profesionales.update', $profesional->rut], 'method' => 'PUT']); ?>

                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <?php echo Form::label('rut', 'RUT:', ['for' => 'rut'] ); ?>

                            <div class="row">
                                <div class="form-group col-md-8">
                                    <?php echo Form::number('rut', null , ['disabled', 'class' => 'form-control', 'id' => 'rut', 'placeholder' => '12345678' , 'pattern' => '^[0-9]{7,8}']  ); ?>

                                </div>
                                <div class="form-group col-md-4">
                                    <?php echo Form::text('dv', null , ['disabled', 'class' => 'form-control', 'id' => 'dv', 'required', 'placeholder' => 'D', 'maxlength' => '1'] ); ?>

                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-8">
                            <?php echo Form::label('nombre', 'Nombres:', ['for' => 'nombre'] ); ?>

                            <?php echo Form::text('nombres', null, ['class' => 'form-control', 'required', 'placeholder' => 'Ingrese los nombres', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                        </div>  
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4">
                            <?php echo Form::label('apellido_paterno', 'Apellido paterno:', ['for' => 'apellido_paterno'] ); ?>

                            <?php echo Form::text('apellido_paterno', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)', 'required']  ); ?>

                        </div>  
                        <div class="form-group col-md-4">
                            <?php echo Form::label('apellido_materno', 'Apellido materno:', ['for' => 'apellido_materno'] ); ?>

                            <?php echo Form::text('apellido_materno', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)', 'required']  ); ?>

                        </div>  
                        <div class="form-group col-md-4">
                            <?php echo Form::label('email', 'Correo electrónico:', ['for' => 'email'] ); ?>

                            <?php echo Form::text('email', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el correo electrónico', 'maxlength' => '50', 'autocomplete' => 'off', 'required']  ); ?>

                        </div>
                    </div>
                    <div class = "row">
                        <div class="form-group col-md-4">
                            <?php echo Form::label('direccion', 'Dirección:', ['for' => 'direccion'] ); ?>

                            <?php echo Form::text('direccion', null , ['class' => 'form-control', 'id' => 'direccion', 'placeholder' => 'Ingrese la dirección', 'maxlength' => '50', 'autocomplete' => 'off', 'required']  ); ?>

                        </div>
                        <div class="form-group col-md-4">
                            <?php echo Form::label('telefono', 'Teléfono:', ['for' => 'telefonoN'] ); ?>

                            <?php echo Form::text('telefono', null, ['class' => 'form-control', 'id' => 'telefono', 'placeholder' => 'Ingrese el número de teléfono', 'maxlength' => '50', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'required']  ); ?>

                        </div> 
                        <div class="form-group col-md-4">
                            <?php echo Form::label('sucursal', 'Sucursal:', ['for' => 'sucursal'] ); ?>

                            <br>
                            <?php echo Form::select('sucursal[]', $sucursales, null, array('class' => 'form-control sucursal', 'data-placeholder' => 'Seleccione sucursal', 'multiple', 'style' => 'width: 100%', 'required')); ?>

                        </div> 
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <?php echo Form::label('profesion_id', 'Profesión:', ['for' => 'profesion_id'] ); ?>

                            <?php echo Form::select('profesion_id', $profesiones, null, array('class' => 'form-control', 'placeholder' => 'Seleccione profesión')); ?>

                        </div>
                        <div class="form-group col-md-6">
                            <?php echo Form::label('tipo_contrato_id', 'Tipo de contrato:', ['for' => 'tipo_contrato_id'] ); ?>

                            <?php echo Form::select('tipo_contrato_id', $tipoContrato, null, array('class' => 'form-control', 'placeholder' => 'Seleccione tipo de contrato')); ?>

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
                    <a href="javascript:history.back()" type="button" class="btn btn-default pull-left ">Volver</a>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

  <script type="text/javascript">

        var token               = "<?php echo e(csrf_token()); ?>";
        var sucursal          = [];

        $('.sucursal').select2();

        <?php if(isset($sucursalesProfesional)): ?>
          <?php $__currentLoopData = $sucursalesProfesional; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sucursal_p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                sucursal.push(<?php echo e($sucursal_p->sucursal_id); ?>);
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        console.log(sucursal);

        function cargarSelects() {
            cargarSelectSucursal();
        }

        function cargarSelectSucursal() {
            var sucursal_select      =   $('.sucursal');
            sucursal_select.empty().trigger("change");
            $.ajax({
                type    : 'POST',
                url     : "<?php echo e(url('sucursal.cargarSucursales')); ?>",
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>