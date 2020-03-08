<?php $__env->startSection('htmlheader_title'); ?>
	<?php echo e(trans('adminlte_lang::message.tratamiento')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  <?php echo e(trans('adminlte_lang::message.tratamiento')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.atencion')); ?></li>
    <li class="active"><?php echo e(trans('adminlte_lang::message.tratamiento')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
  <!-- Este botón sólo será visto por Secretaria y Asistente -->
  <?php if(Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 4): ?>
    <a class="btn btn-default"  href="<?php echo e(url('home')); ?>" role="button">Volver al inicio</a>
  <?php endif; ?>
    <?php if(Auth::user()->perfil_id <= 3): ?>
      <a class="btn btn-success"  href="<?php echo e(url('tratamiento/create')); ?>" role="button">Agregar nuevo tratamiento</a>
    <?php endif; ?>
    <br>
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
                    <?php echo Form::label('nombre_tratamientoB', 'Nombre del tratamiento:' ); ?>

                    <?php echo Form::text('nombre_tratamientoB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del tratamiento', 'maxlength' => '50', 'autocomplete' => 'off']  ); ?>

                </div>
                <div class="form-group col-md-4">
                    <?php echo Form::label('tipoB', 'Tipo de tratamiento:' ); ?>

                    <?php echo Form::select('tipoB', $tipo_tratamientos, null, array('class' => 'form-control', 'placeholder' => 'Seleccione el tipo de tratamiento')); ?>

                </div>
              </div>
              <div class="row">
                  <div class="form-group col-md-4">
                      <?php echo Form::label('rut_pacienteB', 'RUT paciente:' ); ?>

                      <?php echo Form::text('rut_pacienteB', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'pattern' => '^[0-9]{7,8}', 'maxlength' => '8', 'title' => 'Ingrese RUT sin puntos', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off']  ); ?>

                  </div>
                  <div class="form-group col-md-4">
                      <?php echo Form::label('apellido_paterno_pacienteB', 'Apellido paterno del paciente:' ); ?>

                      <?php echo Form::text('apellido_paterno_pacienteB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

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
              Listado de tratamientos
            </div>
            <div class="box-body table-responsive">
              <?php echo Form::open([ 'route' => 'tratamiento.exportExcel', 'method' => 'POST']); ?>

                  <?php echo Form::text('folioExcel', null , ['class' => 'hidden', 'id' => 'folioExcel'] ); ?>

                  <?php echo Form::text('nombreExcel', null , ['class' => 'hidden', 'id' => 'nombreExcel'] ); ?>

                  <?php echo Form::text('tipoExcel', null , ['class' => 'hidden', 'id' => 'tipoExcel'] ); ?>

                  <?php echo Form::text('pacienteExcel', null , ['class' => 'hidden', 'id' => 'pacienteExcel'] ); ?>

                  <?php echo Form::text('rutExcel', null , ['class' => 'hidden', 'id' => 'rutExcel'] ); ?>

                  <?php echo Form::text('apellidoExcel', null , ['class' => 'hidden', 'id' => 'apellidoExcel'] ); ?>

                  <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                      <span class="fa fa-download"></span>
                  </button>
              <?php echo Form::close(); ?>

              <br>
              <table class="table table-bordered table-striped" id="tableTratamiento">
                <thead>
                    <tr>
                        <th class="text-center">N° folio</th>
                        <th class="text-center">Última atención</th>
                        <th class="text-center">Tratamiento</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Paciente</th>
                        <th class="text-center">Número de atenciones</th>
                        <?php if(Auth::user()->perfil_id != 4): ?>
                          <th class="text-center">Valor total</th>
                          <th class="text-center">Deuda</th>
                        <?php endif; ?>
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


    function limpiarSelects() {
        $("#folioB").removeAttr('value');
        $("#nombre_tratamientoB").removeAttr('value');
        $("#tipoB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
        $("#rut_pacienteB").removeAttr('value');
        $("#apellido_paterno_pacienteB").removeAttr('value');
    }
    
    function GuardarValores(){
        var folioExcel = $('#folioB').val();
        var nombreExcel = $('#nombre_tratamientoB').val();
        var tipoExcel = $('#tipoB').val();
        var rutExcel = $('#rut_pacienteB').val();
        var apellidoExcel = $('#apellido_paterno_pacienteB').val();
      
        if(folioExcel != ''){
            $('#folioExcel').val(folioExcel);
        }
      
        if(nombreExcel != ''){
            $('#nombreExcel').val(nombreExcel);
        }

        if(tipoExcel != ''){
            $('#tipoExcel').val(tipoExcel);
        }

        if(rutExcel != ''){
            $('#rutExcel').val(rutExcel);
        }

        if(apellidoExcel != ''){
            $('#apellidoExcel').val(apellidoExcel);
        }
    }

    $(document).ready(function() {
        
        $('#fecha_inicio').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true
        });  
        $('#fecha_fin').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true

        }); 

        var tableTratamiento = $('#tableTratamiento').DataTable({
          processing: true,
          pageLength: 10,
          searching   : false,
          language: {
                      "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                    },
          order: [ 0, "asc" ],
          ajax: {
                url: "tratamiento.getTabla",
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
          columns: [
                    {class : "text-center",
                     data: 'folio'},
                     {class : "text-center",
                     data: 'ultima_fecha'},
                    {class : "text-center",
                     data: 'nombre'},
                    {class : "text-center",
                     data: 'tipo'},
                    {class : "text-center",
                     data: 'paciente'},
                     {class : "text-center",
                     data: 'numero'},                     
                    <?php if(Auth::user()->perfil_id != 4): ?>
                      {class : "text-center",
                       data: 'valor'},
                     {class : "text-center",
                     data: 'deuda'},
                    <?php endif; ?>
                    {class : "text-center",
                     data: 'action', name: 'action', orderable: false, searchable: false}
                    
                ],
          colReorder: true,
        });

        
      });

  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>