<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=11">
    <title>Sistema de gestión Oasis | <?php echo $__env->yieldContent('htmlheader_title', 'Your title here'); ?> </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <link href="<?php echo e(asset('/css/all.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- icheck -->
    <link href="<?php echo e(asset('/plugins/iCheck/all.css')); ?>" rel="stylesheet" type="text/css" />

    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('/img/logo_oasis.png')); ?>">

    <!-- datatable -->
    <link href="<?php echo e(asset('/plugins/datatables/dataTables.bootstrap.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- multi select -->
    <link href="<?php echo e(asset('/plugins/multiselectjs/css/style.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Select2 -->
    <link href="<?php echo e(asset('/plugins/select2/dist/css/select2.css')); ?>" rel="stylesheet" type="text/css">

    <!-- Duallistbox -->
    <link href="<?php echo e(asset('/plugins/duallistbox/src/bootstrap-duallistbox.css')); ?>" rel="stylesheet" type="text/css" />

    <!-- Datepicker Files -->
    <link href="<?php echo e(asset('/plugins/datepicker/datepicker3.css')); ?>" rel="stylesheet">

    <!-- Timepicker Files -->
    <link href="<?php echo e(asset('/plugins/timepicker/bootstrap-timepicker.min.css')); ?>" rel="stylesheet">   

    <!-- Fullcalendar Files --> 
    <link href="<?php echo e(asset('plugins/morris/morris.css')); ?>" rel="stylesheet">    
    <link href="<?php echo e(asset('plugins/fullcalendar/fullcalendar.min.css')); ?>" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('plugins/Ionicons/css/ionicons.min.css')); ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style type="text/css" media="screen">
        .not-active {
            pointer-events: none;
            cursor: default;
            text-decoration: none;
        }

        td.details-control {
            background: url('<?php echo e(asset('/img/details_open.png')); ?>') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('<?php echo e(asset('/img/details_close.png')); ?>') no-repeat center center;
        }
    </style>

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
</head>
