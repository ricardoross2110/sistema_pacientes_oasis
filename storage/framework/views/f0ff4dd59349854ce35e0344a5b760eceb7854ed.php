<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<?php $__env->startSection('htmlheader'); ?>
    <?php echo $__env->make('adminlte::layouts.partials.htmlheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>

<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="sidebar-mini skin-black-light">
<div id="app">
    <div class="wrapper">

        <?php echo $__env->make('adminlte::layouts.partials.mainheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make('adminlte::layouts.partials.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

    <!-- para filtrar seccion a mostrar  -->
        <?php if( Auth::user()->rol_select == 'admin' ): ?>
            
        <?php else: ?>
            
        <?php endif; ?>


         <?php echo $__env->make('adminlte::layouts.partials.contentheader', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

            <!-- Main content -->
            <section class="content container-fluid">
                <?php echo $__env->make('adminlte::layouts.partials.flash_message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                
                <!-- Your Page Content Here -->
                <?php echo $__env->yieldContent('main-content'); ?>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

            
        
       <!-- footer para index-->
        <?php if(! Auth::guest()): ?>
            <?php echo $__env->make('adminlte::layouts.partials.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php else: ?>
            <?php echo $__env->make('adminlte::layouts.partials.footerIndex', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php endif; ?>
 

    </div><!-- ./wrapper -->
</div>
<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make('adminlte::layouts.partials.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->yieldSection(); ?>

</body>
</html>
