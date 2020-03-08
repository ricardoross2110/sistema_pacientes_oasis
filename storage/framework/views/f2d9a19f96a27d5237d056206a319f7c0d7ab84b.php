<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <?php if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2): ?>
            <!-- Sidebar user panel (optional) -->
            <?php if(! Auth::guest()): ?>
                <div class="user-panel">
                    <div class="pull-left info">
                        <?php switch(Auth::user()->perfil_id):
                            case (1): ?>
                                <p>Superadministrador</p>
                                <?php break; ?>
                            <?php case (2): ?>
                                <p>Administrador</p>
                                <?php break; ?>
                        <?php endswitch; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <!-- Optionally, you can add icons to the links -->
                <li class="<?php echo e((Request::is('usuarios') || Request::is('usuarios/*') || Request::is('pacientes') || Request::is('pacientes/*') || Request::is('profesionales') || Request::is('profesionales/*') ? 'treeview active' : 'treeview')); ?>">
                  <a href="#"><i class="fa fa-book"></i><span><?php echo e(trans('adminlte_lang::message.administracion')); ?></span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="<?php echo Request::is('usuarios') || Request::is('usuarios/*') ? 'active' : ''; ?>"><a href="<?php echo e(url('/usuarios')); ?>"><i class="fa fa-user"></i><?php echo e(trans('adminlte_lang::message.usuarios')); ?></a></li>
                    <li class="<?php echo Request::is('pacientes') || Request::is('pacientes/*') ? 'active' : ''; ?>"><a href="<?php echo e(url('/pacientes')); ?>"><i class="fa fa-users"></i><?php echo e(trans('adminlte_lang::message.pacientes')); ?></a></li>
                    <li class="<?php echo Request::is('profesionales') || Request::is('profesionales/*') ? 'active' : ''; ?>"><a href="<?php echo e(url('/profesionales')); ?>"><i class="fa fa-user-md"></i><?php echo e(trans('adminlte_lang::message.profesional')); ?></a></li>
                  </ul>
                </li>
                <li class="<?php echo Request::is('tratamiento') || Request::is('tratamiento/*') || Request::is('RegistrarAtencion') || Request::is('RegistrarAtencion/*') || Request::is('HistorialAtencion') || Request::is('HistorialAtencion/*') || Request::is('reserva') || Request::is('reserva/*') || Request::is('RegistrarReserva') || Request::is('RegistrarReserva/*') ? 'treeview active' : 'treeview'; ?>">
                    <a href="#"><i class="fa fa-file-text"></i><span><?php echo e(trans('adminlte_lang::message.atencion')); ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="<?php echo Request::is('tratamiento') || Request::is('tratamiento/*') ? 'active' : ''; ?>"><a href="<?php echo e(url('/tratamiento')); ?>"><?php echo e(trans('adminlte_lang::message.tratamiento')); ?></a></li>
                    <li class="<?php echo Request::is('RegistrarAtencion') || Request::is('RegistrarAtencion/*') ? 'active' : ''; ?>"><a href="<?php echo e(url('/RegistrarAtencion')); ?>"><?php echo e(trans('adminlte_lang::message.regatencion')); ?></a></li>
                    <li class="<?php echo Request::is('reserva') || Request::is('reserva/*') ? 'active' : ''; ?>"><a href="<?php echo e(url('/reserva')); ?>"><?php echo e(trans('adminlte_lang::message.reserva')); ?></a></li>
                    <li class="<?php echo Request::is('HistorialAtencion') ? 'active' : ''; ?>"><a href="<?php echo e(url('/HistorialAtencion')); ?>"><?php echo e(trans('adminlte_lang::message.historial')); ?></a></li>
                  </ul>
                </li>
                <li class="<?php echo Request::is('ReporteAtencionPeriodo') || Request::is('ReporteAtencionPeriodo/*') || Request::is('ReporteAtencionSucursal') || Request::is('ReporteAtencionSucursal/*') || Request::is('ReporteAtencionProfesional') || Request::is('ReporteAtencionProfesional/*') || Request::is('ReporteAtencionSecretaria') || Request::is('ReporteAtencionPaciente') || Request::is('ReporteIngresoPeriodo') || Request::is('ReporteIngresoPeriodo/*') || Request::is('ReporteIngresoSucursal') || Request::is('ReporteIngresoSucursal/*') || Request::is('ReporteIngresoProfesional') || Request::is('ReporteIngresoProfesional/*') || Request::is('ReporteIngresoSecretaria') || Request::is('ReporteIngresoPaciente') ? 'treeview active' : 'treeview'; ?>">
                    <a href="#"><i class="fa fa-pie-chart"></i><span><?php echo e(trans('adminlte_lang::message.reports')); ?></span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span></a>
                  <ul class="treeview-menu">
                    <li class="<?php echo Request::is('ReporteAtencionPeriodo') || Request::is('ReporteAtencionPeriodo') ? 'active' : ''; ?>"><a href="<?php echo e(url('/ReporteAtencionPeriodo')); ?>">Reporte atenciones por periodo</a></li>
                    <li class="<?php echo Request::is('ReporteAtencionSucursal') || Request::is('ReporteAtencionSucursal') ? 'active' : ''; ?>"><a href="<?php echo e(url('/ReporteAtencionSucursal')); ?>">Reporte atenciones por sucursal</a></li>
                    <li class="<?php echo Request::is('ReporteAtencionProfesional') || Request::is('ReporteAtencionProfesional') ? 'active' : ''; ?>"><a href="<?php echo e(url('/ReporteAtencionProfesional')); ?>">Reporte atenciones por profesional</a></li>
                    <li class="<?php echo Request::is('ReporteAtencionSecretaria') || Request::is('ReporteAtencionSecretaria') ? 'active' : ''; ?>"><a href="<?php echo e(url('/ReporteAtencionSecretaria')); ?>">Reporte atenciones por secretaria</a></li>
                    <li class="<?php echo Request::is('ReporteAtencionPaciente') || Request::is('ReporteAtencionPaciente') ? 'active' : ''; ?>"><a href="<?php echo e(url('/ReporteAtencionPaciente')); ?>">Reporte atenciones por pacientes</a></li>
                    <li class="<?php echo Request::is('ReporteIngresoPeriodo') || Request::is('ReporteIngresoPeriodo') ? 'active' : ''; ?>"><a href="<?php echo e(url('/ReporteIngresoPeriodo')); ?>">Reporte ingresos por periodo</a></li>
                    <li class="<?php echo Request::is('ReporteIngresoSucursal') || Request::is('ReporteIngresoSucursal') ? 'active' : ''; ?>"><a href="<?php echo e(url('/ReporteIngresoSucursal')); ?>">Reporte ingresos por sucursal</a></li>
                    <li class="<?php echo Request::is('ReporteIngresoProfesional') || Request::is('ReporteIngresoProfesional') ? 'active' : ''; ?>"><a href="<?php echo e(url('/ReporteIngresoProfesional')); ?>">Reporte ingresos por profesional</a></li>
                    <li class="<?php echo Request::is('ReporteIngresoSecretaria') || Request::is('ReporteIngresoSecretaria') ? 'active' : ''; ?>"><a href="<?php echo e(url('/ReporteIngresoSecretaria')); ?>">Reporte ingresos por secretaria</a></li>
                    <li class="<?php echo Request::is('ReporteIngresoPaciente') || Request::is('ReporteIngresoPaciente') ? 'active' : ''; ?>"><a href="<?php echo e(url('/ReporteIngresoPaciente')); ?>">Reporte ingresos por pacientes</a></li>
                  </ul>
                </li>
            </ul>
        <?php endif; ?>
    </section>
</aside>
