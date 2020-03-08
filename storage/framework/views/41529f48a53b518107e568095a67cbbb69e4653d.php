<?php $__env->startSection('htmlheader_title'); ?>
	<?php echo e(trans('adminlte_lang::message.profesional')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    Detalle profesional
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.administracion')); ?></li>
    <li><?php echo e(trans('adminlte_lang::message.profesional')); ?></li>
    <li class="active">Detalle profesional</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
	
	<div> 
		<a href="<?php echo e(url('/profesionales')); ?>" type="button" class="btn btn-default">Volver</a>
		<?php $__currentLoopData = $profesionales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profesional): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php if($profesional->estado == 'Activo'): ?>
				<a href="<?php echo e(url('/profesionales/'.$profesional->rut.'/edit')); ?>" class="btn btn-info" role="button">Editar</a>
				<a href="" class="btn btn-success" data-toggle="modal" data-target="#modalEliminarProfesional-<?php echo e($profesional->rut); ?>" title="Eliminar profesional">Eliminar
		        </a>
		        <div class="modal fade" id="modalEliminarProfesional-<?php echo e($profesional->rut); ?>">
			        <div class="modal-dialog">
			            <div class="modal-content">
			                <div class="modal-header bg-red">
			                    <h4 class="modal-title text-center">Confirmar eliminación</h4>
			                </div>
			                <div class="modal-body">
			                    <h3 class="text-center">¿Está seguro de eliminar este profesional?</h3>
			                </div>
			                <div class="modal-footer">
			                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
			                    <a href="<?php echo e(url('/profesionales/destroy').'/'.$profesional->rut); ?>" type="submit" class="btn btn-danger" role="button">Aceptar</a>
			                </div>
			            </div>
			        </div>
			    </div>
		    <?php else: ?>
		    	<a href="" class="btn btn-success" data-toggle="modal" data-target="#modal-activar_<?php echo e($profesional->rut); ?>" title="Activar profesional">Activar
		        </a>
		        <div class="modal fade" id="modal-activar_<?php echo e($profesional->rut); ?>" style="display: none;">
	                <div class="modal-dialog">
	                    <div class="modal-content">
	                        <div class="modal-header bg-green">
	                            <h4 class="modal-title text-center">Confirmar activación</h4>
	                        </div>

	                        <div class="modal-body">
	                            <h3 class="text-center">¿Está seguro de activar este profesional?</h3>
	                        </div>
	                        
	                        <div class="modal-footer">
	                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
	                            <a href="<?php echo e(url('/profesionales/activate').'/'.$profesional->rut); ?>" type="submit" class="btn btn-success" role="button">Aceptar</a>
	                        </div>
	                    </div>
	                </div>
	            </div>'
	        <?php endif; ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
	
	<br>

	<div class="row">
		<div class="col-md-12">
		<div class="box box-info">
			<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
			<div class="box-body table-responsive">
				<?php $__currentLoopData = $profesionales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profesional): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<table class="dataTables_wrapper table table-bordered">
					<tbody>
						<tr>
						    <th class="text-left" width="25%">RUT</th>
						    <td class="text-left" width="25%"><?php echo e($profesional->rut); ?>-<?php echo e($profesional->dv); ?></td>
						    <th class="text-left" width="25%">Nombre</th>
						    <td class="text-left" width="25%"><?php echo e($profesional->nombres); ?> <?php echo e($profesional->apellido_paterno); ?> <?php echo e($profesional->apellido_materno); ?></td>
						</tr>
						<tr>
						    <th class="text-left" width="25%">Correo electrónico</th>
						    <td class="text-left" width="25%"><?php echo e($profesional->email); ?></td>
						    <th class="text-left" width="25%">Dirección</th>
						    <td class="text-left" width="25%"><?php echo e($profesional->direccion); ?></td>
						</tr>
						<tr>
						    <th class="text-left" width="25%">Teléfono</th>
						    <td class="text-left" width="25%"><?php echo e($profesional->telefono); ?></td>
						    <th class="text-left" width="25%">Sucursal</th>
						    <td class="text-left" width="25%"><?php echo e($sucursales); ?></td>
						</tr>
						<tr>
						    <th class="text-left" width="25%">Profesión</th>
						    <td class="text-left" width="25%"><?php echo e($profesional->profesion); ?></td>
						    <th class="text-left" width="25%">Tipo de contrato</th>
						    <td class="text-left" width="25%"><?php echo e($profesional->tipo_contrato); ?></td>
						</tr>
						<tr>
						    <th class="text-left">Estado</th>
						    <td class="text-left" colspan="3"><?php echo e($profesional->estado); ?></td>
						</tr>
						<tr>
						    <th class="text-left">Observación</th>
						    <td class="text-left" colspan="3"><?php echo e($profesional->observacion); ?></td>
						</tr>
					</tbody>
				</table>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Detalle de atención</h3>
				</div>
				<div class="box-body table-responsive">
		              <?php echo Form::open(['route' => 'profesionales.exportExcelAtenciones',  'method' => 'POST']); ?>

		                  <?php echo Form::text('rutExcel', null , ['class' => 'hidden', 'id' => 'rutExcel'] ); ?>

		                  <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
		                      <span class="fa fa-download"></span>
		                  </button>
		              <?php echo Form::close(); ?>

		              <br>
					<table id="tableAtencion" class="table table-bordered">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Hora</th>
								<th>Sucursal</th>
								<th>Paciente</th>
								<th>Abono</th>
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

    var token               = "<?php echo e(csrf_token()); ?>";

    <?php $__currentLoopData = $profesionales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profesional): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    	var rut                	= '<?php echo e($profesional->rut); ?>';
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	// datatable grilla TablaVentas
    $ ('#tableAtencion').DataTable({
	    processing: true,
	    pageLength: 10,
	    searching   : false,
	    language: {
	        "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
	    },
	    order: [[ 0, "asc" ], [ 2, "asc" ]],
	    ajax: {
            url: "<?php echo e(url('profesionales.getTableAtencion')); ?>",
            type: "post",
            data:{
                    rut                	: rut,
                    "_token"            : token,                     
                },
        },
        columns: [
                {class : "text-center",
                 data: 'fecha'},
                {class : "text-center",
                 data: 'hora'},
                {class : "text-center",
                 data: 'sucursal'},
                {class : "text-center",
                 data: 'paciente'},
                {class : "text-center",
                 data: 'abono'}
            ],
    });

    function GuardarValores(){
        var rutExcel                =   rut;
  
        if(rutExcel != ''){
            $('#rutExcel').val(rutExcel);
        }
    }

    </script> 

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>