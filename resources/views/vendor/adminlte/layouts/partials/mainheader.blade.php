<!-- Main Header -->
<header class="main-header">

     <!-- Logo -->
    <a href="{{ url('/login') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="{{ asset('/img/logo_clinicaoasis.png') }}" width="150" height="45" alt="UCSC Logo"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="{{ asset('/img/logo_clinicaoasis.png') }}" width="150" height="45" alt="UCSC Logo"></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        @if(Auth::user()->perfil_id < 3)
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        @endif
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="">
                        <!-- The user image in the navbar-->
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"><strong>Sucursal: </strong>{{ Session()->get('nombre_sucursal') }}</span>
                    </a>
                </li>
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ Auth::user()->nombres }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header" style="height: 65px;">
                            <p>
                                @if ( Auth::user()->perfil_id == '1' )
                                    {{ ' Superadministrador' }}
                                @else 
                                    @if ( Auth::user()->perfil_id == '2' )
                                        {{ 'Administrador' }} 
                                    @else 
                                        @if ( Auth::user()->perfil_id == '3' )
                                            {{ 'Secretaria' }}
                                        @else 
                                            @if ( Auth::user()->perfil_id == '4' )
                                                {{ 'Asistente' }}
                                            @endif
                                        @endif
                                    @endif
                                @endif 
                            </p>
                        </li>      
                        <!-- Menu Footer-->
                        <li class="user-footer">                               
                            <div class="pull-right">
                                <a href="{{ url('/logout') }}" class="btn btn-danger btn-flat">
                                    {{ trans('adminlte_lang::message.signout') }}
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
