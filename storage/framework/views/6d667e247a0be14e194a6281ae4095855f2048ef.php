<?php $__env->startSection('htmlheader_title'); ?>
  <?php echo e(trans('adminlte_lang::message.regobservaciones')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  <?php echo e(trans('adminlte_lang::message.regobservaciones')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
  <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
  <li><?php echo e(trans('adminlte_lang::message.atencion')); ?></li>
  <li class="active"><?php echo e(trans('adminlte_lang::message.observaciones')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <?php echo Form::open(['route'=>'observacion.store', 'method' => 'POST' ]); ?>

        <div class="box-header">
          <h3><strong>Detalle atención</strong></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <?php echo Form::text('atencion_id', $atenciones->id, ['class' => 'hidden']  ); ?>

            <?php echo Form::text('num_folio', $atenciones->tratamiento_folio, ['class' => 'hidden']  ); ?>

            <div class="col-md-2">
              <?php echo Form::label('n_folio', 'N° folio:', ['for' => 'n_folio'] ); ?>

              <?php echo Form::text('n_folio', $atenciones->tratamiento_folio, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ); ?>

            </div>
            <div class="col-md-2">
              <?php echo Form::label('n_atencion', 'N° atención:' ); ?>

              <?php echo Form::text('n_atencion', $atenciones->num_atencion, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ); ?>

            </div>
            <div class="col-md-3">
              <?php echo Form::label('paciente', 'Paciente:', ['for' => 'paciente'] ); ?>

              <?php echo Form::text('paciente', $atenciones->paciente, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre paciente', 'maxlength' => '50']  ); ?>

            </div>
            <div class="col-md-3">
              <?php echo Form::label('nombreProfesional', 'Profesional:', ['for' => 'nombreProfesional'] ); ?>

              <?php echo Form::text('nombreProfesional', $atenciones->profesional, ['class' => 'form-control', 'disabled','placeholder' => 'Seleccione profesional']); ?>

            </div>
            <div class="col-md-2">
              <?php echo Form::label('controles', 'Sucursal:', ['for' => 'controles'] ); ?>

              <?php echo Form::text('controles', $atenciones->sucursal , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ); ?>

            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-md-12">                
              <?php echo Form::label('texto_observacion', 'Observaciones:' ); ?>

              <?php echo Form::textarea('texto_observacion', null, ['rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%', 'placeholder' => 'Ingrese una observación','maxlength' => '500']); ?>

            </div>
          </div>
        </div>
        <div class="box-footer text-center">
          <a href="javascript:history.back()" role="button" class="btn btn-default pull-left">Volver</a>
          <!--Se utiliza para registrar una observación para el asistente y secretaria -->
          <?php echo Form::button('Imprimir', array('onclick' => 'window.print();', 'name' => 'imprimir', 'class' => 'btn btn-info')); ?>

          <?php echo Form::submit('Guardar', array('class' => 'btn btn-info pull-right')); ?>

        </div>
        <?php echo Form::close(); ?>

      </div>
    </div>     
  </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

  <script type="text/javascript">
    var token                =  "<?php echo e(csrf_token()); ?>";

    $(document).ready(function() {

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