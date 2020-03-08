@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Reporte atenciones por periodo
@endsection

@section('contentheader_title')
  Reporte atenciones por periodo
@endsection

@section('breadcrumb_nivel')  
  <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
  <li>{{ trans('adminlte_lang::message.reports') }}</li>
  <li class="active">Reporte atenciones por periodo</li>
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
            <div class="col-md-6 col-sn-6 col-xs-6">
              {!! Form::label('fechahasta', 'Fecha desde:', ['for' => 'fechahasta'] ) !!}
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
          Gráfico por periodo
        </div>
        <div class="box-body">
          <div class="chart" id="bar-chart1" style="height: 250px;"></div>
        </div>
      </div>
    </div>     
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          Reporte de atenciones por periodo
        </div>
        <div class="box-body table-responsive">
          {!! Form::open(['route' => 'reportes.getAtencionPeriodo', 'method' => 'POST']) !!}
          {!! Form::text('desdeExcel', null , ['class' => 'hidden', 'id' => 'desdeExcel'] ) !!}
          {!! Form::text('hastaExcel', null , ['class' => 'hidden', 'id' => 'hastaExcel'] ) !!}
          {!! Form::text('tipo', 'excel' , ['class' => 'hidden', 'id' => 'tipo'] ) !!}
          <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
            <span class="fa fa-download"></span>
          </button>
          {!! Form::close() !!}
          <br>
          <table class="table table-bordered table-striped" id="TablaAtencionPeriodo">
            <thead>
              <tr>
                <th class="text-center">Mes</th>
                <th class="text-center">Año</th>
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
    var token      =  "{{ csrf_token() }}";
    var fechadesde = $('#fechadesde').val();
    var fechahasta = $('#fechahasta').val();

    function limpiarSelects() {
      $("#fechadesde").removeAttr('value');
      $("#fechahasta").removeAttr('value');
    }

     function GuardarValores(){
      var desdeExcel = $('#fechadesde').val();
      var hastaExcel = $('#fechahasta').val();

      if(desdeExcel != ''){
          $('#desdeExcel').val(desdeExcel);
      }
    
      if(hastaExcel != ''){
          $('#hastaExcel').val(hastaExcel);
      }
    }

    $(document).ready(function() {
      var datosGrafico = [];

      $.ajax({
        url: "{{ url('reportes.getAtencionPeriodo') }}",
        data    : { 
          fechadesde : fechadesde,
          fechahasta : fechahasta,
          tipo       : 'grafico',
          "_token"   : token
        },
        type: "POST"
      })

      .done(function(data) {
        var mes = '';
        $.each(JSON.parse(data.atencionpormes), function(index, val) {
          $.each(val, function(index2, val2) {
            if (index2 == "1") {
              mes = 'Enero ' + index;
            }else if (index2 == "2") {
              mes = "Febrero " +  index; 
            }else if (index2 == "3") {
              mes = "Marzo " +  index;
            }else if (index2 == "4") {
              mes = "Abril " +  index;
            }else if (index2 == "5") {
              mes = "Mayo " +  index;
            }else if (index2 == "6") {
              mes = "Junio " +  index;
            }else if (index2 == "7") {
              mes = "Julio " +  index;
            }else if (index2 == "8") {
              mes = "Agosto " +  index;
            }else if (index2 == "9") {
              mes = "Septiembre " +  index;
            }else if (index2 == "10") {
              mes = "Octubre " +  index;
            }else if (index2 == "11") {
              mes = "Noviembre " +  index;
            }else if (index2 == "12") {
              mes = "Diciembre " +  index;
            }
            datosGrafico.push({'mes' : mes, 'atenciones' : val2 });
          });
        });


        console.log(datosGrafico);

        if (datosGrafico.length == 0) {
          console.log('aquí');
          var bar = new Morris.Bar({
            element: 'bar-chart1',
            resize: true,
            data: [{'mes' : 'Sin datos', 'atenciones' : 0 }],
            barColors: ['#05B151'],
            xkey: 'mes',
            ykeys: ['atenciones'],
            labels: ['Atenciones'],
            hideHover: 'auto'
          });
        }else{
          var bar = new Morris.Bar({
            element: 'bar-chart1',
            resize: true,
            data: datosGrafico,
            barColors: ['#05B151'],
            xkey: 'mes',
            ykeys: ['atenciones'],
            labels: ['Atenciones'],
            hideHover: 'auto'
          });
        }
      })

      .fail(function(data) {
        console.log(data);
      });

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

      $('#TablaAtencionPeriodo').DataTable({
        processing: true,
        pageLength: 10,
        paginate: true,
        searching   : false,
        language: {
                    "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                  },
        order: [[ 1, "desc" ], [ 0, "desc" ] ],
        columnDefs: [
          { type: 'date-range', targets: 0 }
        ],
        ajax: {
            url: "reportes.getAtencionPeriodo",
            type: "POST",
            data    : { 
              fechadesde : fechadesde,
              fechahasta : fechahasta,
              tipo       : 'table',
              "_token"   : token
            },
            type: "POST",
            dataType: "json"
        },
        columns: [
          {
            class : "text-center",
            data: 'mes'
          },
          {
            class : "text-center",
            data: 'year'
          },
          {
            class : "text-center",
            data: 'atenciones'
          }
        ],
        colReorder: true,
      });
    });

  </script>

@endsection