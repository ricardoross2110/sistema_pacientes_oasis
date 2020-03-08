@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.regatencion') }}
@endsection

@section('contentheader_title')
  {{ trans('adminlte_lang::message.regatencion') }}
@endsection

@section('breadcrumb_nivel')  
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.atencion') }}</li>
    <li class="active">{{ trans('adminlte_lang::message.regatencion') }}</li>
@endsection

@section('main-content')
  <div>
    <!-- Este botón sólo aparece si el usuario es secretaria o asistente -->
    <a class="btn btn-default" href="javascript:history.back()" role="button">Volver</a>
  </div>

  <br>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-body">
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div id="mensajeTratamiento">

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-2">
                  {!! Form::label('n_folio', 'N° folio:', ['for' => 'n_folio'] ) !!}
                  @if(isset($folio))
                      <!-- Si existe un folio -->
                      {!! Form::text('n_folio', $folio, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off']  ) !!}
                  @else
                    <!-- Si no existe un folio -->
                    @if(!isset($reserva))
                      {!! Form::text('n_folio', null , ['class' => 'form-control', 'placeholder' => 'Escribe número de folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off']  ) !!}
                    @else
                      {!! Form::select('n_folio', $tratamientos_folio, null, array('class' => 'form-control folio_select', 'data-placeholder' => 'Seleccione folio', 'style' => 'width: 100%' )) !!}
                    @endif
                  @endif
                </div>
                <div class="col-md-4">
                  {!! Form::label('tratamiento', 'Tratamiento:', ['for' => 'tratamiento'] ) !!}
                  @if(isset($folio))
                    <!-- Si existe folio se completa con el respectivo nombre -->
                    {!! Form::text('tratamiento', $tratamiento->nombre, ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el nombre de tratamiento', 'maxlength' => '50']  ) !!}
                  @else
                    <!-- Si no existe folio -->
                    {!! Form::text('tratamiento', null , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el nombre de tratamiento', 'maxlength' => '50']  ) !!}
                  @endif
                </div>
                <div class="col-md-4">
                  {!! Form::label('paciente', 'Nombre paciente:', ['for' => 'paciente'] ) !!}
                  @if(isset($folio))
                    <!-- Si existe folio se completa con el respectivo nombre -->
                    {!! Form::text('paciente', $paciente->nombres.' '.$paciente->apellido_paterno.' '.$paciente->apellido_materno , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre paciente', 'maxlength' => '50']  ) !!}
                  @else
                    @if(isset($reserva))
                      <!-- Si existe folio se completa con el respectivo nombre -->
                      {!! Form::text('paciente', $paciente->nombres.' '.$paciente->apellido_paterno.' '.$paciente->apellido_materno , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre paciente', 'maxlength' => '50']  ) !!}
                    @else
                      <!-- Si no existe folio -->
                      {!! Form::text('paciente', null , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre paciente', 'maxlength' => '50']  ) !!}
                    @endif
                  @endif
                </div>
                <div class="col-md-2">
                  {!! Form::label('controles', 'Controles:', ['for' => 'controles'] ) !!}
                  @if(isset($folio))
                    <!-- Si existe folio se completa con el respectivo número -->
                    {!! Form::text('controles', $tratamiento->num_control , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ) !!}
                  @else
                    <!-- Si no existe folio -->
                    {!! Form::text('controles', null , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ) !!}
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
    @if(!isset($folio) && !isset($reserva))
    <div id="div_nuevaAtencion" class="row hidden">
    @else
    <div class="row">
    @endif
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            Nueva atención
          </div>
          <div class="box-body table-responsive">
            <div class="box-body">
              <div class="row">
                <div class="form-group col-md-2">
                  {!! Form::label('n_atencion', 'N° atención:', ['for' => 'n_atencion'] ) !!}
                  @if(isset($folio))
                    <!-- Si existe folio se completa con el respectivo número -->
                    {!! Form::text('n_atencion', $n_atencion, ['class' => 'form-control', 'disabled', 'placeholder' => 'Número de atención', 'maxlength' => '50']  ) !!}
                  @else
                    <!-- Si no existe folio -->
                    {!! Form::text('n_atencion', null , ['class' => 'form-control', 'disabled', 'placeholder' => 'Número de atención', 'maxlength' => '50']  ) !!}
                  @endif
                </div>
                <div class="form-group col-md-2">
                  {!! Form::label('fecha', 'Fecha:', ['for' => 'fecha'] ) !!}
                  {!! Form::text('fecha', $fecha , ['class' => 'form-control', 'disabled', 'placeholder' => 'Hora de atencion', 'maxlength' => '50']  ) !!}
                </div>
                <div class="form-group col-md-2">
                  {!! Form::label('hora', 'Hora:', ['for' => 'hora'] ) !!}
                  {!! Form::text('hora', $hora , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el correo', 'maxlength' => '50']  ) !!}
                </div>
                <div class="form-group col-md-6">
                  {!! Form::label('sucursal', 'Sucursal:', ['for' => 'sucursal'] ) !!}
                  @if(isset($reserva))
                    {!! Form::select('sucursal', $sucursales, $sucursalSelect, array('class' => 'form-control', 'placeholder' => 'Seleccione sucursal')) !!}
                  @else
                    {!! Form::select('sucursal', $sucursales, null, array('class' => 'form-control', 'placeholder' => 'Seleccione sucursal')) !!}
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if(!isset($reserva))
    <div id="div_profesional" class="row hidden">
    @else
    <div class="row">
    @endif
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="box box-info">
            <div class="box-header">
              Detalle
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">                
                  <h4><strong>Datos del Profesional</strong></h4>
                  <div id="mensajeProfesional">

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  {!! Form::label('nombreProfesional', 'Nombre:', ['for' => 'nombreProfesional'] ) !!}
                  <br>
                  @if(!isset($reserva))
                    {!! Form::select('nombreProfesional', [], null, array('class' => 'form-control profesional_select', 'data-placeholder' => 'Seleccione profesional', 'style' => 'width: 100%' )) !!}
                  @else
                    {!! Form::select('nombreProfesional', $profesionalesSelect, $reservas->profesional_rut, array('class' => 'form-control profesional_select', 'data-placeholder' => 'Seleccione profesional', 'style' => 'width: 100%' )) !!}
                  @endif
                </div>
                <div class="col-md-3">
                  {!! Form::label('profesion', 'Profesión:', ['for' => 'profesion'] ) !!}
                  @if(!isset($reserva))
                    {!! Form::text('profesion', '' , ['class' => 'form-control', 'disabled', 'placeholder' => 'Profesión', 'maxlength' => '50']  ) !!}
                  @else
                    {!! Form::text('profesion', $profesionales[0]->profesion , ['class' => 'form-control', 'disabled', 'placeholder' => 'Profesión', 'maxlength' => '50']  ) !!}
                  @endif
                </div>
                <div class="col-md-3">
                  {!! Form::label('cargoProfesional', 'Tipo contrato:', ['for' => 'cargoProfesional'] ) !!}
                  @if(!isset($reserva))
                    {!! Form::text('cargoProfesional', '' , ['class' => 'form-control', 'disabled', 'placeholder' => 'Tipo contrato', 'maxlength' => '50']  ) !!}
                  @else
                    {!! Form::text('cargoProfesional', $profesionales[0]->tipo , ['class' => 'form-control', 'disabled', 'placeholder' => 'Tipo contrato', 'maxlength' => '50']  ) !!}
                  @endif
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">                
                  <h4>
                    <strong>
                      {!! Form::label('observacion', 'Observaciones:' ) !!}
                    </strong>
                  </h4>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  @if(!isset($reserva))
                    {!! Form::textarea('observacion', null, ['rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%']) !!}
                  @else
                    {!! Form::textarea('observacion', $reservas->observacion, ['rows' => 10, 'cols' => 40, 'style' => 'resize:none; width: 100%']) !!}
                  @endif
                </div>
              </div>
            </div>
          </div>
      </div>     
    </div>

    @if(!isset($reserva))
    <div id="div_abono" class="row hidden">
    @else
    <div class="row">
    @endif
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="box box-info">
            <div class="box-header">
              <h3><strong>Realize abono</strong></h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">                  
                  <div class="row">
                    <div class="col-md-3 col-md-offset-2">
                      <strong>{!! Form::label('total', 'Total:', ['for' => 'total', 'class' => 'pull-right'] ) !!}</strong>
                    </div>
                    <div class="col-md-3">
                      @if(isset($tratamiento->tipo_tratamiento_id))
                        @if($tratamiento->tipo_tratamiento_id == 1)
                          <!-- Si el folio es generico valor de la atención es el valor del tratamiento -->
                          {!! Form::text('total', $tratamiento->valor , ['class' => 'form-control', 'disabled' ,'placeholder' => 'Ingrese Total', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}         
                        @else
                          {!! Form::text('total', null , ['class' => 'form-control',  'placeholder' => 'Ingrese Total', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
                        @endif
                      @else
                        {!! Form::text('total', null , ['class' => 'form-control',  'placeholder' => 'Ingrese Total', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
                      @endif
                      <br>
                      <div id="mensajePago">

                      </div>
                    </div>
                    <div class="col-md-3">
                      <button id="confirmarPago" class="btn btn-success">Confirmar Monto</button>
                      <button id="modificarPago" class="btn btn-warning hidden">Modificar Monto</button>
                    </div>
                  </div>      
                  <br>
                  <div id="divPago" class="hidden">
                    <div id="div_pago_1" class="row">
                      <div class="col-md-3 col-md-offset-2">
                        <strong>{!! Form::label('tipo_pago1', 'Seleccione Medio de pago:' ) !!}</strong>
                        {!! Form::select('tipo_pago1', $tipo_pagoSelect, null, array('class' => 'form-control', 'value' => 'Seleccione sucursal')) !!}
                      </div>
                      <div class="col-md-3">
                        <strong>{!! Form::label('pago1', 'Total:', ['for' => 'pago1'] ) !!}</strong>
                        {!! Form::number('pago1', '0', ['class' => 'form-control',  'placeholder' => 'Ingrese Total', 'max' => '9999999', 'min' => '0', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
                      </div>
                      <div class="col-md-3">
                        <h3></h3>
                        <button id="agregarPago1" class="btn btn-success">Agregar</button>
                        <button id="eliminarPago1" class="btn btn-danger hidden">Eliminar</button>
                      </div>
                    </div>
                    <br>
                    <div id="div_pago_2" class="row hidden">
                      <div class="col-md-3 col-md-offset-2">
                        {!! Form::select('tipo_pago2', $tipo_pagoSelect, null, array('id' => 'tipo_pago2', 'class' => 'form-control', 'value' => 'Seleccione sucursal')) !!}
                      </div>
                      <div class="col-md-3">
                        {!! Form::number('pago2', '0', ['id' => 'pago2', 'class' => 'form-control',  'placeholder' => 'Ingrese Total', 'max' => '9999999', 'min' => '0', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
                      </div>
                      <div class="col-md-3">
                        <button id="agregarPago2" class="btn btn-success hidden">Agregar</button>
                        <button id="eliminarPago2" class="btn btn-danger hidden">Eliminar</button>
                      </div>
                    </div>
                    <br>
                    <div id="div_pago_3" class="row hidden">
                      <div class="col-md-3 col-md-offset-2">
                        {!! Form::select('tipo_pago3', $tipo_pagoSelect, null, array('id' => 'tipo_pago3', 'class' => 'form-control', 'value' => 'Seleccione sucursal')) !!}
                      </div>
                      <div class="col-md-3">
                        {!! Form::number('pago3', '0', ['id' => 'pago3', 'class' => 'form-control',  'placeholder' => 'Ingrese Total', 'max' => '9999999', 'min' => '0', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
                      </div>
                      <div class="col-md-3">
                        <button id="agregarPago3" class="btn btn-success hidden">Agregar</button>
                        <button id="eliminarPago3" class="btn btn-danger hidden">Eliminar</button>
                      </div>
                    </div>
                    <br>
                    <div id="div_pago_4" class="row hidden">
                      <div class="col-md-3 col-md-offset-2">
                        {!! Form::select('tipo_pago4', $tipo_pagoSelect, null, array('id' => 'tipo_pago4', 'class' => 'form-control', 'value' => 'Seleccione sucursal')) !!}
                      </div>
                      <div class="col-md-3">
                        {!! Form::number('pago4', '0', ['id' => 'pago4', 'class' => 'form-control',  'placeholder' => 'Ingrese Total', 'max' => '9999999', 'min' => '0', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
                      </div>
                      <div class="col-md-3">
                        <button id="eliminarPago4" class="btn btn-danger hidden">Eliminar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-md-12">
                  <div id="mensajeAtencion">
                  </div>
                </div>
              </div>
              {!! Form::button('Pagar', array('id' => 'pagar', 'class' => 'btn btn-info pull-right hidden')) !!}
              <!-- Modal -->
              <div class="modal fade" id="reservaModal" tabindex="-1" role="dialog" aria-labelledby="reservaModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">                    
                    <div class="modal-header bg-aqua">
                      <center><h2 class="modal-title">¡Atención!</h2></center>
                    </div>

                    <div class="modal-bod text-center">
                      <h3>¿Desea crear una reserva?</h3>
                    </div>
                    
                    <div class="modal-footer">
                      <button id="no" class="btn btn-default" role="button">No</button>
                      <button id="si" class="btn btn-info" role="button">Si</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>     
    </div>
@endsection

@section('scripts')
@parent

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token                 =   "{{ csrf_token() }}";

    var tipo_pagos            =   [];
    var total;
    var total_pago;
    var total_restante;
    var pago1Guardado;
    var pago2Guardado;
    var pago3Guardado;
    var pago4Guardado;

    var selectPagos           =   "";

    @if(isset($tipo_pago))
      @foreach($tipo_pago as $pago)
        tipo_pagos.push('{{ $pago->id }}');
        selectPagos           =   selectPagos.concat('<option value="{{ $pago->id }}">{{ $pago->nombre }}</option>');
      @endforeach
    @endif

    function calcularTotal() {
      var total   =   $('#total').val();

      var pago1   =   $('#pago1').val();
      var pago2   =   $('#pago2').val();
      var pago3   =   $('#pago3').val();
      var pago4   =   $('#pago4').val();

      var total_pagado    =   parseInt(pago1) + parseInt(pago2) + parseInt(pago3) + parseInt(pago4);

      if (total == total_pagado) {
        $('#pagar').removeClass('hidden');
      }else{
        $('#pagar').addClass('hidden');
      }
    }

    function vaciarCampos() {
      $('#pago1').val('0');
      $('#pago2').val('0');
      $('#pago3').val('0');
      $('#pago4').val('0');

      $('#tipo_pago1 option').remove();    
      $('#tipo_pago2 option').remove();   
      $('#tipo_pago3 option').remove();   
      $('#tipo_pago4 option').remove(); 

      $('#tipo_pago1').append(selectPagos); 
      $('#tipo_pago2').append(selectPagos);
      $('#tipo_pago3').append(selectPagos);
      $('#tipo_pago4').append(selectPagos);

      $('#tipo_pago1').removeAttr('disabled');
      $('#tipo_pago2').removeAttr('disabled');
      $('#tipo_pago3').removeAttr('disabled');
      $('#tipo_pago4').removeAttr('disabled');
    }

    $(document).ready(function() {

      /*Buscar tratamiento*/
      @if(!isset($folio))
        $('#n_folio').keypress(function(e) {
          if(e.which == 13) {
            if ($(this).val() == '') {
              $('#mensajeTratamiento').html('');
              $('#mensajeTratamiento').html('<div class="alert alert-danger fade in"><strong>No ha ingresado número de folio</strong>.</div>');
            }else{
              $.ajax({
                url: '{{ url('/atencion.cargarAtencion') }}',
                type: 'post',
                datatype: 'json',
                data: {
                    n_folio   : $(this).val(),
                    "_token"  : token,
                },
              })
              .done(function(data) {
                if (data.reponse == "ok") {
                  $('#mensajeTratamiento').html('');
                  $('#tratamiento').val(data.tratamiento);
                  $('#paciente').val(data.paciente);
                  $('#controles').val(data.num_controles);
                  $('#div_nuevaAtencion').removeClass('hidden');
                  $('#n_atencion').val(data.n_atencion);
                }else if(data.reponse == "no_existe") {
                  $('#mensajeTratamiento').html('');
                  $('#mensajeTratamiento').html('<div class="alert alert-danger fade in"><strong>El número de folio que ingrersó no existe.</strong>.</div>');
                }else if(data.reponse == "folio_invalido") {
                  $('#mensajeTratamiento').html('');
                  $('#mensajeTratamiento').html('<div class="alert alert-danger fade in"><strong>El número de folio que ingrersó no es valido, debido a que se creó de forma generica.</strong>.</div>');
                }
              })
              .fail(function(data) {
                console.log(data);
              });
            }
          }
        });
      @endif

      $('.profesional_select').select2();

      @if(isset($reserva))
        $('.folio_select').select2();
        $('.folio_select').val(null).trigger('change');

        $('.folio_select').on('select2:select', function (e) {
          console.log($(this).val());
          
            $.ajax({
              url: '{{ url('/atencion.cargarAtencion') }}',
              type: 'post',
              datatype: 'json',
              data: {
                  n_folio   : $(this).val(),
                  "_token"  : token,
              },
            })
            .done(function(data) {
              if (data.reponse == "ok") {
                $('#mensajeTratamiento').html('');
                $('#tratamiento').val(data.tratamiento);
                $('#paciente').val(data.paciente);
                $('#controles').val(data.num_controles);
                $('#div_nuevaAtencion').removeClass('hidden');
                $('#n_atencion').val(data.n_atencion);
              }else if(data.reponse == "no_existe") {
                $('#mensajeTratamiento').html('');
                $('#mensajeTratamiento').html('<div class="alert alert-danger fade in"><strong>El número de folio que ingrersó no existe.</strong>.</div>');
              }else if(data.reponse == "folio_invalido") {
                $('#mensajeTratamiento').html('');
                $('#mensajeTratamiento').html('<div class="alert alert-danger fade in"><strong>El número de folio que ingrersó no es valido, debido a que se creó de forma generica.</strong>.</div>');
              }
            })
            .fail(function(data) {
              console.log(data);
            });
        });
      @endif

      /*Confirmar pago y activar botón de modificar*/
      $('#confirmarPago').click(function(e) {
        e.preventDefault();
        if ($('#total').val() != '') {
          if ($('#total').val() == '0') {
            $('#mensajePago').html('');
            $('#total').attr('disabled', true);
            $('#pagar').removeClass('hidden');
            $('#modificarPago').removeClass('hidden');
            $(this).addClass('hidden');
            total                = parseInt($('#total').val());
            total_restante       = parseInt($('#total').val());
          } else {
            $('#divPago').removeClass('hidden');
            $('#pago1').val($('#total').val());
            $('#agregarPago1').addClass('hidden');
            $('#eliminarPago1').addClass('hidden');
            $('#mensajePago').html('');
            $('#total').attr('disabled', true);
            $('#pagar').removeClass('hidden');
            $('#modificarPago').removeClass('hidden');
            $(this).addClass('hidden');
            total                = parseInt($('#total').val());
            total_restante       = parseInt($('#total').val());            
          }
        }else{
          $('#mensajePago').html('');
          $('#mensajePago').html('<div class="alert alert-danger fade in"><strong>El monto está en blanco</strong>, Ingrese un monto para confirmar.</div>');
        }
      });

      /*Modificar pago*/

      $('#modificarPago').click(function(e) {
        vaciarCampos();
        $('#divPago').addClass('hidden');
        $('#div_pago_2').addClass('hidden');
        $('#div_pago_3').addClass('hidden');
        $('#div_pago_4').addClass('hidden');
        $('#pagar').addClass('hidden');
        $('#confirmarPago').removeClass('hidden');
        $('#total').attr('disabled', false);
        $(this).addClass('hidden');
        $('#total').removeClass('hidden');
      });

      /*Pago 1*/
      $('#pago1').change(function(e) {
        total_pago  = parseInt($(this).val());

        if ($('#tipo_pago1').attr('disabled')) {
          var total_momentaneo = total_pago + total_restante;
          
          if (total < total_momentaneo) {
            $('#pago1').val(pago1Guardado);
          }
        }else{
          if(total_pago > total_restante) {
            $(this).val(total_restante);
            $('#agregarPago1').addClass('hidden');
          }else if(total_pago < total_restante){
            $('#agregarPago1').removeClass('hidden');
          }else if (total_pago < 0){
            $(this).val(0);
          }else if (total_pago == total_restante){
            $('#agregarPago1').addClass('hidden');
          }
        }

        pago1Guardado   =   parseInt($('#pago1').val());

        calcularTotal();
      });

      $('#agregarPago1').click(function(e) {
        e.preventDefault();
        total_restante = total_restante - total_pago;
        var tipo_pago   = $('#tipo_pago1').val();  

        /*Bloquear pago 1*/
        $('#tipo_pago1').attr('disabled', true);

        $(this).addClass('hidden');
        $('#div_pago_2').removeClass('hidden');
        $('#pago2').val(total_restante);
        $('#pagar').removeClass('hidden');
        $("#tipo_pago2 option[value='" + tipo_pago + "']").remove();
        $("#tipo_pago3 option[value='" + tipo_pago + "']").remove();
        $("#tipo_pago4 option[value='" + tipo_pago + "']").remove();
      });

      /*Pago 2*/
      $('#pago2').change(function(e) {
        total_pago  = parseInt($(this).val());

        if ($('#tipo_pago2').attr('disabled')) {
          var total_momentaneo = total_pago + total_restante;
          if (total < total_momentaneo) {
            $('#pago2').val(pago2Guardado);
          }
        }else{
          if(total_pago > total_restante) {
            $(this).val(total_restante);
            $('#agregarPago2').addClass('hidden');
          }else if(total_pago < total_restante){
            $('#agregarPago2').removeClass('hidden');
          }else if (total_pago < 0){
            $(this).val(0);
          }else if (total_pago == total_restante){
            $('#agregarPago2').addClass('hidden');
          }
        }

        pago2Guardado   =   parseInt($('#pago2').val());

        calcularTotal();
      });

      $('#agregarPago2').click(function(e) {
        e.preventDefault();
        total_restante = total_restante - total_pago;
        var tipo_pago   = $('#tipo_pago2').val();  

        /*Bloquear pago 1*/
        $('#tipo_pago2').attr('disabled', true);

        $(this).addClass('hidden');
        $('#div_pago_3').removeClass('hidden');
        $('#pago3').val(total_restante);
        $('#pagar').removeClass('hidden');
        $("#tipo_pago3 option[value='" + tipo_pago + "']").remove();
        $("#tipo_pago4 option[value='" + tipo_pago + "']").remove();
      });

      /*Pago 3*/
      $('#pago3').change(function(e) {
        e.preventDefault();
        total_pago  = parseInt($(this).val());

        if ($('#tipo_pago3').attr('disabled')) {
          var total_momentaneo = total_pago + total_restante;
          if (total < total_momentaneo) {
            $('#pago3').val(pago3Guardado);
          }
        }else{
          if(total_pago > total_restante) {
            $(this).val(total_restante);
            $('#agregarPago3').addClass('hidden');
          }else if(total_pago < total_restante){
            $('#agregarPago3').removeClass('hidden');
          }else if (total_pago < 0){
            $(this).val(0);
          }else if (total_pago == total_restante){
            $('#agregarPago3').addClass('hidden');
          }
        }

        pago3Guardado   =   parseInt($('#pago3').val());

        calcularTotal();
      });

      $('#agregarPago3').click(function(e) {
        total_restante = total_restante - total_pago;
        var tipo_pago   = $('#tipo_pago3').val();  

        /*Bloquear pago 1*/
        $('#tipo_pago3').attr('disabled', true);

        $(this).addClass('hidden');
        $('#div_pago_4').removeClass('hidden');
        $('#pago4').val(total_restante);
        $('#pagar').removeClass('hidden');
        $("#tipo_pago4 option[value='" + tipo_pago + "']").remove();
      });

      /*Pago 4*/
      $('#pago4').change(function(e) {
        e.preventDefault();
        total_pago  = parseInt($(this).val());
        if(total_pago > total_restante) {
          $(this).val(total_restante);
          $('#agregarPago3').addClass('hidden');
        }else if(total_pago < total_restante){
          $('#agregarPago3').removeClass('hidden');
        }else if (total_pago < 0){
          $(this).val(0);
        }else if (total_pago == total_restante){
          $('#agregarPago3').addClass('hidden');
        }

        pago3Guardado   =   parseInt($('#pago3').val());

        calcularTotal();
      });

      $('#sucursal').change(function(event) {

        $.ajax({
          type    : 'POST',
          url     : "{{ url('atencion.getProfesionales') }}",
          data    : {
                      sucursal_id : $(this).val(),
                      "_token"    : token,
                    },
          dataType: 'json'
        })
        .done(function(data) {
          var profesional_select      =   $('.profesional_select');
          profesional_select.empty().trigger("change");
          $.each(data.profesionales, function(index, val) {
            var option = new Option(val, index, false, false);
            profesional_select.append(option).trigger('change');
          });
          $('#div_profesional').removeClass('hidden');
          profesional_select.val(null).trigger('change');
        })
        .fail(function(data) {
          console.log(data);
        });
      });

      $('.profesional_select').on('select2:select', function (e) {
        console.log($(this).val());
        $.ajax({
          type    : 'POST',
          url     : "{{ url('atencion.getDatosProfesional') }}",
          data    : {
                      rut_profesional : $(this).val(),
                      "_token"    : token,
                    },
          dataType: 'json'
        })
        .done(function(data) {
          $('#div_abono').removeClass('hidden');
          $('#profesion').val(data.profesion);
          $('#cargoProfesional').val(data.tipo_contrato);
        })
        .fail(function(data) {
          console.log(data);
        });
      });

      $('#si').click(function(e) {
        var tratamiento_folio   = $('#n_folio').val();
        window.location.replace("/RegistrarReserva/" + tratamiento_folio);
      });

      $('#no').click(function(e) {
        var tratamiento_folio   = $('#n_folio').val();
        window.location.replace("/tratamiento/" + tratamiento_folio);
      });

      $('#pagar').click(function(e) {
        var num_atencion        = $('#n_atencion').val();
        var observacion         = $('#observacion').val();
        var fecha               = $('#fecha').val();
        var hora                = $('#hora').val();
        var tratamiento_folio   = $('#n_folio').val();
        var profesional_rut     = $('#nombreProfesional').val();
        var sucursal_id         = $('#sucursal').val();

        /*Abono*/
        var abono               = $('#total').val();

        /*Tipo de pago*/
        var tipo_pago1          =   $('#tipo_pago1').val();
        var tipo_pago2          =   $('#tipo_pago2').val();
        var tipo_pago3          =   $('#tipo_pago3').val();
        var tipo_pago4          =   $('#tipo_pago4').val();

        /*Pagos*/
        var pago1               =   $('#pago1').val();
        var pago2               =   $('#pago2').val();
        var pago3               =   $('#pago3').val();
        var pago4               =   $('#pago4').val();

        $.ajax({
          url: "{{ url("atencion.guardarAtencion") }}",
          type: 'post',
          dataType: 'json',
          data: {
            
                  @if(isset($reserva))
                    id_atencion       :   {{$id_atencion}},
                  @endif

                  num_atencion        :   num_atencion,
                  observacion         :   observacion,
                  fecha               :   fecha,
                  hora                :   hora,
                  tratamiento_folio   :   tratamiento_folio,
                  profesional_rut     :   profesional_rut,
                  sucursal_id         :   sucursal_id,
                  abono               :   abono,
                  tipo_pago1          :   tipo_pago1,
                  pago1               :   pago1,
                  tipo_pago2          :   tipo_pago2,
                  pago2               :   pago2,
                  tipo_pago3          :   tipo_pago3,
                  pago3               :   pago3,
                  tipo_pago4          :   tipo_pago4,
                  pago4               :   pago4,
                  "_token"                    : token
                },
        })
        .done(function(data) {
          if (data.tipo_mensaje == "error") {
            $('#mensajeAtencion').html('<div class="alert alert-danger">' + data.mensaje +'</div>');
          }else if (data.tipo_mensaje == "success") {
            $('#mensajeAtencion').html('<div class="alert alert-success">' + data.mensaje +'</div>');
            $("#pagar").attr('disabled', 'disabled');
            $("#mensajeAtencion").animate({
              marginTop:'toggle',
              display:'block'},
              2000, function() {
                $('#reservaModal').modal('show');
            });
          }
        })
        .fail(function(data) {
          console.log(data);
        });
      });
    });

  </script>

@endsection