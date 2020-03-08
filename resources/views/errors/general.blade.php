<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=11">
    <title> Sistema Gestión Capacitaciones | Error </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/img/cummins.png') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition skin-red sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
        <a href="{{ url('/login') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <img src="{{ asset('/img/logo_cummins.png') }}"  alt="Cummins Logo">
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>logo_cummins</b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
        </nav>
    </header>

    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Error inesperado
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i>Error</a></li>
        </ol>
      </section>

      <section class="content">
        <div class="error-page">
          <h2 class="headline text-danger">
              <img src="{{ asset('/img/cummins_logo.png') }}" style="height: 130px" alt="Cummins Logo" >
          </h2>

          <div class="error-content">
              <h3><i class="fa fa-warning text-danger"></i> Lo sentimos pero ha ocurrido un error inesperado.</h3>
              <p>
                  Algo pasó mientras se cargaba la página.
                  Contacte al administrador.
              </p>
          </div>
        </div>
      </section>
    </div>
    <footer class="main-footer" style="text-align: right;">
      <strong>SGC-F020 (V1.1.3)</strong>
    </footer>
  </div>
</body>
</html>