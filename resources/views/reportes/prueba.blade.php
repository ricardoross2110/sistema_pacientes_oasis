@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Gráficos de prueba
@endsection

@section('contentheader_title')
  Gráficos de prueba
@endsection

@section('breadcrumb_nivel')  
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.reports') }}</li>
    <li class="active">{{ trans('adminlte_lang::message.reporteingreso') }}</li>
@endsection

@section('main-content')
 
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="box box-info">
            <div class="box-body table-responsive">
              <div class="row">
                <div class="col-md-4">
                    <label>Fecha desde:</label>
                    {!! Form::text('fechadesdeChrome', '', ['class' => 'form-control pull-right', 'id' => 'fechadesdeChrome', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ) !!}
                </div>
                <div class="col-md-4">
                    <label>Fecha hasta:</label>
                    {!! Form::text('fechahastaChrome', '' , ['class' => 'form-control pull-right', 'id' => 'fechahastaChrome', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ) !!}
                </div>
              </div>
            </div>
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
              Gráfico por periodo
            </div>
            <div class="box-body">
              <div class="chart" id="bar-chart5" style="height: 250px;"></div>
            </div>
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
              <div class="chart" id="bar-chart2" style="height: 250px;"></div>
            </div>
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
              <div class="chart" id="bar-chart3" style="height: 250px;"></div>
            </div>
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
              <div class="chart" id="bar-chart4" style="height: 250px;"></div>
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

      var bar = new Morris.Bar({
        element: 'bar-chart1',
        resize: true,
        data: [
          {y: 'Enero', a: '30', b: '25', c: '15'},
          {y: 'Febrero', a: '20', b: '25', c: '15'},
          {y: 'Marzo', a: '18', b: '25', c: '15'},
          {y: 'Abril', a: '8', b: '25', c: '15'},
          {y: 'Mayo', a: '3', b: '25', c: '15'},
          {y: 'Junio', a: '9', b: '25', c: '15'},
          {y: 'Julio', a: '11', b: '25', c: '15'},
          {y: 'Agosto', a: '21', b: '25', c: '15'},
          {y: 'Septiembre', a: '15', b: '25', c: '15'},
          {y: 'Octubre', a: '20', b: '25', c: '15'},
          {y: 'Noviembre', a: '19', b: '25', c: '15'},
          {y: 'Diciembre', a: '17', b: '25', c: '15'},
        ],
        barColors: ['#416BAF', '#05B151', '#2A9092'],
        xkey: 'y',
        ykeys: ['a','b','c'],
        labels: ['Atenciones','otro','otro'],
        hideHover: 'auto'
      });

      var bar2 = new Morris.Bar({
        element: 'bar-chart5',
        resize: true,
        data: [
          {y: 'Enero', a: '60'},
          {y: 'Febrero', a: '50'},
          {y: 'Marzo', a: '40'},
          {y: 'Abril', a: '30'},
          {y: 'Mayo', a: '20'},
          {y: 'Junio', a: '10'},
          {y: 'Julio', a: '10'},
          {y: 'Agosto', a: '20'},
          {y: 'Septiembre', a: '30'},
          {y: 'Octubre', a: '40'},
          {y: 'Noviembre', a: '50'},
          {y: 'Diciembre', a: '60'},
        ],
        barColors: ['#416BAF'],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Atenciones'],
        hideHover: 'auto'
      });

      var bar2 = new Morris.Bar({
        element: 'bar-chart2',
        resize: true,
        data: [
          {y: 'Enero', a: '30'},
          {y: 'Febrero', a: '20'},
          {y: 'Marzo', a: '30'},
          {y: 'Abril', a: '20'},
          {y: 'Mayo', a: '30'},
          {y: 'Junio', a: '20'},
          {y: 'Julio', a: '30'},
          {y: 'Agosto', a: '20'},
          {y: 'Septiembre', a: '30'},
          {y: 'Octubre', a: '20'},
          {y: 'Noviembre', a: '30'},
          {y: 'Diciembre', a: '20'},
        ],
        barColors: ['#05B151'],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Atenciones'],
        hideHover: 'auto'
      });

      var bar2 = new Morris.Bar({
        element: 'bar-chart3',
        resize: true,
        data: [
          {y: 'Enero', a: '10'},
          {y: 'Febrero', a: '20'},
          {y: 'Marzo', a: '30'},
          {y: 'Abril', a: '40'},
          {y: 'Mayo', a: '50'},
          {y: 'Junio', a: '60'},
          {y: 'Julio', a: '60'},
          {y: 'Agosto', a: '50'},
          {y: 'Septiembre', a: '40'},
          {y: 'Octubre', a: '30'},
          {y: 'Noviembre', a: '20'},
          {y: 'Diciembre', a: '10'},
        ],
        barColors: ['#2A9092'],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Atenciones'],
        hideHover: 'auto'
      });
      var bar2 = new Morris.Donut({
        element: 'bar-chart4',
        resize: true,
        colors: ["#05B151", "#416BAF", "#2A9092"],
        data: [
          {label: "Tratamiento Brackets", value: 65},
          {label: "Limpieza dental", value: 25},
          {label: "Otros", value: 10}
        ],
        hideHover: 'auto'
      });
        $('#fechadesdeChrome').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            //hora_inicioDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });  
        $('#fechahastaChrome').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            //hora_inicioDate: new Date(),
            todayHighlight: true,
            autoclose: true
        });   

  </script>

@endsection