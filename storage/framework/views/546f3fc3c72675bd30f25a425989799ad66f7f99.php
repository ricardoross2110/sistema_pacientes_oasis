<?php $__env->startSection('htmlheader_title'); ?>
	Reporte ingresos por periodo
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  Reporte ingresos por periodo
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
  <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
  <li><?php echo e(trans('adminlte_lang::message.reports')); ?></li>
  <li class="active"> Reporte ingresos por periodo</li>
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
            <div class="col-md-6  col-sm-6 col-xs-6">
              <?php echo Form::label('fechadesde', 'Fecha desde:', ['for' => 'fechadesde'] ); ?>

              <?php echo Form::text('fechadesde', $fecha_inicio, ['class' => 'form-control pull-right', 'id' => 'fechadesde', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ); ?>

            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
              <?php echo Form::label('fechahasta', 'Fecha hasta:', ['for' => 'fechahasta'] ); ?>

              <?php echo Form::text('fechahasta', $fecha_fin, ['class' => 'form-control pull-right', 'id' => 'fechahasta', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ); ?>

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
          Gráfico por periodo
        </div>
        <div class="box-body">
          <div class="chart" id="bar-chart1" style="height: 250px;"></div>
        </div>
      </div>
    </div>     
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          Reporte de ingresos por periodo
        </div>
        <div class="box-body table-responsive">
          <?php echo Form::open(['route' => 'reportes.getIngresoPeriodo', 'method' => 'POST']); ?>

          <?php echo Form::text('desdeExcel', null , ['class' => 'hidden', 'id' => 'desdeExcel'] ); ?>

          <?php echo Form::text('hastaExcel', null , ['class' => 'hidden', 'id' => 'hastaExcel'] ); ?>

          <?php echo Form::text('tipo', 'excel' , ['class' => 'hidden', 'id' => 'tipo'] ); ?>

          <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
            <span class="fa fa-download"></span>
          </button>
          <?php echo Form::close(); ?>

          <br>
          <table class="table table-bordered table-striped" id="tablaIngresoPeriodo">
            <thead>
              <tr>
                <th class="text-center">Mes</th>
                <th class="text-center">Año</th>
                <th class="text-center">Ingresos</th>
                <?php $__currentLoopData = $tipopago; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <!-- <th class="text-center"><?php echo e($tipo->nombre); ?></th> -->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

    function limpiarSelects() {
      $("#fechadesde").removeAttr('value');
      $("#fechahasta").removeAttr('value');
    }
    
    function GuardarValores(){
      var desdeExcel   =   $('#fechadesde').val();
      var hastaExcel   =   $('#fechahasta').val();

      if(desdeExcel != ''){
          $('#desdeExcel').val(desdeExcel);
      }
    
      if(hastaExcel != ''){
          $('#hastaExcel').val(hastaExcel);
      }
    }

    $(document).ready(function() {
      var datosGrafico = [];

      $.ajax({
        url: "<?php echo e(url('reportes.getIngresoPeriodo')); ?>",
        data    : { 
          fechadesde : fechadesde,
          fechahasta : fechahasta,
          tipo       : 'grafico',
          "_token"   : token
        },
        type: "POST"
      })
      .done(function(data) {
        console.log(data.ingresopormes);
        var mes = '';

        $.each(JSON.parse(data.ingresopormes), function(index, val) {
          $.each(val, function(index2, val2) {
            if (index2 == "1") {
              mes = 'Enero ' + index;
            }else if (index2 == "2") {
              mes = "Febrero " +  index; 
            }else if (index2 == "3") {
              mes = "Marzo " +  index;
            }else if (index2 == "4") {
              mes = "Abril " +  index;
            }else if (index2 == "5") {
              mes = "Mayo " +  index;
            }else if (index2 == "6") {
              mes = "Junio " +  index;
            }else if (index2 == "7") {
              mes = "Julio " +  index;
            }else if (index2 == "8") {
              mes = "Agosto " +  index;
            }else if (index2 == "9") {
              mes = "Septiembre " +  index;
            }else if (index2 == "10") {
              mes = "Octubre " +  index;
            }else if (index2 == "11") {
              mes = "Noviembre " +  index;
            }else if (index2 == "12") {
              mes = "Diciembre " +  index;
            }
            datosGrafico.push({'mes' : mes, 'ingresos' : val2 });
          });
        });

        if (datosGrafico.length == 0) {
          console.log('aquí');
          var bar = new Morris.Bar({
            element: 'bar-chart1',
            resize: true,
            data: [{'mes' : 'Sin datos', 'ingresos' : 0 }],
            barColors: ['#05B151'],
            xkey: 'mes',
            ykeys: ['ingresos'],
            labels: ['Ingresos'],
            hideHover: 'auto'
          });
        }else{
          var bar = new Morris.Bar({
            element: 'bar-chart1',
            resize: true,
            data: datosGrafico,
            barColors: ['#05B151'],
            xkey: 'mes',
            ykeys: ['ingresos'],
            labels: ['Ingresos'],
            hideHover: 'auto'
          });
        }
      })
      .fail(function(data) {
        console.log(data);
      });
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

      $('#tablaIngresoPeriodo').DataTable({
        processing: true,
        pageLength: 10,
        paginate: true,
        searching   : false,
        language: {
                    "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                  },
        order: [[ 1, "desc" ], [ 0, "desc" ] ],
        columnDefs: [
           { type: 'date-range', targets: 0 }
        ],
        ajax: {
            url: "reportes.getIngresoPeriodo",
            type: "POST",
            data    : { 
              fechadesde : fechadesde,
              fechahasta : fechahasta,
              tipo       : 'table',
              "_token"   : token
            },
            type: "POST",
            dataType: "json"
        },
        columns: [
          {class : "text-center",
           data: 'mes'},
          {class : "text-center",
           data: 'year'},
          {class : "text-center",
           data: 'ingreso'},
          <?php $__currentLoopData = $tipopago; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            /*{class : "text-center",
             data: '<?php echo e('tipo_pago_'.$tipo->id); ?>'},*/
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ],
        colReorder: true,
      });
    });

  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>