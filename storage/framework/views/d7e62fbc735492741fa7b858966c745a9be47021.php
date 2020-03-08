<?php $__env->startSection('htmlheader_title'); ?>
	<?php echo e(trans('adminlte_lang::message.regreserva')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  <?php echo e(trans('adminlte_lang::message.regreserva')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.reserva')); ?></li>
    <li class="active"><?php echo e(trans('adminlte_lang::message.regreserva')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
  <div>
    <!-- Este botón sólo aparece si el usuario es secretaria o asistente -->
    <a class="btn btn-default" href="javascript:history.back()" role="button">Volver</a>
  </div>

  <br>
  <?php if(isset($folio)): ?>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-body">
            <div class="box-body">
              <div class="row">
                <div class="col-md-4">
                  <?php echo Form::label('n_folio', 'N° folio:', ['for' => 'n_folio'] ); ?>

                  <?php echo Form::text('n_folio', $folio, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off']  ); ?>

                </div>
                <div class="col-md-6">
                  <?php echo Form::label('tratamiento', 'Tratamiento:', ['for' => 'tratamiento'] ); ?>

                  <?php echo Form::text('tratamiento', $tratamiento->nombre, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el nombre de tratamiento', 'maxlength' => '50']  ); ?>

                </div>
                <div class="col-md-2">
                  <?php echo Form::label('controles', 'Controles:', ['for' => 'controles'] ); ?>

                  <?php echo Form::text('controles', $tratamiento->num_control , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ); ?>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-body">
            <div class="box-body">
              <div class="row">
                <div class="col-md-3">
                  <?php echo Form::label('rut_pacienteN', 'RUT del paciente:', ['for' => 'rut_pacienteN'] ); ?>

                  <?php if(isset($paciente)): ?>
                    <?php echo Form::text('rut_pacienteN', $paciente->rut , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ej: 12345678', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'required', 'autocomplete' => 'off']  ); ?>

                  <?php else: ?>
                    <?php echo Form::text('rut_pacienteN', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'required', 'autocomplete' => 'off']  ); ?>

                  <?php endif; ?>
              </div>
              <div class="col-md-4">
                  <?php echo Form::label('nombre_paciente', 'Nombre:', ['for' => 'nombre_paciente'] ); ?>

                  <?php if(isset($paciente)): ?>
                      <?php echo Form::text('nombre_paciente', $paciente->nombres.' '.$paciente->apellido_paterno.' '.$paciente->apellido_materno, ['class' => 'form-control', 'disabled', 'placeholder' => 'Nombre del paciente', 'maxlength' => '50']  ); ?>

                  <?php else: ?>
                      <?php echo Form::text('nombre_paciente', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'Nombre del paciente', 'maxlength' => '50']  ); ?>

                  <?php endif; ?>
              </div>
              <div class="col-md-3">
                  <?php echo Form::label('correo_paciente', 'Correo:', ['for' => 'correo_paciente'] ); ?>

                  <?php if(isset($paciente)): ?>
                      <?php echo Form::text('correo_paciente', $paciente->email, ['class' => 'form-control', 'disabled', 'placeholder' => 'Correo electrónico del paciente', 'maxlength' => '50']  ); ?>

                  <?php else: ?>
                      <?php echo Form::text('correo_paciente', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'Correo electrónico del paciente', 'maxlength' => '50']  ); ?>

                  <?php endif; ?>
              </div>
              <div class="col-md-2">
                  <?php echo Form::label('telefono_paciente', 'Teléfono:', ['for' => 'telefono_paciente'] ); ?>

                  <?php if(isset($paciente)): ?>
                      <?php echo Form::text('telefono_paciente', $paciente->telefono, ['class' => 'form-control', 'disabled', 'placeholder' => 'Teléfono del paciente', 'maxlength' => '50']  ); ?>

                  <?php else: ?>
                      <?php echo Form::text('telefono_paciente', null, ['class' => 'form-control', 'disabled', 'placeholder' => 'Teléfono del paciente', 'maxlength' => '50']  ); ?>

                  <?php endif; ?>
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
          <div class="box-header">
            Nueva atención
          </div>
          <div class="box-body table-responsive" style="height: 150px">
            <div class="box-body">
              <div class="row">
                <div class="form-group col-md-4">
                  <?php echo Form::label('fecha', 'Fecha:', ['for' => 'fecha'] ); ?>

                  <?php echo Form::text('fecha', null , ['class' => 'form-control pull-right', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ); ?>

                </div>

                <div class="form-group col-md-4">
                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                      <?php echo Form::label('hora', 'Hora:', ['for' => 'hora'] ); ?>

                        <?php echo Form::text('hora', null , ['class' => 'form-control pull-right timepicker', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'HH:MM']  ); ?>

                    </div>
                  </div>
                </div>
                <div class="form-group col-md-4">
                  <?php if(Auth::user()->perfil_id >= 3): ?>
                    <?php echo Form::label('sucursal', 'Sucursal:', ['for' => 'sucursal'] ); ?>

                    <?php echo Form::text('sucursal', $sucursales->nombre, ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingrese sucursal', 'maxlength' => '50']  ); ?>

                  <?php else: ?>
                    <?php echo Form::label('sucursal', 'Sucursal:', ['for' => 'sucursal'] ); ?>

                    <?php echo Form::select('sucursal', $sucursales, null, array('class' => 'form-control', 'placeholder' => 'Seleccione sucursal')); ?>

                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="div_profesional" class="row hidden">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="box box-info">
            <div class="box-header">
              Detalle
            </div>
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

                  <br>
                  <?php echo Form::select('nombreProfesional', [], null, array('class' => 'form-control profesional_select', 'data-placeholder' => 'Seleccione profesional', 'style' => 'width: 100%' )); ?>

                </div>
                <div class="col-md-3">
                  <?php echo Form::label('profesion', 'Profesión:', ['for' => 'profesion'] ); ?>

                  <?php echo Form::text('profesion', '' , ['class' => 'form-control', 'disabled', 'placeholder' => 'Profesión', 'maxlength' => '50']  ); ?>

                </div>
                <div class="col-md-3">
                  <?php echo Form::label('cargoProfesional', 'Tipo contrato:', ['for' => 'cargoProfesional'] ); ?>

                  <?php echo Form::text('cargoProfesional', '' , ['class' => 'form-control', 'disabled', 'placeholder' => 'Tipo contrato', 'maxlength' => '50']  ); ?>

                </div>
              </div>
              <div class="row">
                <div class="col-md-12">                
                  <h4>
                    <strong>
                      <?php echo Form::label('observacion', 'Observaciones:' ); ?>

                    </strong>
                  </h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <?php echo Form::textarea('observacion', null, ['rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%']); ?>

                </div>
              </div>
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-md-12">
                  <div id="mensajeAtencion">
                  </div>
                </div>
              </div>
              <?php echo Form::button('Confirmar', array('id' => 'confirmar', 'class' => 'btn btn-info pull-right')); ?>

            </div>
          </div>
      </div>     
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token                 =   "<?php echo e(csrf_token()); ?>";

    var tipo_pagos            =   [];
    var total;
    var total_pago;
    var total_restante;
    var pago1Guardado;
    var pago2Guardado;
    var pago3Guardado;
    var pago4Guardado;

    var selectPagos           =   "";

    <?php if(isset($tipo_pago)): ?>
      <?php $__currentLoopData = $tipo_pago; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pago): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        tipo_pagos.push('<?php echo e($pago->id); ?>');
        selectPagos           =   selectPagos.concat('<option value="<?php echo e($pago->id); ?>"><?php echo e($pago->nombre); ?></option>');
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>

    $(document).ready(function() {
      <?php if(Auth::user()->perfil_id >= 3): ?>
        $.ajax({
          type    : 'POST',
          url     : "<?php echo e(url('atencion.getProfesionales')); ?>",
          data    : {
                      sucursal_id : <?php echo e(Session()->get('sucursal_id')); ?>,
                      "_token"    : token,
                    },
          dataType: 'json'
        })
        .done(function(data) {
          var profesional_select      =   $('.profesional_select');
          profesional_select.empty().trigger("change");
          $.each(data.profesionales, function(index, val) {
            var option = new Option(val, index, false, false);
            profesional_select.append(option).trigger('change');
          });
          $('#div_profesional').removeClass('hidden');
          profesional_select.val(null).trigger('change');
        })
        .fail(function(data) {
          console.log(data);
        });
      <?php endif; ?>

      $('#sucursal').change(function(event) {

        $.ajax({
          type    : 'POST',
          url     : "<?php echo e(url('atencion.getProfesionales')); ?>",
          data    : {
                      sucursal_id : $(this).val(),
                      "_token"    : token,
                    },
          dataType: 'json'
        })
        .done(function(data) {
          var profesional_select      =   $('.profesional_select');
          profesional_select.empty().trigger("change");
          $.each(data.profesionales, function(index, val) {
            var option = new Option(val, index, false, false);
            profesional_select.append(option).trigger('change');
          });
          $('#div_profesional').removeClass('hidden');
          profesional_select.val(null).trigger('change');
        })
        .fail(function(data) {
          console.log(data);
        });
      });

      //Timepicker
      $('.timepicker').timepicker({
        showInputs: false
      });

      $('#rut_pacienteN').keypress(function(e) {
        if(e.which == 13) {
            if ($(this).val() == '') {
                $('#mensajeCliente').html('');
                $('#mensajeCliente').html('<div class="alert alert-danger fade in"><center><strong>No ha ingresado RUT del paciente</strong></center></div>');
                $('#mensajeCliente').show('fold',5000);
                
            }else{
                $.ajax({
                    url: '<?php echo e(url("tratamiento.getPaciente")); ?>',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        rut_pacienteN : $(this).val(),
                        "_token"      : token,
                    },
                    
                })
                .done(function(data) {
                    console.log(data);
                    $('#nombre_paciente').val(data.pacientes[0].nombre_paciente);
                    $('#correo_paciente').val(data.pacientes[0].email);
                    $('#telefono_paciente').val(data.pacientes[0].telefono);
                })
                .fail(function(data) {
                    console.log(data);
                });
            }
        }
      });

      $('#fecha').datepicker({
          format: "dd/mm/yyyy",
          language: 'es',
          startDate: '+0d',
          todayHighlight: true,
          autoclose: true
      }); 

      $('.profesional_select').select2();

      $('.profesional_select').on('select2:select', function (e) {
        console.log($(this).val());
        $.ajax({
          type    : 'POST',
          url     : "<?php echo e(url('atencion.getDatosProfesional')); ?>",
          data    : {
                      rut_profesional : $(this).val(),
                      "_token"    : token,
                    },
          dataType: 'json'
        })
        .done(function(data) {
          $('#div_abono').removeClass('hidden');
          $('#profesion').val(data.profesion);
          $('#cargoProfesional').val(data.tipo_contrato);
        })
        .fail(function(data) {
          console.log(data);
        });
      });

      $('#confirmar').click(function(e) {
        var rut_pacienteN       = $('#rut_pacienteN').val();
        var num_atencion        = $('#n_atencion').val();
        var observacion         = $('#observacion').val();
        var fecha               = $('#fecha').val();
        var hora                = $('#hora').val();
        var tratamiento_folio   = $('#n_folio').val();
        var profesional_rut     = $('#nombreProfesional').val();
        <?php if(Auth::user()->perfil_id >= 3): ?>
          var sucursal_id         = "<?php echo e(Session()->get('sucursal_id')); ?>";
        <?php else: ?>
          var sucursal_id         = $('#sucursal').val();
        <?php endif; ?>
        /*Abono*/
        var abono               = $('#total').val();

        $.ajax({
          url: "<?php echo e(url('atencion.guardarAtencion')); ?>",
          type: 'post',
          dataType: 'json',
          data: {
                  num_atencion        :   num_atencion,
                  observacion         :   observacion,
                  fecha               :   fecha,
                  hora                :   hora,
                  tratamiento_folio   :   tratamiento_folio,
                  paciente_rut        :   rut_pacienteN,
                  profesional_rut     :   profesional_rut,
                  sucursal_id         :   sucursal_id,
                  abono               :   abono,
                  tipo                :   'reserva',
                  "_token"            : token
                },
        })
        .done(function(data) {
          if (data.tipo_mensaje == "error") {
            $('#mensajeAtencion').html('<div class="alert alert-danger">' + data.mensaje +'</div>');
          }else if (data.tipo_mensaje == "success") {
            $('#mensajeAtencion').html('<div class="alert alert-success">' + data.mensaje +'</div>');
            $("#confirmar").attr('disabled', 'disabled');
            $("#mensajeAtencion").animate({
              marginTop:'toggle',
              display:'block'},
              2000, function() {
                window.location.replace("/reserva");
            });
          }
        })
        .fail(function(data) {
          console.log(data);
        });
      });
    });

  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>