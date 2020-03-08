@extends('adminlte::layouts.app')

@section('htmlheader_title')
  {{ trans('adminlte_lang::message.dashboard') }}
@endsection

@section('contentheader_title')
  Bienvenido al sistema de gestión OASIS
@endsection

@section('breadcrumb_nivel')  
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
@endsection

@section('main-content')
 
    <div class="row">
      @if(Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 4)
        <!-- Parte que visualizará secretaria y asistente, incluye una sección de "Acciones Rápidas" -->
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="box box-info">
            <div class="box-header text-center">
              <strong>Acciones Rápidas</strong>
            </div>
            <div class="box-body">              
              <a id="busqueda_button"  href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".buscarPacienteModal" class=" btn btn-block btn-social btn-primary ">
                <i class="fa fa-search"></i> Buscar tratamientos por RUT
              </a>
              @if(Auth::user()->perfil_id == 3)
              <a  href="{{ url('/tratamiento/create') }}" class="btn bg-purple btn-block btn-social ">
                <i class="fa fa-file-text"></i> Registrar tratamiento
              </a>
              <a  href="{{ url('/RegistrarReserva') }}" class="btn bg-purple btn-block btn-social ">
                <i class="fa fa-plus"></i> Registrar reserva
              </a>
              <a href="#" class="btn btn-block btn-social btn-success " data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#createpaciente">
                <i class="fa fa-user"></i> Agregar nuevo paciente
              </a>
              @endif
              <a  href="{{ url('/tratamiento') }}" class="btn btn-block btn-social btn-info">
                <i class="fa fa-eye"></i> Ver tratamientos
              </a>
              <a  href="{{ url('/reserva/') }}" class="btn btn-block btn-social btn-warning">
                <i class="fa fa-list"></i> Ver reservas
              </a>
            </div>
          </div>
        </div>
        
        @include('pacientes.create')

        <div class="modal fade buscarPacienteModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-blue">
                <h2 class="box-title text-center">Búsqueda</h2>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="form-group col-md-3">
                    {!! Form::label('rutT', 'Rut del paciente:' ) !!}
                    {!! Form::text('rutT', null , ['class' => 'form-control', 'placeholder' => 'Ingrese rut del paciente', 'maxlength' => '8', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off'] ) !!}
                  </div>
                  <div class="form-group col-md-3">
                    {!! Form::label('nombrePacienteT', 'Nombre del paciente:' ) !!}
                    {!! Form::text('nombrePacienteT', null , ['class' => 'form-control', 'placeholder' => 'Nombre del paciente', 'maxlength' => '150', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ) !!}
                  </div>
                  <div class="form-group col-md-3">
                    {!! Form::label('telefonoT', 'Teléfono:' ) !!}
                    {!! Form::text('telefonoT', null , ['class' => 'form-control', 'placeholder' => 'Número de telefono', 'maxlength' => '16', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ) !!}
                  </div>
                  <div class="form-group col-md-3">
                    {!! Form::label('tipo_tratamientoT', 'Tipo de tratamiento:', ['for' => 'tipo_tratamientoT'] ) !!}
                    {!! Form::select('tipo_tratamientoT',  $tipo_tratamientos, null, array('class' => 'form-control', 'placeholder' => 'Seleccione tipo de tratamiento', 'required')) !!}
                  </div>
                </div>
                <div class="row hidden">
                  <div class="form-group col-md-4">
                    {!! Form::label('nfolioT', 'N° de Folio:' ) !!}
                    {!! Form::text('nfolioT', null , ['class' => 'form-control', 'placeholder' => 'Número de Folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off'] ) !!}
                  </div>
                  <div class="form-group col-md-4">
                    {!! Form::label('nombreTratamientoT', 'Nombre del Tratamiento:' ) !!}
                    {!! Form::text('nombreTratamientoT', null , ['class' => 'form-control', 'placeholder' => 'Nombre del tratamiento', 'maxlength' => '150', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ) !!}
                  </div>
                  <div class="form-group col-md-4">
                    {!! Form::label('controlesT', 'Controles:' ) !!}
                    {!! Form::text('controlesT', null , ['class' => 'form-control', 'placeholder' => 'Número de controles', 'maxlength' => '16', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ) !!}
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <div class="box-footer">
                      <button  id="limpiar_button" type="button" class="btn btn-default pull-left">Limpiar</button>
                      <button  id="busquedar_ahora" type="button" class="btn btn-primary pull-right">Buscar</button>
                    </div>  
                  </div>
                </div>

                <div id="div_tabla_busqueda" class="row hidden">
                  <div class="form-group col-md-12 table-responsive">
                    <table id="tableTratamiento" class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th class="text-center">Folio</th>
                          <th class="text-center">Tratamiento</th>
                          <th class="text-center">Tipo</th>
                          <th class="text-center">Rut</th>
                          <th class="text-center">Paciente</th>
                          <th class="text-center">Número de atenciones</th>
                          @if(Auth::user()->perfil_id == 3)
                          <th class="text-center">Valor total</th>
                            <th class="text-center">Deuda</th>
                          @endif
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button id="cancelar_busqueda" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="row">
            <div class="col-lg-12 col-md-12">          
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text text-center"><strong>Santoral del día</strong></span>
                    <br>
                    @if(count($santoHoy) == 0)
                      <span class="info-box-text">Probando.</span>
                    @else
                      @foreach ($santoHoy as $i=>$hoy)
                        @if($i < 2)
                          <span class="info-box-text">
                            <center>San(ta) {{ $hoy->santo }}</center>
                          </span>  
                        @endif
                      @endforeach
                      @if(count($santoHoy) > 2)
                        <a href="#" class="pull-right small-box-footer" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cumplehoy">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
                        <div class="modal fade" id="cumplehoy" tabindex="-1" role="dialog" aria-labelledby="cumplehoyLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header bg-yellow">
                                <h2 class="modal-title" id="cumplehoyLabel" style="text-align: center"><strong>Santoral del día</strong></h2>
                              </div>
                              <div class="modal-body text-center">
                                <table class="dataTables_wrapper table table-bordered" id="MyTable">
                                    <tbody>
                                    @foreach ($santoHoy as $i=>$hoy)
                                    <tr>
                                      <td>
                                         San(ta) {{ $hoy->santo }}
                                      </td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endif
                    @endif
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="row">
                <div class="col-lg-12 col-md-12">        
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-birthday-cake"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text text-center"><strong>Cumpleaños</strong></span>
                      @if(count($pacientesclumplehoy) == 0)
                        <span class="info-box-text">
                          <center>No hay cumpleaños.</center>
                        </span>
                      @else
                        @foreach ($pacientesclumplehoy as $i=>$hoy)
                          @if($i < 2)
                            <span class="info-box-text">
                              <center><a href="{{ url('/pacientes/'.$hoy->rut) }}">{{ $hoy->nombres }} {{ $hoy->apellido_paterno }} {{ $hoy->apellido_materno }}</a> ({{$hoy->edad }} Años)</center>
                            </span>
                          @endif
                        @endforeach
                        @if(count($pacientesclumplehoy) > 2)
                          <a href="#" class="pull-right small-box-footer" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cumplehoy">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
                          <div class="modal fade" id="cumplehoy" tabindex="-1" role="dialog" aria-labelledby="cumplehoyLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header bg-green">
                                  <h2 class="modal-title" id="cumplehoyLabel" style="text-align: center"><strong>Cumpleaños de Hoy</strong></h2>
                                </div>
                                <div class="modal-body text-center  table-responsive">
                                  <table class="dataTables_wrapper table table-bordered" id="MyTable">
                                      <thead>
                                      </thead>
                                      <tbody>
                                      @foreach ($pacientesclumplehoy as $i=>$hoy)
                                      <tr>
                                        <td>
                                          <a href="{{ url('/pacientes/'.$hoy->rut) }}">{{ $hoy->nombres }} {{ $hoy->apellido_paterno }} {{ $hoy->apellido_materno }}</a> ({{$hoy->edad }} Años)
                                        </td>
                                      </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endif
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @else
      <!-- Parte que visualizará superadministrador y administrador, incluye "semáforo" de alertas de no pago -->
        <div class="col-md-4 col-sm-12 col-xs-12"> 
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-birthday-cake"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-center"><strong>Cumpleaños</strong></span>
              <br>
              @if(count($pacientesclumplehoy) == 0)              
                <span class="info-box-text">
                  <center>No hay cumpleaños.</center>
                </span>
              @else
                @foreach ($pacientesclumplehoy as $i=>$hoy)
                  @if($i < 2)
                    <span class="info-box-text">
                      <center><a href="{{ url('/pacientes/'.$hoy->rut) }}">{{ $hoy->nombres }} {{ $hoy->apellido_paterno }} {{ $hoy->apellido_materno }}</a> ({{$hoy->edad }} Años)</center>
                    </span>  
                  @endif
                @endforeach
                @if(count($pacientesclumplehoy) > 2)
                  <a href="#" class="pull-right small-box-footer" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cumplehoy">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
                  <div class="modal fade" id="cumplehoy" tabindex="-1" role="dialog" aria-labelledby="cumplehoyLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-green">
                          <h2 class="modal-title" id="cumplehoyLabel" style="text-align: center"><strong>Cumpleaños de Hoy</strong></h2>
                        </div>
                        <div class="modal-body text-center  table-responsive">
                          <table class="dataTables_wrapper table table-bordered" id="MyTable">
                              <thead>
                              </thead>
                              <tbody>
                              @foreach ($pacientesclumplehoy as $i=>$hoy)
                              <tr>
                                <td>
                                  <h6><center><a href="{{ url('/pacientes/'.$hoy->rut) }}">{{ $hoy->nombres }} {{ $hoy->apellido_paterno }} {{ $hoy->apellido_materno }}</a> ({{$hoy->edad }} Años)</center></h6>
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
              @endif
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-center"><strong>Santoral del día</strong></span>
              <br>
              @if(count($santoHoy) == 0)
                <span class="info-box-text">No hay santoral el día de hoy.</span>
              @else
                @foreach ($santoHoy as $i=>$hoy)
                  @if($i < 2)
                    <span class="info-box-text">
                      <center>San(ta) {{ $hoy->santo }}</center>
                    </span>
                  @endif
                @endforeach
                @if(count($santoHoy) > 2)
                  <a href="#" class="pull-right small-box-footer" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cumplehoy">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
                  <div class="modal fade" id="cumplehoy" tabindex="-1" role="dialog" aria-labelledby="cumplehoyLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-yellow">
                          <h2 class="modal-title" id="cumplehoyLabel" style="text-align: center"><strong>Santoral del día</strong></h2>
                        </div>
                        <div class="modal-body text-center  table-responsive">
                          <table class="dataTables_wrapper table table-bordered" id="MyTable">
                              <tbody>
                              @foreach ($santoHoy as $i=>$hoy)
                              <tr>
                                <td>
                                   San(ta) {{ $hoy->santo }}
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
              @endif
            </div>
          </div>
        </div>
      @endif
      <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>
          <div class="info-box-content">
            <span class="info-box-text text-center">
              <strong>Fecha y hora</strong>
            </span>
            <h5 class="text-center"><p id="fecha_hora"></p></h5>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      @if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2)
        <div class="col-md-offset-2 col-md-8 col-sm-12 col-xs-12">
           <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title text-center">Alertas de no pago</h3>
              </div>

              <div class="box-body table-responsive no-padding">
                <ul class="nav nav-stacked">
                  <li><a id="personasAtrasadas" href="#" data-toggle="modal" data-target="#modalPersonasAtrasadas">Personas con más de un mes de no pago <span class="pull-right badge bg-red">{{ $pacientes_atrasadas }}</span></a></li>
                    <div class="modal fade" id="modalPersonasAtrasadas" tabindex="-1"aria-labelledby="modalPersonasAtrasadasLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg"role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-red">
                            <h2 class="modal-title" id="modalPersonasAtrasadasLabel"><center>Personas con atrasos de deudas</center></h2>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12  table-responsive">
                                <table class="table table-bordered table-striped" id="tablaPersonasConAtraso">
                                  <thead>
                                    <tr>
                                      <th class="text-center">RUT</th>
                                      <th class="text-center">Folio</th>
                                      <th class="text-center">Paciente</th>
                                      <th class="text-center">Última atención</th>
                                      <th class="text-center">Debe</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <li><a id="personasDeudas" href="#" data-toggle="modal" data-target="#modalPersonasConDeudas">Personas con deudas <span class="pull-right badge bg-yellow">{{ $pacientes_deuda }}</span></a></li>
                    <div class="modal fade" id="modalPersonasConDeudas" tabindex="-1"aria-labelledby="modalPersonasConDeudasLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg"role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-yellow">
                            <h2 class="modal-title" id="modalPersonasConDeudasLabel"><center>Personas con deudas</center></h2>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12  table-responsive">
                                <table class="table table-bordered table-striped" id="tablaPersonasConDeudas">
                                  <thead>
                                    <tr>
                                      <th class="text-center">RUT</th>
                                      <th class="text-center">Folio</th>
                                      <th class="text-center">Paciente</th>
                                      <th class="text-center">Última atención</th>
                                      <th class="text-center">Debe</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <li><a id="personasDia" href="#" data-toggle="modal" data-target="#modalPersonasAlDia">Personas al día <span class="pull-right badge bg-green">{{ $pacientes_al_dia }}</span></a></li>
                    <div class="modal fade" id="modalPersonasAlDia" tabindex="-1" aria-labelledby="modalPersonasAlDiaLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg"role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-green">
                            <h2 class="modal-title" id="modalPersonasAlDiaLabel"><center>Personas al día</center></h2>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12  table-responsive">
                                <table class="table table-bordered table-striped" id="tablaPersonasAlDia">
                                  <thead>
                                    <tr>
                                      <th class="text-center">RUT</th>
                                      <th class="text-center">Folio</th>
                                      <th class="text-center">Paciente</th>
                                      <th class="text-center">Última atención</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </ul>
              </div>

              <div class="box-footer">
                
              </div>
            </div>
        </div>
      @endif
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-header text-center">
            <strong>Información de las sucursales</strong>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="tablaSucursal">
              <thead>
                <tr>
                  <th class="text-center">Sucursal</th>
                  <th class="text-center">Teléfono</th>
                  <th class="text-center">WhatsApp</th>
                  <th class="text-center">Dirección</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

@endsection

@section('scripts')
@parent

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token                =  "{{ csrf_token() }}";

    var date  = new Date();
    /*Miércoles, 09 de enero de 2019 - 9:00 AM*/
    var days  = ["Domingo", "Lunes","Martes","Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

    setInterval(function() {
      var minuto = 0;
      var hora = 0;
      var dia = 0;
      console.log();
        date.setSeconds(date.getSeconds() + 1);
        var meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

        if (date.getMinutes() < 10) {
          minuto = '0' + date.getMinutes();
        }else{
          minuto = date.getMinutes();
        }

        if (date.getHours() < 10) {
          hora = '0' + date.getHours();
        }else{
          hora = date.getHours();
        }

        if (date.getDate() < 10) {
          dia = '0' + date.getDate();
        }else{
          dia = date.getDate();
        }

        $('#fecha_hora').html(days[date.getDay()] + ', ' + dia +' de ' + meses[date.getMonth()] + ' de ' + date.getFullYear() + '<br>' + hora +':' +minuto);
    }, 1000);

    function limpiar() {      
      $('#rutT').val(null);
      $('#nombrePacienteT').val(null);
      $('#telefonoT').val(null);
      $("#tipo_tratamientoT").val(null); 
    }

    $(document).ready(function() {
      var rutT    = $('#rutT').val();
      var nfolioT = $('#nfolioT').val();
      var tipo_tratamientoT = $('#tipo_tratamientoT').val();

      $('#fecha_nacimientoN').datepicker({
        format: "dd/mm/yyyy",
        language: 'es',
        todayHighlight: true,
        autoclose: true,
      });

      $('#tablaSucursal').DataTable({
        paging: true,
        processing: true,
        pageLength: 10,
        searching   : true,
        language: {
                    "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                  },
        order: [[ 0, "asc" ]],
        colReorder: true,
        ajax: {
            url: "{{ url('sucursales.getTabla') }}",
            type: "POST",
            data:{
                    "_token" : token,                     
                },
        },  
        columns: [
                {class : "text-center",
                 data: 'nombre'},
                {class : "text-center",
                 data: 'telefono'},
                {class : "text-center",
                 data: 'whatsapp'},
                {class : "text-center",
                 data: 'direccion'}
            ],
      });

      $('#tablaPersonasAlDia').DataTable({
        paging: true,
        processing: true,
        pageLength: 10,
        searching   : true,
        language: {
                    "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                  },
        order: [ 0, "asc" ],
        colReorder: true,
        ajax: {
            url: "{{ url('home.cargarTablePersonasAlDia') }}",
            type: "POST",
            data:{
                    "_token" : token,                     
                },
        },
        columnDefs: [
                    { targets: 3, render: $.fn.dataTable.render.moment('YYYY/MM/DD', 'DD-MM-YYYY') }
        ],     
        columns : [
                    {class : "text-center",
                     data: 'detalle_rut'},
                    {class : "text-center",
                     data: 'detalle_folio'},
                    {class : "text-center",
                     data: 'paciente'},
                    {class : "text-center",
                     data: 'ultima_atencion'}
                  ],
        colReorder: true
      });

      $('#rutT').keypress(function(e) {
        if(e.which == 13) {
          $('#busquedar_ahora').click();
        }
      });

      $('#cancelar_busqueda').click(function(e) {
        limpiar();
      });

      $('#limpiar_button').click(function(e) {
        limpiar();
      });

      $('#tablaPersonasConDeudas').DataTable({
        paging: true,
        processing: true,
        pageLength: 10,
        searching   : true,
        language: {
                    "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                  },
        order: [ 0, "asc" ],
        ajax: {
            url: "{{ url('home.cargarTablePersonasDeudas') }}",
            type: "POST",
            data:{
                    "_token" : token,                     
                },
        },
        columnDefs: [
                    { targets: 3, render: $.fn.dataTable.render.moment('YYYY/MM/DD', 'DD-MM-YYYY') }
        ],     
        columns : [
                    {class : "text-center",
                     data: 'detalle_rut'},
                    {class : "text-center",
                     data: 'detalle_folio'},
                    {class : "text-center",
                     data: 'paciente'},
                    {class : "text-center",
                     data: 'ultima_atencion'},
                    {class : "text-center",
                     data: 'deuda'}
                  ],
        colReorder: true
      });

      $('#tablaPersonasConAtraso').DataTable({
        paging: true,
        processing: true,
        pageLength: 10,
        searching   : true,
        language: {
                    "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                  },
        order: [ 0, "asc" ],
        ajax: {
            url: "{{ url('home.cargarTablePersonasAtrasado') }}",
            type: "POST",
            data:{
                    "_token" : token,                     
                },
        },
        columnDefs: [
                    { targets: 3, render: $.fn.dataTable.render.moment('YYYY/MM/DD', 'DD-MM-YYYY') }
        ],     
        columns : [
                    {class : "text-center",
                     data: 'detalle_rut'},
                    {class : "text-center",
                     data: 'detalle_folio'},
                    {class : "text-center",
                     data: 'paciente'},
                    {class : "text-center",
                     data: 'ultima_atencion'},
                    {class : "text-center",
                     data: 'deuda'}
                  ],
        colReorder: true
      });

      var tableTratamiento = $('#tableTratamiento').DataTable({
        processing: true,
        pageLength: 10,
        searching   : false,
        language: { "url": '{!! asset('/plugins/datatables/latino.json') !!}' },
        order: [ 0, "asc" ],
        colReorder: true,
        ajax: {
              url: "{{ url('tratamiento.getTabla') }}",
              type: "POST",
              data:{
                      rut_paciente        : rutT,
                      "_token"  : token,                     
                  },
          },
        columns: [
                  {class : "text-center",
                   data: 'folio'},
                  {class : "text-center",
                   data: 'nombre'},
                  {class : "text-center",
                   data: 'tipo'},
                  {class : "text-center",
                   data: 'rut'},
                  {class : "text-center",
                   data: 'paciente'},
                  {class : "text-center",
                   data: 'numero'},
                  @if(Auth::user()->perfil_id == 3)
                    {class : "text-center",
                      data: 'valor'},
                    {class : "text-center",
                     data: 'deuda'},
                  @endif
                  {class : "text-center",
                   data: 'action', name: 'action', orderable: false, searchable: false}
              ]
        });

      $('#busqueda_button').click(function(e) {
        $('#div_tabla_busqueda').addClass('hidden');
      });

      $('#busquedar_ahora').click(function(e) {
        rutT    = $('#rutT').val();
        nfolioT = $('#nfolioT').val();
        tipo_tratamientoT = $('#tipo_tratamientoT').val();

        $('#div_tabla_busqueda').removeClass('hidden');


        $.ajax({
          url: "{{ url('tratamiento.getTabla') }}",
          type: "POST",
          data:{
                  rut_paciente        : rutT,
                  tipo                : tipo_tratamientoT,
                  home_secretaria     : true,
                  "_token"  : token,                     
              },
        })
        .done(function(data) {
          tableTratamiento.clear().draw();
          $.each(data.data, function(index, val) {
            $('#rutT').val(val.rut);
            $('#nombrePacienteT').val(val.paciente);
            $('#telefonoT').val(val.telefono);
            $('#nfolioT').val(val.folio);
            $('#nombreTratamientoT').val(val.nombre);
            $('#controlesT').val(val.numero);
            tableTratamiento.row.add( val ).draw().node();
          });
        })
        .fail(function(data) {
          console.log(data);
        });
        
      });
    });
  </script>

@endsection