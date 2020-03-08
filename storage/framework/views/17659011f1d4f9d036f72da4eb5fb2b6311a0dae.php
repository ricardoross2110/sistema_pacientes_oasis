<?php $__env->startSection('htmlheader_title'); ?>
  Detalle atención
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  Detalle atención
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
  <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
  <li><?php echo e(trans('adminlte_lang::message.atencion')); ?></li>
  <li class="active">Detalle atención</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
 
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-body table-responsive">
          <div class="box-body">
            <div class="row">
              <div class="col-md-2">
                <?php echo Form::label('n_folio', 'N° folio:', ['for' => 'n_folio'] ); ?>

                <?php echo Form::text('n_folio', $atenciones->tratamiento_folio, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ); ?>

              </div>
              <div class="col-md-4">
                <?php echo Form::label('tratamiento', 'Tratamiento:', ['for' => 'tratamiento'] ); ?>

                <?php echo Form::text('tratamiento', $atenciones->nombre, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el nombre de tratamiento', 'maxlength' => '50']  ); ?>

              </div>
              <div class="col-md-4">
                <?php echo Form::label('paciente', 'Nombre paciente:', ['for' => 'paciente'] ); ?>

                <?php echo Form::text('paciente', $atenciones->paciente, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre paciente', 'maxlength' => '50']  ); ?>

              </div>
              <div class="col-md-2">
                <?php echo Form::label('controles', 'Controles:', ['for' => 'controles'] ); ?>

                <?php echo Form::text('controles', $atenciones->control , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ); ?>

              </div>
            </div>
          </div>
        </div>
      </div>     
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-body table-responsive">
          <div class="box-body">
            <div class="row">
              <div class="col-md-2">
                <?php echo Form::label('n_folio', 'N° atención:', ['for' => 'n_folio'] ); ?>

                <?php echo Form::text('n_folio', $atenciones->num_atencion, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ); ?>

              </div>
              <div class="col-md-2">
                <?php echo Form::label('tratamiento', 'Fecha:', ['for' => 'tratamiento'] ); ?>

                <?php echo Form::text('tratamiento', $atenciones->fecha, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el nombre de tratamiento', 'maxlength' => '50']  ); ?>

              </div>
              <div class="col-md-2">
                <?php echo Form::label('paciente', 'Hora:', ['for' => 'paciente'] ); ?>

                <?php echo Form::text('paciente', $atenciones->hora, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre paciente', 'maxlength' => '50']  ); ?>

              </div>
              <div class="col-md-6">
                <?php echo Form::label('controles', 'Sucursal:', ['for' => 'controles'] ); ?>

                <?php echo Form::text('controles', $atenciones->sucursal , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ); ?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">                
              <h4><strong>Datos del Profesional</strong></h4>
              <div id="mensajeProfesional">

              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <?php echo Form::label('nombreProfesional', 'Nombre:', ['for' => 'nombreProfesional'] ); ?>

              <?php echo Form::text('nombreProfesional', $atenciones->profesional, ['class' => 'form-control', 'disabled','placeholder' => 'Seleccione profesional']); ?>

            </div>
            <div class="col-md-3">
              <?php echo Form::label('profesion', 'Profesión:', ['for' => 'profesion'] ); ?>

              <?php echo Form::text('profesion', $atenciones->profesion , ['class' => 'form-control', 'disabled', 'placeholder' => 'Profesión', 'maxlength' => '50']  ); ?>

            </div>
            <div class="col-md-3">
              <?php echo Form::label('cargoProfesional', 'Tipo contrato:', ['for' => 'cargoProfesional'] ); ?>

              <?php echo Form::text('cargoProfesional', $atenciones->tipo , ['class' => 'form-control', 'disabled', 'placeholder' => 'Tipo contrato', 'maxlength' => '50']  ); ?>

            </div>
          </div>
          <div class="row">
            <div class="col-md-12">                
              <h4>
                <strong>
                  <?php echo Form::label('observacionB', 'Observaciones:', ['for' => 'observacionB'] ); ?>

                </strong>
              </h4>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <?php echo Form::textarea('observacion', $atenciones->observacion, ['rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%', 'placeholder' => '', 'disabled']); ?>

            </div>
          </div>
        </div>
      </div>
    </div>     
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3><strong>Observaciones registradas</strong></h3>
        </div>
        <div class="box-body">
          <?php $__currentLoopData = $observaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $observacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="row">
              <div class="col-md-6">
                  <?php echo Form::label('fechaob-<?php echo e($observacion->id); ?>', 'Fecha:' ); ?>

                  <?php echo Form::text('fechaob-<?php echo e($observacion->id); ?>', $observacion->fecha , ['class' => 'form-control', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ); ?>

              </div>
              <div class="col-md-6">                
                  <?php echo Form::label('horaob-<?php echo e($observacion->id); ?>', 'Hora:' ); ?>

                  <?php echo Form::text('horaob-<?php echo e($observacion->id); ?>', $observacion->hora , ['class' => 'form-control', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ); ?>

              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <?php echo Form::textarea('observacion-', $observacion->observacion, ['rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%', 'placeholder' => '', 'disabled']); ?>

              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </div>     
  </div>

  <?php if(Auth::user()->perfil_id <= 3): ?>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          <h3><strong>Detalle pago</strong></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">                  
              <div class="row">
                <div class="col-md-3 col-md-offset-3">
                  <strong class="pull-right">Total:</strong>
                </div>
                <div class="col-md-3">         
                  <?php echo Form::text('total', $atenciones->abono , ['class' => 'form-control', 'disabled']  ); ?>         
                  <br>
                </div>
              </div>
              <?php if(!is_null($pagos)): ?>
                <div class="row">
                  <div class="col-md-3 col-md-offset-3">
                    <strong class="pull-right">Formas de pago:</strong>
                  </div>
                </div>
                <?php $__currentLoopData = $pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pago): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <br>                            
                  <div class="row">
                    <div class="col-md-offset-3 col-md-3">
                     <?php echo Form::text('cargoProfesional', $pago->nombre , ['class' => 'form-control', 'disabled', 'placeholder' => 'Tipo contrato', 'maxlength' => '50']  ); ?>

                    </div>
                    <div class="col-md-3">
                      <?php echo Form::text('total1', $pago->monto , ['class' => 'form-control',  'id' => 'total1','disabled', 'placeholder' => 'Ingrese Total']  ); ?>

                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>  
            </div>
          </div>
        </div>
        <div class="box-footer">
          <a href="javascript:history.back()" role="button" class="btn btn-default pull-left">Volver</a>
        </div>
      </div>
    </div>     
  </div>
  <?php else: ?>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-footer">
          <?php echo Form::button('Imprimir', array('onclick' => 'window.print();', 'name' => 'imprimir', 'class' => 'btn btn-info pull-right')); ?>

          <a href="javascript:history.back()" role="button" class="btn btn-default pull-left">Volver</a>
        </div>
      </div>
    </div>     
  </div>
  <?php endif; ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

  <script type="text/javascript">
    var token                =  "<?php echo e(csrf_token()); ?>";

    $(document).ready(function() {
      $('#rut_paciente').keypress(function(e) {
        if(e.which == 13) {
          if ($(this).val() == '11111111') {
            $('#nombreB').val('Paciente Prueba Uno');
          }else{
            $('#mensajeCliente').html('');
            $('#mensajeCliente').html('<div class="alert alert-danger fade in"><strong>No se encuentra el paciente</strong>, el rut ingresado no corresponde a ningún paciente de nuestra base de datos.</div>');
            $(this).val('');
            $('#nombreB').val('');
          }
        }
      });

      $('#rut_profesional').keypress(function(e) {
        if(e.which == 13) {
          if ($(this).val() == '11111111') {
            $('#nombreProfesionalB').val('Profesional Prueba Uno');
            $('#cargoProfesionalB').val('Cargo');
            $('#profesionB').val('Profesión 1');
            $('#mensajePago').html('');
          }else{
            $('#mensajeProfesional').html('');
            $('#mensajeProfesional').html('<div class="alert alert-danger fade in"><strong>No se encuentra el profesional</strong>, el rut ingresado no corresponde a ningún profesional de nuestra base de datos.</div>');
            $(this).val('');
            $('#nombreProfesionalB').val('');
            $('#cargoProfesionalB').val('');
            $('#profesionB').val('');
          }
        }
      });

      $('#confirmarPago').click(function(event) {
        if ($('#total').val() != '') {
          $('#divPago').removeClass('hidden');
          $('#total1').val($('#total').val());
          $('#mensajePago').html('');
        }else{
          $('#mensajePago').html('');
          $('#mensajePago').html('<div class="alert alert-danger fade in"><strong>El monto está en blanco</strong>, Ingrese un monto para confirmar.</div>');
        }
      });
    });

  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>