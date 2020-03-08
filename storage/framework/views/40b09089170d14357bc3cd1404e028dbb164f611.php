<?php $__env->startSection('htmlheader_title'); ?>
	<?php echo e(trans('adminlte_lang::message.usuarios')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    Detalle usuario
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.administracion')); ?></li>
    <li><?php echo e(trans('adminlte_lang::message.usuarios')); ?></li>
    <li class="active">Detalle usuario</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

	<div> 
		<a href="<?php echo e(url('/usuarios')); ?>" type="button" class="btn btn-default">Volver</a>
		<?php if($usuario->estado == 'Activo'): ?>
			<?php if($usuario->rut == Auth::user()->rut): ?>
				<a href="<?php echo e(url('/usuarios/'.$usuario->rut.'/edit')); ?>" class="btn btn-info" role="button">Editar</a>
			<?php else: ?>
				<a href="<?php echo e(url('/usuarios/'.$usuario->rut.'/edit')); ?>" class="btn btn-info" role="button">Editar</a>
				<a href="" class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-eliminar_<?php echo e($usuario->rut); ?>" title="Eliminar usuario">Eliminar
		        </a>
		        <div class="modal fade" id="modal-eliminar_<?php echo e($usuario->rut); ?>" style="display: none;">
	                <div class="modal-dialog">
	                    <div class="modal-content">
	                        <div class="modal-header bg-red">
	                            <h4 class="modal-title text-center">Confirmar eliminación</h4>
	                        </div>

	                        <div class="modal-body">
	                            <h3 class="text-center">¿Está seguro de eliminar a este usuario?</h3>
	                        </div>
	                        
	                        <div class="modal-footer">
	                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
	                            <a href="<?php echo e(url('/usuarios/destroy').'/'.$usuario->rut); ?>" type="submit" class="btn btn-danger" role="button">Aceptar</a>
	                        </div>
	                    </div>
	                </div>
	            </div>
            <?php endif; ?>
	    <?php else: ?>
	    	<a href="" class="btn btn-success" type="button" data-toggle="modal" data-target="#modal-activar_<?php echo e($usuario->rut); ?>" title="Activar usuario">Activar</a>
	    	<div class="modal fade" id="modal-activar_<?php echo e($usuario->rut); ?>" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-green">
                            <h4 class="modal-title text-center">Confirmar activación</h4>
                        </div>
                        <div class="modal-body">
                            <h3 class="text-center">¿Está seguro de activar a este usuario?</h3>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                            <a href="<?php echo e(url('/usuarios/activate').'/'.$usuario->rut); ?>" type="submit" class="btn btn-success" role="button">Aceptar</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
	</div>
	
	<br>

	<div class="col-md-6">
		<div class="box box-info">
			<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
			<div class="box-body table-responsive">
				<table class="dataTables_wrapper table table-bordered">
					<tbody>
						<tr>
						    <th class="text-left">RUT</th>
						    <td class="text-left"><?php echo e($usuario->rut.'-'.$usuario->dv); ?></td>
						</tr>
						<tr>
						    <th class="text-left">Nombre</th>
						    <td class="text-left"><?php echo e($usuario->nombres.' '.$usuario->apellido_paterno.' '.$usuario->apellido_materno); ?></td>	
						</tr>
						<tr>
						    <th class="text-left">Correo electrónico</th>
						    <td class="text-left"><?php echo e($usuario->email); ?></td>
						</tr>
						<tr>
						    <th class="text-left">Perfil</th>
						    <td class="text-left"><?php echo e($usuario->perfil->nombre); ?></td>
						</tr>
						<tr>
						    <th class="text-left">Fecha de registro</th>
						    <td class="text-left"><?php echo e($usuario->fecha_registro); ?></td>
						</tr>
						<tr>
						    <th class="text-left">Estado</th>
						    <td class="text-left"><?php echo e($usuario->estado); ?></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

  <script type="text/javascript">

    </script> 

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>