<?php $__env->startSection('htmlheader_title'); ?>
	Historial
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  Historial
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.atencion')); ?></li>
    <li class="active"><?php echo e(trans('adminlte_lang::message.historial')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    <br>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Búsqueda</h3>
                </div>
                <?php echo e(Form::open(array('method' => 'GET'))); ?>

                    <div class="box-body">
                        <div class="row">
                          <div class="form-group col-md-4">
                              <?php echo Form::label('folioB', 'N° de Folio:' ); ?>

                              <?php echo Form::text('folioB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off'] ); ?>

                          </div>
                          <div class="form-group col-md-4">
                              <?php echo Form::label('nombre_tratamientoB', 'Nombre tratamiento:' ); ?>

                              <?php echo Form::text('nombre_tratamientoB', null , ['class' => 'form-control', 'placeholder' => 'Escribe el nombre del tratamiento', 'maxlength' => '50', 'autocomplete' => 'off']  ); ?>

                          </div>
                          <div class="form-group col-md-4">
                              <?php echo Form::label('tipoB', 'Tipo:' ); ?>

                              <?php echo Form::select('tipoB', $tipo_tratamientos, null, array('class' => 'form-control', 'placeholder' => 'Seleccione el tipo de tratamiento')); ?>

                          </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <?php echo Form::label('rut_pacienteB', 'Rut paciente:' ); ?>

                                <?php echo Form::text('rut_pacienteB', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'pattern' => '^[0-9]{7,8}', 'maxlength' => '8', 'title' => 'Ingrese RUT sin puntos', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off']  ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('apellido_paterno_pacienteB', 'Apellido paterno del paciente:' ); ?>

                                <?php echo Form::text('apellido_paterno_pacienteB', null , ['class' => 'form-control', 'placeholder' => 'Escribe el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off']  ); ?>

                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php echo Form::reset('Limpiar', array('onClick'=> 'limpiarSelects()', 'class' => 'btn btn-default')); ?>

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
              Historial de atenciones
            </div>
            <div class="box-body table-responsive">

              <?php echo Form::open(['route' => 'exportExcelHistorial', 'method' => 'POST']); ?>

                  <?php echo Form::text('folioExcel', null , ['class' => 'hidden', 'id' => 'folioExcel'] ); ?>

                  <?php echo Form::text('nombre_tratamientoExcel', null , ['class' => 'hidden', 'id' => 'nombre_tratamientoExcel'] ); ?>

                  <?php echo Form::text('tipoExcel', null , ['class' => 'hidden', 'id' => 'tipoExcel'] ); ?>

                  <?php echo Form::text('folioExcel', null , ['class' => 'hidden', 'id' => 'folioExcel'] ); ?>

                  <?php echo Form::text('rut_pacienteExcel', null , ['class' => 'hidden', 'id' => 'rut_pacienteExcel'] ); ?>

                  <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                      <span class="fa fa-download"></span>
                  </button>
              <?php echo Form::close(); ?>

              <br>
              <table class="table table-bordered table-striped" id="TablaHistorial">
                <thead>
                    <tr>
                        <th></th>
                        <th class="text-center">N° Tratamiento</th>
                        <th class="text-center">Tratamiento</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">N° controles</th>
                        <th class="text-center">Paciente</th>
                        <th class="text-center">Precio total</th>
                        <th class="text-center">Deuda</th>
                        <th class="text-center">Acciones</th>
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

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token               =  "<?php echo e(csrf_token()); ?>";
    var folio               =  $('#folioB').val();
    var nombre_tratamiento  =  $('#nombre_tratamientoB').val();
    var tipo                =  $('#tipoB').val();
    var rut_paciente        =  $('#rut_pacienteB').val();
    var apellido_paterno    =  $('#apellido_paterno_pacienteB').val();

    function GuardarValores(){
      var folioExcel                =  $('#folioB').val();
      var nombre_tratamientoExcel   =  $('#nombre_tratamientoB').val();
      var tipoExcel                 =  $('#tipoB').val();
      var rut_pacienteExcel         =  $('#rut_pacienteB').val();
      var apellido_paternoExcel     =  $('#apellido_paterno_pacienteB').val();

      if(folioExcel != ''){
          $('#folioExcel').val(folioExcel);
      }
    
      if(nombre_tratamientoExcel != ''){
          $('#nombre_tratamientoExcel').val(nombre_tratamientoExcel);
      }

      if(tipoExcel != ''){
          $('#tipoExcel').val(tipoExcel);
      }

      if(rut_pacienteExcel != ''){
          $('#rut_pacienteExcel').val(rut_pacienteExcel);
      }

      if(apellido_paternoExcel != ''){
          $('#apellido_paternoExcel').val(apellido_paternoExcel);
      }
    }

    function limpiarSelects() {
        $("#folioB").removeAttr('value');
        $("#nombre_tratamientoB").removeAttr('value');
        $("#tipoB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
        $("#rut_pacienteB").removeAttr('value');
        $("#apellido_paterno_pacienteB").removeAttr('value');
    }

    $(document).ready(function() {
        
        $('#fechadesdeChrome').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            //hora_inicioDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });  
        $('#fechahastaChrome').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            //hora_inicioDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });   

      var table = $('#TablaHistorial').DataTable({
        processing: true,
        pageLength: 10,
        searching   : false,
        language: {
                    "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                  },
        ajax: {
                url: "<?php echo e(url('/atencion.getTablaHistorial')); ?>",
                type: "POST",
                data:{
                        folio               : folio,
                        nombre_tratamiento  : nombre_tratamiento,
                        tipo                : tipo,
                        rut_paciente        : rut_paciente,
                        apellido_paterno    : apellido_paterno,
                        "_token"  : token,                     
                    },
            },
        order: [ 1, "desc" ],
        columns: [
                  {
                    "className":      'details-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                  },
                  {
                    class : "text-center",
                    data: 'folio'},
                   {class : "text-center",
                   data: 'nombre'},
                   {class : "text-center",
                   data: 'tipo'},
                   {class : "text-center",
                   data: 'num_control'},
                   {class : "text-center",
                   data: 'paciente'},
                   {class : "text-center",
                   data: 'total'},
                   {class : "text-center",
                   data: 'deuda'},
                   {class : "text-center",
                 data: 'action', name: 'action', orderable: false, searchable: false}
              ],
        colReorder: true,
      });

      // Add event listener for opening and closing details
      $('#TablaHistorial tbody').on('click', 'td.details-control', function () {
          var tr = $(this).closest('tr');
          var row = table.row( tr);
   
          if ( row.child.isShown() ) {
              row.child.hide();
              tr.removeClass('shown');
          }else {
            row.child('<table class="table table-bordered table-striped" id="tablaAtenciones_' + row.data().folio + '">' +
                '<thead>' +
                    '<tr>' +
                        '<th class="text-center">N° control</th>' +
                        '<th class="text-center">Fecha</th>' +
                        '<th class="text-center">Hora</th>' +
                        '<th class="text-center">Profesional</th>' +
                        '<th class="text-center">Sucursal</th>' +
                        '<th class="text-center">Abono</th>' +
                        '<th class="text-center">Acciones</th>' +
                    '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
              '</table>').show();

            var folio = row.data().folio;

            $('#tablaAtenciones_' + row.data().folio + '').DataTable({
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
                          table     : 'historial',
                          "_token"  : token,                     
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
                      {class : "text-center",
                       data: 'sucursal'},
                      {class : "text-center",
                       data: 'abono'},
                      {class : "text-center",
                       data: 'action'}
                  ],
              colReorder: true,
            });
            tr.addClass('shown');
          }
      } );
    });
  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>