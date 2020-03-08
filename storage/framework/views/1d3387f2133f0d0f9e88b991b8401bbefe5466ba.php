<?php $__env->startSection('htmlheader_title'); ?>
	Detalle tratamiento
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  Detalle tratamiento
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
    <li><a href="javascript:history.back()"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.atencion')); ?></li>
    <li class="active">Detalle tratamiento</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    <a class="btn btn-default"  href="javascript:history.back()" role="button">Volver</a>

    <?php if(Auth::user()->perfil_id <= 3): ?>
      <a class="btn btn-success"  href="<?php echo e(url('/RegistrarAtencion/'.$tratamiento->folio)); ?>" role="button">Registrar atención</a>
      <a class="btn btn-info"  href="<?php echo e(url('/RegistrarReserva/'.$tratamiento->folio)); ?>" role="button">Realizar reserva</a>
    <?php endif; ?>
    <br>
    <br>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
       <div class="box box-info">
          <div class="box-header">
            Búsqueda
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <?php echo Form::label('n_folio', 'N° folio:', ['for' => 'n_folio'] ); ?>

                <?php echo Form::text('n_folio', $tratamiento->folio , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxLenght' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ); ?>

              </div>
              <div class="col-md-3">
                <?php echo Form::label('tratamiento', 'Tratamiento:', ['for' => 'tratamiento'] ); ?>

                <?php echo Form::text('tratamiento', $tratamiento->nombre , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el apellido paterno', 'maxlength' => '50']  ); ?>

              </div>
              <div class="col-md-3">
                <?php echo Form::label('paciente', 'Nombre paciente:', ['for' => 'paciente'] ); ?>

                <?php echo Form::text('paciente', $paciente , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre paciente', 'maxlength' => '50']  ); ?>

              </div>
              <div class="col-md-3">
                <?php echo Form::label('total', 'Tipo de tratamiento:', ['for' => 'total'] ); ?>

                <?php echo Form::text('total', $tipo_tratamiento->nombre , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingresa el monto total', 'maxlength' => '50']  ); ?>

              </div>
            </div>
            <br>
            <div class="row">
              <?php if(Auth::user()->perfil_id != 4): ?>
                <div class="col-md-3">
                  <?php echo Form::label('total', 'Valor total:', ['for' => 'total'] ); ?>

                  <?php echo Form::text('total', '$ '.$tratamiento->valor , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingresa el monto total', 'maxlength' => '50']  ); ?>

                </div>
              <?php endif; ?>
              <div class="col-md-3">
                <?php echo Form::label('controles', 'Controles:', ['for' => 'controles'] ); ?>

                <?php echo Form::text('controles', $tratamiento->num_control , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ); ?>

              </div>
              <?php if(Auth::user()->perfil_id != 4): ?>
                <div class="col-md-3">
                  <?php echo Form::label('pagado', 'Abono:' ); ?>

                  <?php echo Form::text('pagado', '$ '.$tratamiento->pagado , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingresa el monto pagado', 'maxlength' => '50']  ); ?>

                </div>
                <?php if($tratamiento->estado_deuda == "debe"): ?>
                  <div class="form-group has-error col-md-3">
                    <?php echo Form::label('deuda', 'Deuda:' ); ?>

                    <?php echo Form::text('deuda', '$ '.$tratamiento->deuda , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingresa el monto de deuda', 'maxlength' => '50']  ); ?>

                  </div>
                <?php else: ?>
                  <div class="form-group has-success col-md-3">
                    <?php echo Form::label('deuda', 'Deuda:' ); ?>

                    <?php echo Form::text('deuda', '$ '.$tratamiento->deuda , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingresa el monto de deuda', 'maxlength' => '50']  ); ?>

                  </div>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
          </div>
        </div>
      </div>     

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            Detalle de atenciones
          </div>
          <div class="box-body table-responsive">
            <?php echo Form::open([ 'route' => 'tratamiento.exportAtencionesExcel', 'method' => 'POST']); ?>

              <?php echo Form::text('folioExcel', null , ['class' => 'hidden', 'id' => 'folioExcel'] ); ?>

              <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                  <span class="fa fa-download"></span>
              </button>
            <?php echo Form::close(); ?>

            <br>
            <table class="table table-bordered table-striped" id="tableTratamiento">
              <thead>
                  <tr>
                      <th class="text-center">N° control</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Hora</th>
                      <th class="text-center">Profesional</th>                 
                      <?php if(Auth::user()->perfil_id != 4): ?>
                        <th class="text-center">Abono</th>
                      <?php endif; ?>
                      <th class="text-center">Acciones</th>
                  </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
          <div class="box-footer">
            <a href="javascript:history.back()" role="button" class="btn btn-default pull-left">Volver</a>
          </div>
        </div>
      </div>     
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token   =  "<?php echo e(csrf_token()); ?>";
    var folio   =  $('#n_folio').val();

    function GuardarValores(){
      var folioExcel = folio;

    
      if(folioExcel != ''){
          $('#folioExcel').val(folioExcel);
      }
    
    }
        
    $(document).ready(function() {
        
        $('#fechadesdeChrome').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true
        });  
        $('#fechahastaChrome').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true
        });   

        $('#tableTratamiento').DataTable({
          processing: true,
          pageLength: 10,
          searching   : false,
          language: {
                      "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                    },
          order: [ 0, "asc" ],
          ajax: {
              url: "<?php echo e(url('tratamiento.getTableAtenciones')); ?>",
              type: "POST",
              data:{
                      folio     : folio,
                      "_token" : token,                     
                    },
          },
          columns: [
                  {class : "text-center",
                   data: 'num_atencion'},
                  {class : "text-center",
                   data: 'fecha'},
                  {class : "text-center",
                   data: 'hora'},
                  {class : "text-center",
                   data: 'profesional'},
                  <?php if(Auth::user()->perfil_id != 4): ?>
                    {class : "text-center",
                     data: 'abono'},
                  <?php endif; ?>
                  {class : "text-center",
                   data: 'action'}
              ],
          colReorder: true,
        });
    });
  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>