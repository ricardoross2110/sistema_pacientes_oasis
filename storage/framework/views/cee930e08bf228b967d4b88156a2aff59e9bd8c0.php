<?php $__env->startSection('htmlheader_title'); ?>
	Reporte atenciones por secretaria
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  Reporte atenciones por secretaria
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
  <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
  <li><?php echo e(trans('adminlte_lang::message.reports')); ?></li>
  <li class="active">Reporte atenciones por secretaria</li>
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
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              <?php echo Form::label('secretariaB', 'Secretaria:', ['for' => 'secretariaB'] ); ?>

              <?php echo Form::select('secretariaB[]', $secretarias, null, array('class' => 'form-control secretariab', 'multiple', 'data-placeholder' => 'Seleccione secretaria')); ?>

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
          Gráfico por secretaria
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
          Reporte de atenciones por secretaria
        </div>
        <div class="box-body table-responsive">
          <?php echo Form::open(['route' => 'reportes.getAtencionSecretaria', 'method' => 'POST']); ?>

          <?php echo Form::text('desdeExcel', null , ['class' => 'hidden', 'id' => 'desdeExcel'] ); ?>

          <?php echo Form::text('hastaExcel', null , ['class' => 'hidden', 'id' => 'hastaExcel'] ); ?>

          <?php echo Form::text('secretariaExcel', null , ['class' => 'hidden', 'id' => 'secretariaExcel'] ); ?>

          <?php echo Form::text('tipo', 'excel' , ['class' => 'hidden', 'id' => 'tipo'] ); ?>

          <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
              <span class="fa fa-download"></span>
          </button>
          <?php echo Form::close(); ?>

          <br>
          <table class="table table-bordered table-striped" id="tablaAtencionSecretaria">
            <thead>
                <tr>
                  <th class="text-center">Secretaria</th>
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
    var secretariab          = [];

    $('.secretaria').select2();
    $('.secretariab').select2();

    <?php if(isset($secretariaB)): ?>
      <?php $__currentLoopData = $secretariaB; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $secretaria_b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        secretariab.push(<?php echo e($secretaria_b); ?>);
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    function limpiarSelects() {
      secretariab = [];
      $("#fechadesde").removeAttr('value');
      $("#fechahasta").removeAttr('value');
      var secretaria_select      =   $('.secretariab');
      secretaria_select.empty().trigger("change");
      cargarSelectSecretaria();
    }

    function cargarSelects() {
      cargarSelectSecretaria();
    }

    function cargarSelectSecretaria() {
      var secretaria_select      =   $('.secretariab');
      secretaria_select.empty().trigger("change");

      $.ajax({
        type    : 'POST',
        url     : "<?php echo e(url('usuario.cargarSecretarias')); ?>",
        data    : {
                    "_token"   : token,
                  },
        dataType: 'json'
      })
      .done(function(data) {
        $.each(data.secretarias, function(index, val) {
          if (secretariab.includes(val) === true) {
              var option = new Option(index, val, true, true);
          }else{
              var option = new Option(index, val, false, false);
          }
          secretaria_select.append(option).trigger('change');
        });
      })
      .fail(function() {
          console.log("error");
      });
    }

    function GuardarValores(){
      var desdeExcel   =   $('#fechadesde').val();
      var hastaExcel   =   $('#fechahasta').val();
      var secretariasExcel = [];

      $.each($(".secretariab option:selected"), function(){            
        secretariasExcel.push($(this).val());
      });

      secretariasExcel     =   JSON.stringify(secretariasExcel);

      if(desdeExcel != ''){
          $('#desdeExcel').val(desdeExcel);
      }
    
      if(hastaExcel != ''){
          $('#hastaExcel').val(hastaExcel);
      }

      $('#secretariaExcel').val(secretariasExcel);
    }
    
    $(document).ready(function() {
      cargarSelects();
      var secretaria_select      =   $('.secretariab');
      secretaria_select.val(null).trigger("change");      
      var datosGrafico = [];

      $.ajax({
        url: "<?php echo e(url('reportes.getAtencionSecretaria')); ?>",
        data    : { 
          fechadesde  : fechadesde,
          fechahasta  : fechahasta,
          secretaria  : secretariab,
          tipo        : 'grafico',
          "_token"    : token
        },
        type: "POST"
      })
      .done(function(data) {
        $.each(JSON.parse(data.secretarias), function(index, val) {
           datosGrafico.push({'secretaria' : index, 'atenciones' : val });
        });

        if (datosGrafico.length == 0) {
          var bar = new Morris.Bar({
            element: 'bar-chart1',
            resize: true,
            data: [{'secretaria' : 'Sin datos', 'atenciones' : 0 }],
            barColors: ['#05B151'],
            xkey: 'secretaria',
            ykeys: ['atenciones'],
            labels: ['Atenciones'],
            hideHover: 'auto'
          });
        }else{
          var bar = new Morris.Bar({
            element: 'bar-chart1',
            resize: true,
            data: datosGrafico,
            barColors: ['#416BAF'],
            xkey: 'secretaria',
            ykeys: ['atenciones'],
            labels: ['Atenciones'],
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

      $('#tablaAtencionSecretaria').DataTable({
        processing: true,
        pageLength: 10,
        searching   : false,
        language: {
                    "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                  },
        order: [[ 0, "asc" ]],
        ajax: {
            url: "reportes.getAtencionSecretaria",
            type: "POST",
            data    : { 
              fechadesde  : fechadesde,
              fechahasta  : fechahasta,
              secretaria  : secretariab,
              tipo        : 'table',
              "_token"    : token
            },
            type: "POST",
            dataType: "json"
        },
        columns: [
          {class : "text-center",
           data: 'secretaria'},
          {class : "text-center",
           data: 'atenciones'},
        ],
        colReorder: true,
      });
    });

  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>