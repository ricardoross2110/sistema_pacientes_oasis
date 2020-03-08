<?php $__env->startSection('htmlheader_title'); ?>
	Reporte atenciones por paciente
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  Reporte atenciones por paciente
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
  <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
  <li><?php echo e(trans('adminlte_lang::message.reports')); ?></li>
  <li class="active">Reporte atenciones por paciente</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
 
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
     <div class="box box-info">
        <div class="box-header">
          Búsqueda
        </div>
        <?php echo e(Form::open(array('method' => 'GET'))); ?>

        <div class="box-body">
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <?php echo Form::label('fechadesde', 'Fecha desde:', ['for' => 'fechadesde'] ); ?>

                <?php echo Form::text('fechadesde', $fecha_inicio, ['class' => 'form-control pull-right', 'id' => 'fechadesde', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ); ?>

            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <?php echo Form::label('fechahasta', 'Fecha hasta:', ['for' => 'fechahasta'] ); ?>

                <?php echo Form::text('fechahasta', $fecha_fin , ['class' => 'form-control pull-right', 'id' => 'fechahasta', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ); ?>

            </div>
          </div>
        </div>
        <div class="box-footer">
            <?php echo Form::reset('Limpiar', array('onClick' => 'limpiarSelects()', 'class' => 'btn btn-default')); ?>

            <?php echo Form::submit('Buscar', array('class' => 'btn btn-info')); ?>

          </div>
        <?php echo e(Form::close()); ?>

      </div>
    </div>     
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          Reporte de atenciones por paciente
        </div>
        <div class="box-body table-responsive">
          <?php echo Form::open(['route' => 'reportes.getAtencionPaciente', 'method' => 'POST']); ?>

            <?php echo Form::text('desdeExcel', null , ['class' => 'hidden', 'id' => 'desdeExcel'] ); ?>

            <?php echo Form::text('hastaExcel', null , ['class' => 'hidden', 'id' => 'hastaExcel'] ); ?>

            <?php echo Form::text('pacienteExcel', null , ['class' => 'hidden', 'id' => 'pacienteExcel'] ); ?>

            <?php echo Form::text('tipo', 'excel' , ['class' => 'hidden', 'id' => 'tipo'] ); ?>

            <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                <span class="fa fa-download"></span>
            </button>
            <br>
          <?php echo Form::close(); ?>

          <br>
          <br>
          <table class="table table-bordered table-striped" id="tablaAtencionPaciente">
            <thead>
                <tr>
                  <th class="text-center">Paciente</th>
                  <th class="text-center">Número de atenciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>     
  </div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

  <script type="text/javascript">
  
    var token                =  "<?php echo e(csrf_token()); ?>";
    var fechadesde           = $('#fechadesde').val();
    var fechahasta           = $('#fechahasta').val();
    var pacienteb            = [];

    function limpiarSelects() {
      $("#fechadesde").removeAttr('value');
      $("#fechahasta").removeAttr('value');
    }


    function GuardarValores(){
      var desdeExcel   =   $('#fechadesde').val();
      var hastaExcel   =   $('#fechahasta').val();
      var pacientesExcel = [];

      $.each($(".pacienteb option:selected"), function(){            
          pacientesExcel.push($(this).val());
      });

      pacientesExcel     =   JSON.stringify(pacientesExcel);

      if(desdeExcel != ''){
          $('#desdeExcel').val(desdeExcel);
      }
    
      if(hastaExcel != ''){
          $('#hastaExcel').val(hastaExcel);
      }

      $('#pacienteExcel').val(pacientesExcel);
    }
    
    $(document).ready(function() {

        $('#fechadesde').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            //hora_inicioDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });

        $('#fechahasta').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            //hora_inicioDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });   

        $('#tablaAtencionPaciente').DataTable({
            processing: true,
            pageLength: 10,
            searching   : true,
            language: {
                        "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                    },
            order: [ 1, "DESC"],
            ajax: {
                url: "reportes.getAtencionPaciente",
                type: "POST",
                data    : { 
                  fechadesde  : fechadesde,
                  fechahasta  : fechahasta,
                  paciente    : pacienteb,
                  tipo        : 'table',
                  "_token"    : token
                },
                type: "POST",
                dataType: "json"
            },
            columns: [
            {class : "text-center",
            data: 'paciente'},
            {class : "text-center",
            data: 'atenciones_realizadas'},
            ],
            colReorder: true,
        });
    });

  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>