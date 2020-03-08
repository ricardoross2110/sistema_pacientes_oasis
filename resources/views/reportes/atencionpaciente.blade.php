@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Reporte atenciones por paciente
@endsection

@section('contentheader_title')
  Reporte atenciones por paciente
@endsection

@section('breadcrumb_nivel')  
  <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
  <li>{{ trans('adminlte_lang::message.reports') }}</li>
  <li class="active">Reporte atenciones por paciente</li>
@endsection

@section('main-content')
 
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
     <div class="box box-info">
        <div class="box-header">
          Búsqueda
        </div>
        {{ Form::open(array('method' => 'GET')) }}
        <div class="box-body">
          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                {!! Form::label('fechadesde', 'Fecha desde:', ['for' => 'fechadesde'] ) !!}
                {!! Form::text('fechadesde', $fecha_inicio, ['class' => 'form-control pull-right', 'id' => 'fechadesde', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ) !!}
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                {!! Form::label('fechahasta', 'Fecha hasta:', ['for' => 'fechahasta'] ) !!}
                {!! Form::text('fechahasta', $fecha_fin , ['class' => 'form-control pull-right', 'id' => 'fechahasta', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ) !!}
            </div>
          </div>
        </div>
        <div class="box-footer">
            {!! Form::reset('Limpiar', array('onClick' => 'limpiarSelects()', 'class' => 'btn btn-default')) !!}
            {!! Form::submit('Buscar', array('class' => 'btn btn-info')) !!}
          </div>
        {{ Form::close() }}
      </div>
    </div>     
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          Reporte de atenciones por paciente
        </div>
        <div class="box-body table-responsive">
          {!! Form::open(['route' => 'reportes.getAtencionPaciente', 'method' => 'POST']) !!}
            {!! Form::text('desdeExcel', null , ['class' => 'hidden', 'id' => 'desdeExcel'] ) !!}
            {!! Form::text('hastaExcel', null , ['class' => 'hidden', 'id' => 'hastaExcel'] ) !!}
            {!! Form::text('pacienteExcel', null , ['class' => 'hidden', 'id' => 'pacienteExcel'] ) !!}
            {!! Form::text('tipo', 'excel' , ['class' => 'hidden', 'id' => 'tipo'] ) !!}
            <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                <span class="fa fa-download"></span>
            </button>
            <br>
          {!! Form::close() !!}
          <br>
          <br>
          <table class="table table-bordered table-striped" id="tablaAtencionPaciente">
            <thead>
                <tr>
                  <th class="text-center">Paciente</th>
                  <th class="text-center">Número de atenciones</th>
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

  <script type="text/javascript">
  
    var token                =  "{{ csrf_token() }}";
    var fechadesde           = $('#fechadesde').val();
    var fechahasta           = $('#fechahasta').val();
    var pacienteb            = [];

    function limpiarSelects() {
      $("#fechadesde").removeAttr('value');
      $("#fechahasta").removeAttr('value');
    }


    function GuardarValores(){
      var desdeExcel   =   $('#fechadesde').val();
      var hastaExcel   =   $('#fechahasta').val();
      var pacientesExcel = [];

      $.each($(".pacienteb option:selected"), function(){            
          pacientesExcel.push($(this).val());
      });

      pacientesExcel     =   JSON.stringify(pacientesExcel);

      if(desdeExcel != ''){
          $('#desdeExcel').val(desdeExcel);
      }
    
      if(hastaExcel != ''){
          $('#hastaExcel').val(hastaExcel);
      }

      $('#pacienteExcel').val(pacientesExcel);
    }
    
    $(document).ready(function() {

        $('#fechadesde').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            //hora_inicioDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });

        $('#fechahasta').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            //hora_inicioDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });   

        $('#tablaAtencionPaciente').DataTable({
            processing: true,
            pageLength: 10,
            searching   : true,
            language: {
                        "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                    },
            order: [ 1, "DESC"],
            ajax: {
                url: "reportes.getAtencionPaciente",
                type: "POST",
                data    : { 
                  fechadesde  : fechadesde,
                  fechahasta  : fechahasta,
                  paciente    : pacienteb,
                  tipo        : 'table',
                  "_token"    : token
                },
                type: "POST",
                dataType: "json"
            },
            columns: [
            {class : "text-center",
            data: 'paciente'},
            {class : "text-center",
            data: 'atenciones_realizadas'},
            ],
            colReorder: true,
        });
    });

  </script>

@endsection