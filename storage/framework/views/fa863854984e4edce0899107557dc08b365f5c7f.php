<?php $__env->startSection('htmlheader_title'); ?>
  Error
<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    Error 404
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>
    <li><a href="<?php echo e(url('/login')); ?>"><i class="fa fa-home"></i>Home</a></li>  
    <li class="active">Error</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    <br>
    <div class="error-page">
      <h2 class="headline text-danger">
        <img src="<?php echo e(asset('/img/logo_oasis.png')); ?>" style="height: 80px; padding-right: 10px" alt="Oasis Logo" >
      </h2>
      <br>
      <div class="error-content">
        <h3><i class="fa fa-warning text-danger" style="color:black"></i> Lo sentimos, la página que buscas no funciona :(</h3>

        <p>
            No logramos encontrar la página que estabas buscando.
            Mientras tanto, puedes regresar al inicio <a href="<?php echo e(url('/home')); ?>">haciendo clic aquí</a>.
        </p>
      </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>