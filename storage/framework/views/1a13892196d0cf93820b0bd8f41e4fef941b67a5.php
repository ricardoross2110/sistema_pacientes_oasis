<?php $__env->startSection('htmlheader_title'); ?>
	<?php echo e(trans('adminlte_lang::message.pacientes')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    Detalle Paciente
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.administracion')); ?></li>
    <li><?php echo e(trans('adminlte_lang::message.pacientes')); ?></li>
    <li class="active">Detalle paciente</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
	
	<?php $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paciente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<div> 
		<a href="javascript:history.back()" type="button" class="btn btn-default">Volver</a>
		<?php if(Auth::user()->perfil_id <= 2): ?>
			<?php if($paciente->estado == 'Activo'): ?>
				<a href="<?php echo e(url('/pacientes/'.$paciente->rut.'/edit')); ?>" class="btn btn-info" role="button">Editar</a>
				<a href="" class="btn btn-success" data-toggle="modal" data-target="#modalEliminarCliente-<?php echo e($paciente->rut); ?>" title="Eliminar paciente">Eliminar
		        </a>
		        <div class="modal fade" id="modalEliminarCliente-<?php echo e($paciente->rut); ?>">
			        <div class="modal-dialog">
			            <div class="modal-content">
			                <div class="modal-header bg-red">
			                    <h4 class="modal-title text-center">Confirmar eliminación</h4>
			                </div>
			                <div class="modal-body">
			                    <h3 class="text-center">¿Está seguro de eliminar este paciente?</h3>
			                </div>
			                <div class="modal-footer">
			                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
			                    <a href="<?php echo e(url('/pacientes/destroy').'/'.$paciente->rut); ?>" type="submit" class="btn btn-danger" role="button">Aceptar</a>
			                </div>
			            </div>
			        </div>
			    </div>
		    <?php else: ?>
				<a href="" class="btn btn-success" data-toggle="modal" data-target="#modal-activar_<?php echo e($paciente->rut); ?>" title="Eliminar paciente">Activar
		        </a>
		        <div class="modal fade" id="modal-activar_<?php echo e($paciente->rut); ?>" style="display: none;">
	                <div class="modal-dialog">
	                    <div class="modal-content">
	                        <div class="modal-header bg-green">
	                            <h4 class="modal-title text-center">Confirmar activación</h4>
	                        </div>

	                        <div class="modal-body">
	                            <h3 class="text-center">¿Está seguro de activar este paciente?</h3>
	                        </div>
	                        
	                        <div class="modal-footer">
	                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
	                            <a href="<?php echo e(url('/pacientes/activate').'/'.$paciente->rut); ?>" type="submit" class="btn btn-success" role="button">Aceptar</a>
	                        </div>
	                    </div>
	                </div>
	            </div>'
		    <?php endif; ?>
		<?php endif; ?>
	</div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	
	<br>

	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
				<div class="box-body table-responsive">
					<?php $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paciente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<table class="dataTables_wrapper table table-bordered">
							<tbody>
								<tr>
								    <th class="text-left" width="25%">RUT</th>
								    <td class="text-left" width="25%"><?php echo e($paciente->rut); ?>-<?php echo e($paciente->dv); ?></td>
								    <th class="text-left" width="25%">Facebook</th>
								    <td class="text-left" width="25%">
								    	<?php if(is_null($paciente->facebook)): ?>
								    		No ingresó Facebook.
								    	<?php else: ?>
									    	<a href="<?php echo e($paciente->facebook); ?>" target="_blank" class="btn btn-primary"><i class="fa fa-facebook-square"></i> Ir a Facebook</a>
								    	<?php endif; ?>
								    </td>
								</tr>
								<tr>
								    <th class="text-left" width="25%">Nombre</th>
								    <td class="text-left" width="25%"><?php echo e($paciente->nombres); ?> <?php echo e($paciente->apellido_paterno); ?> <?php echo e($paciente->apellido_materno); ?></td>
								    <th class="text-left" width="25%">Instagram</th>
								    <td class="text-left" width="25%">
								    	<?php if(is_null($paciente->instagram)): ?>
								    		No ingresó Instagram.
								    	<?php else: ?>
									    	<a href="<?php echo e($paciente->instagram); ?>" target="_blank" class="btn btn-danger"><i class="fa fa-instagram"></i> Ir a Instagram</a>
								    	<?php endif; ?>
								    </td>
								</tr>
								<tr>
								    <th class="text-left" width="25%">Correo electrónico</th>
								    <td class="text-left" width="25%"><?php echo e($paciente->email); ?></td>
								    <th class="text-left" width="25%">Fecha de registro</th>
								    <td class="text-left" width="25%"><?php echo e(date_format(date_create($paciente->fecha_registro), 'd/m/Y')); ?></td>
								</tr>
								<tr>
								    <th class="text-left">Dirección</th>
								    <td class="text-left"><?php echo e($paciente->direccion); ?></td>
								    <th class="text-left">Estado</th>
								    <td class="text-left"><?php echo e($paciente->estado); ?></td>
								</tr>
								<tr>
								    <th class="text-left">Télefono</th>
								    <td class="text-left"><?php echo e($paciente->telefono); ?></td>
								    <th class="text-left">Fecha de nacimiento</th>
								    <td class="text-left"><?php echo e(date_format(date_create($paciente->fecha_nacimiento), 'd/m/Y')); ?> <strong>(<?php echo e($paciente->edad); ?> Años)</strong></td>
								</tr>
								<?php if(!is_null($paciente->observacion)): ?>
								<tr>
								    <th colspan="1" class="text-left">Observación:</th>
								    <td colspan="3" class="text-left"><?php echo e($paciente->observacion); ?></td>
								</tr>
								<?php endif; ?>
							</tbody>
						</table>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
		</div>
	</div>
	<?php if(Auth::user()->perfil_id <= 2): ?>
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">Detalle de atención</h3>
					</div>
					<div class="box-body table-responsive">
			              <?php echo Form::open(['route' => 'pacientes.exportExcelAtenciones',  'method' => 'POST']); ?>

			                  <?php echo Form::text('rutExcel', null , ['class' => 'hidden', 'id' => 'rutExcel'] ); ?>

			                  <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
			                      <span class="fa fa-download"></span>
			                  </button>
			              <?php echo Form::close(); ?>

			              <br>
						<table id="tableAtencion" class="table table-bordered">
							<thead>
								<tr>
									<th></th>
			                        <th class="text-center">N° folio</th>
			                        <th class="text-center">Tratamiento</th>
			                        <th class="text-center">N° control</th>
			                        <th class="text-center">Precio total</th>
			                        <th class="text-center">Deuda</th>
								</tr>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

  <script type="text/javascript">

    var token               = "<?php echo e(csrf_token()); ?>";

    <?php $__currentLoopData = $pacientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paciente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    	var rut                	= '<?php echo e($paciente->rut); ?>';
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	// datatable grilla TablaVentas
    var table = $ ('#tableAtencion').DataTable({
	    processing: true,
	    pageLength: 10,
	    searching   : false,
	    language: {
	        "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
	    },
	    order: [ 1, "asc" ],
	    ajax: {
            url: "<?php echo e(url('pacientes.getTableAtencion')); ?>",
            type: "post",
            data:{
                    rut                	: rut,
                    "_token"            : token,                     
                },
        },
        columns: [
                {
                  "className":      'details-control',
                  "orderable":      false,
                  "data":           null,
                  "defaultContent": ''
                },
                {class : "text-center",
                  data: 'folio'},
                {class : "text-center",
                  data: 'nombre'},
                {class : "text-center",
                  data: 'num_control'},
                {class : "text-center",
                  data: 'total'},
                {class : "text-center",
                  data: 'deuda'}
            ],
    });

    $('#tableAtencion tbody').on('click', 'td.details-control', function () {
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
                        order: [0, "asc"],
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
                      {class : "text-center",
                       data: 'sucursal'},
                      {class : "text-center",
                       data: 'abono'}
                  ],
              colReorder: true,
            });
            tr.addClass('shown');
          }
      } );

    function GuardarValores(){
        var rutExcel                =   rut;
  
        if(rutExcel != ''){
            $('#rutExcel').val(rutExcel);
        }
    }

    </script> 

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>