@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Detalle tratamiento
@endsection

@section('contentheader_title')
  Detalle tratamiento
@endsection

@section('breadcrumb_nivel')  
    <li><a href="javascript:history.back()"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.atencion') }}</li>
    <li class="active">Detalle tratamiento</li>
@endsection

@section('main-content')
    <a class="btn btn-default"  href="javascript:history.back()" role="button">Volver</a>

    @if(Auth::user()->perfil_id <= 3)
      <a class="btn btn-success"  href="{{ url('/RegistrarAtencion/'.$tratamiento->folio) }}" role="button">Registrar atención</a>
      <a class="btn btn-info"  href="{{ url('/RegistrarReserva/'.$tratamiento->folio) }}" role="button">Realizar reserva</a>
    @endif
    <br>
    <br>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
       <div class="box box-info">
          <div class="box-header">
            Búsqueda
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                {!! Form::label('n_folio', 'N° folio:', ['for' => 'n_folio'] ) !!}
                {!! Form::text('n_folio', $tratamiento->folio , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de folio', 'maxLenght' => '11', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
              </div>
              <div class="col-md-3">
                {!! Form::label('tratamiento', 'Tratamiento:', ['for' => 'tratamiento'] ) !!}
                {!! Form::text('tratamiento', $tratamiento->nombre , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe el apellido paterno', 'maxlength' => '50']  ) !!}
              </div>
              <div class="col-md-3">
                {!! Form::label('paciente', 'Nombre paciente:', ['for' => 'paciente'] ) !!}
                {!! Form::text('paciente', $paciente , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe nombre paciente', 'maxlength' => '50']  ) !!}
              </div>
              <div class="col-md-3">
                {!! Form::label('total', 'Tipo de tratamiento:', ['for' => 'total'] ) !!}
                {!! Form::text('total', $tipo_tratamiento->nombre , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingresa el monto total', 'maxlength' => '50']  ) !!}
              </div>
            </div>
            <br>
            <div class="row">
              @if(Auth::user()->perfil_id != 4)
                <div class="col-md-3">
                  {!! Form::label('total', 'Valor total:', ['for' => 'total'] ) !!}
                  {!! Form::text('total', '$ '.$tratamiento->valor , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingresa el monto total', 'maxlength' => '50']  ) !!}
                </div>
              @endif
              <div class="col-md-3">
                {!! Form::label('controles', 'Controles:', ['for' => 'controles'] ) !!}
                {!! Form::text('controles', $tratamiento->num_control , ['class' => 'form-control', 'disabled', 'placeholder' => 'Escribe número de controles', 'maxlength' => '50']  ) !!}
              </div>
              @if(Auth::user()->perfil_id != 4)
                <div class="col-md-3">
                  {!! Form::label('pagado', 'Abono:' ) !!}
                  {!! Form::text('pagado', '$ '.$tratamiento->pagado , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingresa el monto pagado', 'maxlength' => '50']  ) !!}
                </div>
                @if($tratamiento->estado_deuda == "debe")
                  <div class="form-group has-error col-md-3">
                    {!! Form::label('deuda', 'Deuda:' ) !!}
                    {!! Form::text('deuda', '$ '.$tratamiento->deuda , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingresa el monto de deuda', 'maxlength' => '50']  ) !!}
                  </div>
                @else
                  <div class="form-group has-success col-md-3">
                    {!! Form::label('deuda', 'Deuda:' ) !!}
                    {!! Form::text('deuda', '$ '.$tratamiento->deuda , ['class' => 'form-control', 'disabled', 'placeholder' => 'Ingresa el monto de deuda', 'maxlength' => '50']  ) !!}
                  </div>
                @endif
              @endif
            </div>
          </div>
          </div>
        </div>
      </div>     

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-header">
            Detalle de atenciones
          </div>
          <div class="box-body table-responsive">
            {!! Form::open([ 'route' => 'tratamiento.exportAtencionesExcel', 'method' => 'POST']) !!}
              {!! Form::text('folioExcel', null , ['class' => 'hidden', 'id' => 'folioExcel'] ) !!}
              <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                  <span class="fa fa-download"></span>
              </button>
            {!! Form::close() !!}
            <br>
            <table class="table table-bordered table-striped" id="tableTratamiento">
              <thead>
                  <tr>
                      <th class="text-center">N° control</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Hora</th>
                      <th class="text-center">Profesional</th>                 
                      @if(Auth::user()->perfil_id != 4)
                        <th class="text-center">Abono</th>
                      @endif
                      <th class="text-center">Acciones</th>
                  </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
          <div class="box-footer">
            <a href="javascript:history.back()" role="button" class="btn btn-default pull-left">Volver</a>
          </div>
        </div>
      </div>     
    </div>


@endsection

@section('scripts')
@parent

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token   =  "{{ csrf_token() }}";
    var folio   =  $('#n_folio').val();

    function GuardarValores(){
      var folioExcel = folio;

    
      if(folioExcel != ''){
          $('#folioExcel').val(folioExcel);
      }
    
    }
        
    $(document).ready(function() {
        
        $('#fechadesdeChrome').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true
        });  
        $('#fechahastaChrome').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true
        });   

        $('#tableTratamiento').DataTable({
          processing: true,
          pageLength: 10,
          searching   : false,
          language: {
                      "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                    },
          order: [ 0, "asc" ],
          ajax: {
              url: "{{ url('tratamiento.getTableAtenciones')}}",
              type: "POST",
              data:{
                      folio     : folio,
                      "_token" : token,                     
                    },
          },
          columns: [
                  {class : "text-center",
                   data: 'num_atencion'},
                  {class : "text-center",
                   data: 'fecha'},
                  {class : "text-center",
                   data: 'hora'},
                  {class : "text-center",
                   data: 'profesional'},
                  @if(Auth::user()->perfil_id != 4)
                    {class : "text-center",
                     data: 'abono'},
                  @endif
                  {class : "text-center",
                   data: 'action'}
              ],
          colReorder: true,
        });
    });
  </script>

@endsection