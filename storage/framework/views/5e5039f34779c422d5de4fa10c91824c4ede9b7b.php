<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $__env->yieldContent('contentheader_title', 'Page Header here'); ?>
        <small><?php echo $__env->yieldContent('contentheader_description'); ?></small>
    </h1>
    <ol class="breadcrumb">
       <?php echo $__env->yieldContent('breadcrumb_nivel', 'Level here'); ?>
    </ol>

</section>