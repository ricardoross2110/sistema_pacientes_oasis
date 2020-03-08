@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
    Reportes General
@endsection

@section('breadcrumb_nivel')
    <li><a href="{{ url('/login') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>  
@endsection

@section('main-content')
 
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Búsqueda</h3>
          </div>
          <div class="box-body">
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>{{ $nuevos_clientes_mes }}<sup style="font-size: 20px"></sup></h3>
                  <p>Nuevos Clientes Mes en Curso</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ url('/MisClientes/') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-xs-6">
             <div class="small-box bg-green">
                <div class="inner">
                  <h3>{{ $nuevos_clientes_ano }}<sup style="font-size: 20px"></sup></h3>
                  <p>Nuevos Clientes Año en Curso</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ url('/MisClientes/') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>{{ $clientes_proximos_compra }}<sup style="font-size: 20px"></sup></h3>
                  <p>Clientes Próximos a Compra</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ url('home#datosClientes') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{ $clientes_compra_vencida }}<sup style="font-size: 20px"></sup></h3>
                  <p>Clientes Compra Vencida</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ url('home#datosClientes') }}" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Cantidad de Repartos y Ventas Mensuales por Móvil</h3>
          </div>
          <div class="box-body">
            <div class="box-body chart-responsive">
              <div class="chart" id="bar-chart1" style="height: 250px;"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Clientes con mas Compras</h3>
          </div>
          <div class="box-body">
            <div class="box-body chart-responsive">
              <div class="chart" id="bar-chart2" style="height: 250px;"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Resumen Ventas por Canal de Ventas</h3>
          </div>
          <div class="box-body">
            <div class="box-body chart-responsive">
              <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Promedio Ventas por Dia de Semana</h3>
          </div>
          <div class="box-body">
            <div class="box-body chart-responsive">
              <div class="chart" id="bar-chart12" style="height: 300px;"></div>
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
    $(function () {
    "use strict";

    //BAR CHART 1
    var bar = new Morris.Bar({
      element: 'bar-chart1',
      resize: true,
      data: [
        @foreach ($cantidadrepartos as $key => $value)
          {y: '{{ $value->nombre }}', a: {{ $value->repartos }}, b: {{ $value->unidades_vendidas }} },
        @endforeach
      ],
      barColors: ['#fcce01', '#4D4D4D'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Repartos', 'Unidades Vendidas'],
      hideHover: 'auto'
    });
    var bar = new Morris.Bar({
      element: 'bar-chart12',
      resize: true,
      data: [
      @foreach ($promedioventasporsemana as $diasemana)
        {y: '{{ $diasemana->dia_semana }}', a: {{ $diasemana->ventas }} },
      @endforeach
      ],
      barColors: ['#fcce01', '#4D4D4D'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Ventas'],
      hideHover: 'auto'
    });
    var bar = new Morris.Bar({
      element: 'bar-chart2',
      resize: true,
      data: [
        @foreach ($clientescompras as $key => $value)
          {y: "{{ $value->nombres.' '.$value->apellido_paterno.' '.$value->apellido_materno }}", id: '{{ $value->rut_cliente }}', a: {{ $value->cantidad }}},
        @endforeach
      ],
      barColors: ['#fcce01'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Unidades Compradas'],
      hideHover: 'auto'
    }).on('click', function (i, row) {  
      displayData(i, row.id);
    });
    // Index of element to select
    var i = 2;
    @if(count($clientescompras) > 0)
      function displayData(i, row) {
          var url= 'MisClientes/' + row;
          window.open(url, "_self");
      };
    @endif
})

  var donut = new Morris.Donut({
    element: 'sales-chart',
    resize: true,
    colors: ['#bd0303',  '#1c03bd', '#a14b04', '#00a56f', '#dfca00', '#6c0a98', '#0096ab', '#00b67a', '#535354'],
    data: [
      @foreach ($resumencanalventas as $key => $value)
        {label: '{{ $value->canal }}', value: {{ $value->cantidad }}},
      @endforeach
    ],
    hideHover: 'auto'
  });

  </script>

@endsection