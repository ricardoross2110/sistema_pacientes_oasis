<?php $__env->startSection('htmlheader_title'); ?>
	Reporte ingresos por sucursal
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  Reporte ingresos por sucursal
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
  <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
  <li><?php echo e(trans('adminlte_lang::message.reports')); ?></li>
  <li class="active"> Reporte ingresos por sucursal</li>
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
          <div class="row">
            <div class="form-group col-md-4 col-sm-12 col-xs-12">
              <?php echo Form::label('sucursalB', 'Sucursal:', ['for' => 'sucursalB'] ); ?>

              <?php echo Form::select('sucursalB[]', $sucursales, null, array('class' => 'form-control sucursalb', 'multiple', 'data-placeholder' => 'Seleccione sucursal')); ?>

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
          Gráfico por sucursal
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
          Reporte de ingresos por sucursal
        </div>
        <div class="box-body table-responsive">
          <?php echo Form::open(['route' => 'reportes.getIngresoSucursal', 'method' => 'POST']); ?>

          <?php echo Form::text('desdeExcel', null , ['class' => 'hidden', 'id' => 'desdeExcel'] ); ?>

          <?php echo Form::text('hastaExcel', null , ['class' => 'hidden', 'id' => 'hastaExcel'] ); ?>

          <?php echo Form::text('sucursalExcel', null , ['class' => 'hidden', 'id' => 'sucursalExcel'] ); ?>

          <?php echo Form::text('tipo', 'excel' , ['class' => 'hidden', 'id' => 'tipo'] ); ?>

          <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
            <span class="fa fa-download"></span>
          </button>
          <?php echo Form::close(); ?>

          <br>
          <table class="table table-bordered table-striped" id="tablaIngresoSucursal">
            <thead>
              <tr>
                <th class="text-center">Sucursal</th>
                <th class="text-center">Ingresos</th>
                <?php $__currentLoopData = $tipopago; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <th class="text-center"><?php echo e($tipo->nombre); ?></th>
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
    var sucursalb           = [];

    $('.sucursal').select2();
    $('.sucursalb').select2();

    <?php if(isset($sucursalB)): ?>
      <?php $__currentLoopData = $sucursalB; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sucursal_b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        sucursalb.push(<?php echo e($sucursal_b); ?>);
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    function limpiarSelects() {
      sucursalb = [];
      $("#fechadesde").removeAttr('value');
      $("#fechahasta").removeAttr('value');
      var sucursal_select      =   $('.sucursalb');
      sucursal_select.empty().trigger("change");
      cargarSelectSucursal();
    }

    function cargarSelects() {
      cargarSelectSucursal();
    }

    function cargarSelectSucursal() {
      var sucursal_select      =   $('.sucursalb');
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
          console.log(sucursalb);
          console.log(index);
          console.log(val);
          console.log(sucursalb.includes(val));
          if (sucursalb.includes(val) === true) {
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

    function GuardarValores(){
      var desdeExcel   =   $('#fechadesde').val();
      var hastaExcel   =   $('#fechahasta').val();
      var sucursalesExcel =   [];

      $.each($(".sucursalb option:selected"), function(){            
          sucursalesExcel.push($(this).val());
      });

      sucursalesExcel     =   JSON.stringify(sucursalesExcel);

      if(desdeExcel != ''){
          $('#desdeExcel').val(desdeExcel);
      }
    
      if(hastaExcel != ''){
          $('#hastaExcel').val(hastaExcel);
      }

      $('#sucursalExcel').val(sucursalesExcel);
    }

    $(document).ready(function() {
      cargarSelects();
      var sucursal_select      =   $('.sucursal');
      sucursal_select.val(null).trigger("change");
      var datosGrafico = [];

      $.ajax({
        url: "<?php echo e(url('reportes.getIngresoSucursal')); ?>",
        data    : { 
          fechadesde : fechadesde,
          fechahasta : fechahasta,
          sucursal   : sucursalb,
          tipo       : 'grafico',
          "_token"   : token
        },
        type: "POST"
      })
      .done(function(data) {
        console.log(data.sucursales); 
         
        $.each(JSON.parse(data.sucursales), function(index, val) {
            if(val == null){
                datosGrafico.push({label : index, value : 0 });
            }else{
                datosGrafico.push({label : index, value : val });
            }
        });
        
        if (datosGrafico.length == 0) {
          var bar2 = new Morris.Donut({
            element: 'bar-chart1',
            resize: true,
            colors: ["#416BAF", "#05B151", "#2A9092", "#FFFF00"],
            data: [{label : 'Sin datos', value : 0 }],
            hideHover: 'auto'
          });
        }else{
          var bar2 = new Morris.Donut({
            element: 'bar-chart1',
            resize: true,
            colors: ["#416BAF", "#05B151", "#2A9092", "#FFFF00"],
            data: datosGrafico,
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

      $('#tablaIngresoSucursal').DataTable({
        processing: true,
        pageLength: 10,
        searching   : false,
        language: {
                    "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                  },
        order: [[ 0, "desc" ]],
        ajax: {
            url: "reportes.getIngresoSucursal",
            type: "POST",
            data    : {
              fechadesde : fechadesde,
              fechahasta : fechahasta,
              sucursal   : sucursalb,
              tipo       : 'table',
              "_token"   : token
            },
            type: "POST",
            dataType: "json"
        },
        columns: [
          {class : "text-center",
           data: 'sucursal'},
          {class : "text-center",
           data: 'ingreso'},
          <?php $__currentLoopData = $tipopago; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            {class : "text-center",
             data: '<?php echo e('tipo_pago_'.$tipo->id); ?>'},
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ],
        colReorder: true,
      });
    });

  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>