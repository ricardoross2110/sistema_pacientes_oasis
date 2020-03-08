<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        @if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2)
            <!-- Sidebar user panel (optional) -->
            @if (! Auth::guest())
                <div class="user-panel">
                    <div class="pull-left info">
                        @switch (Auth::user()->perfil_id)
                            @case (1)
                                <p>Superadministrador</p>
                                @break
                            @case (2)
                                <p>Administrador</p>
                                @break
                        @endswitch
                    </div>
                </div>
            @endif

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <!-- Optionally, you can add icons to the links -->
                <li class="{{ (Request::is('usuarios') || Request::is('usuarios/*') || Request::is('pacientes') || Request::is('pacientes/*') || Request::is('profesionales') || Request::is('profesionales/*') ? 'treeview active' : 'treeview') }}">
                  <a href="#"><i class="fa fa-book"></i><span>{{ trans('adminlte_lang::message.administracion') }}</span>
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{!! Request::is('usuarios') || Request::is('usuarios/*') ? 'active' : '' !!}"><a href="{{ url('/usuarios') }}"><i class="fa fa-user"></i>{{ trans('adminlte_lang::message.usuarios') }}</a></li>
                    <li class="{!! Request::is('pacientes') || Request::is('pacientes/*') ? 'active' : '' !!}"><a href="{{ url('/pacientes') }}"><i class="fa fa-users"></i>{{ trans('adminlte_lang::message.pacientes') }}</a></li>
                    <li class="{!! Request::is('profesionales') || Request::is('profesionales/*') ? 'active' : '' !!}"><a href="{{ url('/profesionales') }}"><i class="fa fa-user-md"></i>{{ trans('adminlte_lang::message.profesional') }}</a></li>
                  </ul>
                </li>
                <li class="{!! Request::is('tratamiento') || Request::is('tratamiento/*') || Request::is('RegistrarAtencion') || Request::is('RegistrarAtencion/*') || Request::is('HistorialAtencion') || Request::is('HistorialAtencion/*') || Request::is('reserva') || Request::is('reserva/*') || Request::is('RegistrarReserva') || Request::is('RegistrarReserva/*') ? 'treeview active' : 'treeview' !!}">
                    <a href="#"><i class="fa fa-file-text"></i><span>{{ trans('adminlte_lang::message.atencion') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li class="{!! Request::is('tratamiento') || Request::is('tratamiento/*') ? 'active' : '' !!}"><a href="{{ url('/tratamiento') }}">{{ trans('adminlte_lang::message.tratamiento') }}</a></li>
                    <li class="{!! Request::is('RegistrarAtencion') || Request::is('RegistrarAtencion/*') ? 'active' : '' !!}"><a href="{{ url('/RegistrarAtencion') }}">{{ trans('adminlte_lang::message.regatencion') }}</a></li>
                    <li class="{!! Request::is('reserva') || Request::is('reserva/*') ? 'active' : '' !!}"><a href="{{ url('/reserva') }}">{{ trans('adminlte_lang::message.reserva') }}</a></li>
                    <li class="{!! Request::is('HistorialAtencion') ? 'active' : '' !!}"><a href="{{ url('/HistorialAtencion') }}">{{ trans('adminlte_lang::message.historial') }}</a></li>
                  </ul>
                </li>
                <li class="{!! Request::is('ReporteAtencionPeriodo') || Request::is('ReporteAtencionPeriodo/*') || Request::is('ReporteAtencionSucursal') || Request::is('ReporteAtencionSucursal/*') || Request::is('ReporteAtencionProfesional') || Request::is('ReporteAtencionProfesional/*') || Request::is('ReporteAtencionSecretaria') || Request::is('ReporteAtencionPaciente') || Request::is('ReporteIngresoPeriodo') || Request::is('ReporteIngresoPeriodo/*') || Request::is('ReporteIngresoSucursal') || Request::is('ReporteIngresoSucursal/*') || Request::is('ReporteIngresoProfesional') || Request::is('ReporteIngresoProfesional/*') || Request::is('ReporteIngresoSecretaria') || Request::is('ReporteIngresoPaciente') ? 'treeview active' : 'treeview' !!}">
                    <a href="#"><i class="fa fa-pie-chart"></i><span>{{ trans('adminlte_lang::message.reports') }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span></a>
                  <ul class="treeview-menu">
                    <li class="{!! Request::is('ReporteAtencionPeriodo') || Request::is('ReporteAtencionPeriodo') ? 'active' : '' !!}"><a href="{{ url('/ReporteAtencionPeriodo') }}">Reporte atenciones por periodo</a></li>
                    <li class="{!! Request::is('ReporteAtencionSucursal') || Request::is('ReporteAtencionSucursal') ? 'active' : '' !!}"><a href="{{ url('/ReporteAtencionSucursal') }}">Reporte atenciones por sucursal</a></li>
                    <li class="{!! Request::is('ReporteAtencionProfesional') || Request::is('ReporteAtencionProfesional') ? 'active' : '' !!}"><a href="{{ url('/ReporteAtencionProfesional') }}">Reporte atenciones por profesional</a></li>
                    <li class="{!! Request::is('ReporteAtencionSecretaria') || Request::is('ReporteAtencionSecretaria') ? 'active' : '' !!}"><a href="{{ url('/ReporteAtencionSecretaria') }}">Reporte atenciones por secretaria</a></li>
                    <li class="{!! Request::is('ReporteAtencionPaciente') || Request::is('ReporteAtencionPaciente') ? 'active' : '' !!}"><a href="{{ url('/ReporteAtencionPaciente') }}">Reporte atenciones por pacientes</a></li>
                    <li class="{!! Request::is('ReporteIngresoPeriodo') || Request::is('ReporteIngresoPeriodo') ? 'active' : '' !!}"><a href="{{ url('/ReporteIngresoPeriodo') }}">Reporte ingresos por periodo</a></li>
                    <li class="{!! Request::is('ReporteIngresoSucursal') || Request::is('ReporteIngresoSucursal') ? 'active' : '' !!}"><a href="{{ url('/ReporteIngresoSucursal') }}">Reporte ingresos por sucursal</a></li>
                    <li class="{!! Request::is('ReporteIngresoProfesional') || Request::is('ReporteIngresoProfesional') ? 'active' : '' !!}"><a href="{{ url('/ReporteIngresoProfesional') }}">Reporte ingresos por profesional</a></li>
                    <li class="{!! Request::is('ReporteIngresoSecretaria') || Request::is('ReporteIngresoSecretaria') ? 'active' : '' !!}"><a href="{{ url('/ReporteIngresoSecretaria') }}">Reporte ingresos por secretaria</a></li>
                    <li class="{!! Request::is('ReporteIngresoPaciente') || Request::is('ReporteIngresoPaciente') ? 'active' : '' !!}"><a href="{{ url('/ReporteIngresoPaciente') }}">Reporte ingresos por pacientes</a></li>
                  </ul>
                </li>
            </ul>
        @endif
    </section>
</aside>
