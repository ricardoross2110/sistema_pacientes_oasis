<?php $__env->startSection('htmlheader_title'); ?>
	<?php echo e(trans('adminlte_lang::message.reserva')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  <?php echo e(trans('adminlte_lang::message.reserva')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li class="active"><?php echo e(trans('adminlte_lang::message.reserva')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
  <!-- Este botón sólo será visto por Secretaria y Asistente -->
  <?php if(Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 4): ?>
    <a class="btn btn-default"  href="<?php echo e(url('home')); ?>" role="button">Volver al inicio</a>
  <?php endif; ?>
    
    <a class="btn btn-success"  href="<?php echo e(url('/RegistrarReserva/')); ?>" role="button">Agregar reserva</a>
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
                    <?php echo Form::label('rut_pacienteB', 'RUT paciente:' ); ?>

                    <?php echo Form::text('rut_pacienteB', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'pattern' => '^[0-9]{7,8}', 'maxlength' => '8', 'title' => 'Ingrese RUT sin puntos', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off']  ); ?>

                  </div>
                  <div class="form-group col-md-4">
                    <?php echo Form::label('apellido_paterno_pacienteB', 'Apellido paterno del paciente:' ); ?>

                    <?php echo Form::text('apellido_paterno_pacienteB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                  </div>
                  <?php if(Auth::user()->perfil_id <= 2): ?>
                    <div class="form-group col-md-2">
                      <?php echo Form::label('fechaB', 'Fecha:' ); ?>

                      <?php echo Form::text('fechaB', null, ['class' => 'form-control pull-right', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ); ?>

                    </div>
                    <div class="form-group col-md-2">
                      <?php echo Form::label('sucursalB', 'Sucursal:' ); ?>

                      <?php echo Form::select('sucursalB', $sucursal, null, array('class' => 'form-control', 'placeholder' => 'Seleccione sucursal')); ?>

                    </div>
                  <?php else: ?>
                    <div class="form-group col-md-4">
                      <?php echo Form::label('fechaB', 'Fecha:' ); ?>

                      <?php echo Form::text('fechaB', null, ['class' => 'form-control pull-right', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ); ?>

                    </div>
                  <?php endif; ?>
              </div>
              <div class="row">
                <div class="form-group col-md-3">
                  <?php echo Form::label('rut_profesionalB', 'Rut Profesional:', ['for' => 'rut_profesionalB'] ); ?>

                  <?php echo Form::text('rut_profesionalB', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678' , 'pattern' => '^[0-9]{7,8}', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'autocomplete' => 'off']  ); ?>

                </div>
                <div class="form-group col-md-3">
                  <?php echo Form::label('nombres_profesionalB', 'Nombre profesional:', ['for' => 'nombres_profesionalB'] ); ?>

                  <?php echo Form::text('nombres_profesionalB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese nombres del profesional', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                </div>
                <div class="form-group col-md-3">
                  <?php echo Form::label('apellido_paterno_profesionalB', 'Apellido paterno profesional:', ['for' => 'apellido_paterno_profesionalB'] ); ?>

                  <?php echo Form::text('apellido_paterno_profesionalB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                </div>
                <div class="form-group col-md-3">
                  <?php echo Form::label('apellido_materno_profesionalB', 'Apellido materno profesional:', ['for' => 'apellido_materno_profesionalB'] ); ?>

                  <?php echo Form::text('apellido_materno_profesionalB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido materno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

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
      <div class="col-md-6">
         <div class="box box-info">
          <div class="box-header text-center">
            <h3 class="box-title">Calendario</h3>
            <br>
          </div>
          <div class="box-body no-padding">
            <div class="row text-center">
              <?php if(Auth::user()->perfil_id <= 2): ?>
                <?php $__currentLoopData = $sucursales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-md-3">
                    <span class="fa fa-circle" style="color: <?php echo e($s->color); ?>"></span> <label><?php echo e($s->nombre); ?></label> 
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <?php echo $calendar->calendar(); ?>

              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <div class="box box-info">
          <div class="box-header text-center">
            <h3 class="box-title">Listado de reservas</h3>
            <br>
          </div>
          <div class="box-body table-responsive">
            <?php echo Form::open([ 'route' => 'reservas.exportExcel', 'method' => 'POST']); ?>

              <?php echo Form::text('rut_pacienteE', null , ['class' => 'hidden', 'id' => 'rut_pacienteE'] ); ?>

              <?php echo Form::text('apellido_paternoE', null , ['class' => 'hidden', 'id' => 'apellido_paternoE'] ); ?>

              <?php echo Form::text('rut_profesionalE', null , ['class' => 'hidden', 'id' => 'rut_profesionalE'] ); ?>

              <?php echo Form::text('nombres_profesionalE', null , ['class' => 'hidden', 'id' => 'nombres_profesionalE'] ); ?>

              <?php echo Form::text('apellido_materno_profesionalE', null , ['class' => 'hidden', 'id' => 'apellido_materno_profesionalE'] ); ?>

              <?php echo Form::text('apellido_paterno_profesionalE', null , ['class' => 'hidden', 'id' => 'apellido_paterno_profesionalE'] ); ?>

              <?php echo Form::text('fechaE', null , ['class' => 'hidden', 'id' => 'fechaE'] ); ?>

              <?php if(Auth::user()->perfil_id <= 2): ?>
                <?php echo Form::text('sucursalE', null , ['class' => 'hidden', 'id' => 'sucursalE'] ); ?>

              <?php endif; ?>
              <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                  <span class="fa fa-download"></span>
              </button>
            <?php echo Form::close(); ?>

            <br>
            <table class="table table-bordered table-striped" id="tableTratamiento">
              <thead>
                <tr>
                  <th class="text-center">Rut Paciente</th>
                  <th class="text-center">Paciente</th>
                  <th class="text-center">Fecha</th>
                  <th class="text-center">Hora</th>       
                  <th class="text-center">Rut Profesional</th>
                  <th class="text-center">Profesional</th>
                  <th class="text-center">Sucursal</th>        
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

  <?php echo $calendar->script(); ?>


  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token               =  "<?php echo e(csrf_token()); ?>";
    var paciente_rut        =  $('#rut_pacienteB').val();
    var apellido_paterno    =  $('#apellido_paterno_pacienteB').val();
    var fecha               =  $('#fechaB').val();

    <?php if(Auth::user()->perfil_id <= 2): ?>
     var sucursal_id         =  $('#sucursalB').val();
    <?php endif; ?>

    var profesional_rut     =  $('#rut_profesionalB').val();
    var apellido_paternop   =  $('#apellido_paterno_profesionalB').val();

    function limpiarSelects() {
      $("#folioB").removeAttr('value');
      $("#nombre_tratamientoB").removeAttr('value');
      $("#tipoB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
      $("#rut_pacienteB").removeAttr('value');
      $("#apellido_paterno_pacienteB").removeAttr('value');
    }
    
    function GuardarValores(){
      var rut_pacienteE      =  $('#rut_pacienteB').val();
      var apellido_paternoE  =  $('#apellido_paterno_pacienteB').val();
      var rut_profesionalE   =  $('#rut_profesionalB').val();
      var nombrespE          =  $('#nombres_profesionalB').val();
      var apellido_paternopE =  $('#apellido_paterno_profesionalB').val();
      var apellido_maternopE =  $('#apellido_materno_profesionalB').val();
      var fechaE             =  $('#fechaB').val();
      
      if(rut_pacienteE != ''){
        $('#rut_pacienteE').val(rut_pacienteE);
      }
    
      if(apellido_paternoE != ''){
        $('#apellido_paternoE').val(apellido_paternoE);
      }

      if(rut_profesionalE != ''){
        $('#rut_profesionalE').val(rut_profesionalE);
      }
    
      if(nombrespE != ''){
        $('#nombres_profesionalE').val(nombrespE);
      }
    
      if(apellido_paternopE != ''){
        $('#apellido_paterno_profesionalE').val(apellido_paternopE);
      }
    
      if(apellido_maternopE != ''){
        $('#apellido_materno_profesionalE').val(apellido_maternopE);
      }

      <?php if(Auth::user()->perfil_id <= 2): ?>
      
      var sucursalE          =  $('#sucursalB').val();
      
      if(sucursalE != ''){
        $('#sucursalE').val(sucursalE);
      }
      
      <?php endif; ?>

      if(fechaE != ''){
        $('#fechaE').val(fechaE);
      }
    }

    $(document).ready(function() {

        $('#fechaB').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true
        });  

        var tableTratamiento = $('#tableTratamiento').DataTable({
          "searching": false,
          processing: true,
          pageLength: 10,
          language: {
                      "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                    },
          order: [ 2, "asc" ],
          ajax: {
                url: "reserva.getTableReservas",
                type: "POST",
                data:{
                        paciente_rut      : paciente_rut,
                        apellido_paterno  : apellido_paterno,
                        profesional_rut   : profesional_rut,
                        apellido_paternop : apellido_paternop,
                        fecha             : fecha,
                        <?php if(Auth::user()->perfil_id <= 2): ?>
                          sucursal_id       : sucursal_id,
                        <?php endif; ?>
                        "_token"          : token,                     
                    },
            },
          columns: [
                    {class : "text-center",
                     data: 'paciente_rut'},
                     {class : "text-center",
                     data: 'paciente'},
                    {class : "text-center",
                     data: 'fecha'},
                    {class : "text-center",
                     data: 'hora'},
                    {class : "text-center",
                     data: 'profesional_rut'},
                    {class : "text-center",
                     data: 'profesional'},
                    {class : "text-center",
                     data: 'sucursal'},
                    {class : "text-center",
                     data: 'action', name: 'action', orderable: false, searchable: false}
                    
                ],
          colReorder: true,
        });

        
      });

  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>