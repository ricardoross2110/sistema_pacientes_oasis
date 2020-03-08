@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.dashboard') }}
@endsection

@section('contentheader_title')
  {{ trans('adminlte_lang::message.dashboard') }}
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
            <div class="box-header">
              Busqueda
            </div>
            <div class="box-body table-responsive">
              <div class="row">
                <div class="col-md-6">
                    <label>Fecha desde:</label>
                    {!! Form::text('fechadesdeChrome', '', ['class' => 'form-control pull-right', 'id' => 'fechadesdeChrome', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ) !!}
                </div>
                <div class="col-md-6">
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
              Reporte de ingresos por periodo
            </div>
            <div class="box-body table-responsive">
              {!! Form::open([ 'method' => 'POST']) !!}
                  {!! Form::text('rutExcel', null , ['class' => 'hidden', 'id' => 'rutExcel'] ) !!}
                  {!! Form::text('nombreExcel', null , ['class' => 'hidden', 'id' => 'nombreExcel'] ) !!}
                  {!! Form::text('correoExcel', null , ['class' => 'hidden', 'id' => 'correoExcel'] ) !!}
                  {!! Form::text('estadoExcel', null , ['class' => 'hidden', 'id' => 'estadoExcel'] ) !!}
                  {!! Form::text('cargoExcel', null , ['class' => 'hidden', 'id' => 'cargoExcel'] ) !!}
                  <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                      <span class="fa fa-download"></span>
                  </button>
              {!! Form::close() !!}
              <br>
              <table class="table table-bordered table-striped" id="TablaMisClientes">
                <thead>
                    <tr>
                        <th class="text-center">Mes</th>
                        <th class="text-center">Atenciones</th>
                        <th class="text-center">Total $</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">Enero</td>
                        <td class="text-center">12</td>
                        <td class="text-center">$100.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">Febrero</td>
                        <td class="text-center">20</td>
                        <td class="text-center">$90.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">Marzo</td>
                        <td class="text-center">18</td>
                        <td class="text-center">$120.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">Abril</td>
                        <td class="text-center">8</td>
                        <td class="text-center">$130.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">Mayo</td>
                        <td class="text-center">3</td>
                        <td class="text-center">$100.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">Junio</td>
                        <td class="text-center">9</td>
                        <td class="text-center">$30.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">Julio</td>
                        <td class="text-center">11</td>
                        <td class="text-center">$90.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">Agosto</td>
                        <td class="text-center">21</td>
                        <td class="text-center">$200.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">Septiembre</td>
                        <td class="text-center">16</td>
                        <td class="text-center">$110.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">Octubre</td>
                        <td class="text-center">20</td>
                        <td class="text-center">$20.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">Noviembre</td>
                        <td class="text-center">19</td>
                        <td class="text-center">$19.000</td>
                    </tr>
                    <tr>
                        <td class="text-center">Diciembre</td>
                        <td class="text-center">17</td>
                        <td class="text-center">$21.000</td>
                    </tr>
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

    $(document).ready(function() {
      var bar = new Morris.Bar({
        element: 'bar-chart1',
        resize: true,
        data: [
          {y: 'Enero', a: '12'},
          {y: 'Febrero', a: '20'},
          {y: 'Marzo', a: '18'},
          {y: 'Abril', a: '8'},
          {y: 'Mayo', a: '3'},
          {y: 'Junio', a: '9'},
          {y: 'Julio', a: '11'},
          {y: 'Agosto', a: '21'},
          {y: 'Septiembre', a: '15'},
          {y: 'Octubre', a: '20'},
          {y: 'Noviembre', a: '19'},
          {y: 'Diciembre', a: '17'},
        ],
        barColors: ['#719430'],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Atenciones'],
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

      $('#tablaProximidad').DataTable({
        processing: true,
        pageLength: 10,
        searching   : false,
        language: {
                    "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                  },
        order: [[ 2, "desc" ]],
        columnDefs: [
                      { targets: [2, 3, 4], render: $.fn.dataTable.render.moment('DD/MM/YYYY') },
                    ],
        ajax: {
            url: "reportes.getTableProximidadCompra",
            type: "POST",
            data    : { 
              "_token"   : token
            },
            type: "POST",
            dataType: "json"
        },
        columns: [
          {class : "text-center",
           data: 'rut'},
          {class : "text-center",
           data: 'nombres'},
          {class : "text-center",
           data: 'ultima_compra'},
          {class : "text-center",
           data: 'fecha_penultima_compra'},
          {class : "text-center",
           data: 'ultimo_correo'},
          {class : 'text-center',
          data: 'periodicidad'},
          {class : "text-center",
           data: 'semaforo'},
          {class : "text-center",
           data: 'enviar_correo'},
        ],
        colReorder: true,
      });
    });

    function enviarCorreoCliente(rut){
      $.ajax({
        url: "MisClientes.enviarCorreo",
        type: 'POST',
        dataType: 'JSON',
        data: {
          rut         : rut, 
          "_token"    : token
        },
      })
      .done(function(data) {
        console.log(data);
      })
      .fail(function(data) {
        console.log(data);
      });
    }
  </script>

@endsection