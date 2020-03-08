@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Reporte atenciones por sucursal
@endsection

@section('contentheader_title')
  Reporte atenciones por sucursal
@endsection

@section('breadcrumb_nivel')  
  <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
  <li>{{ trans('adminlte_lang::message.reports') }}</li>
  <li class="active">Reporte atenciones por sucursal</li>
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
          <div class="row">
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
              {!! Form::label('sucursalB', 'Sucursal:', ['for' => 'sucursalB'] ) !!}
              {!! Form::select('sucursalB[]', $sucursales, null, array('class' => 'form-control sucursalb', 'multiple', 'data-placeholder' => 'Seleccione sucursal')) !!}
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
          Gráfico por sucursal
        </div>
        <div class="box-body">
          <div class="chart" id="bar-chart4" style="height: 250px;"></div>
        </div>
      </div>
    </div>     
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="box box-info">
        <div class="box-header">
          Reporte de atenciones por sucursal
        </div>
        <div class="box-body table-responsive">
          {!! Form::open(['route' => 'reportes.getAtencionSucursal', 'method' => 'POST']) !!}
          {!! Form::text('desdeExcel', null , ['class' => 'hidden', 'id' => 'desdeExcel'] ) !!}
          {!! Form::text('hastaExcel', null , ['class' => 'hidden', 'id' => 'hastaExcel'] ) !!}
          {!! Form::text('sucursalExcel', null , ['class' => 'hidden', 'id' => 'sucursalExcel'] ) !!}
          {!! Form::text('tipo', 'excel' , ['class' => 'hidden', 'id' => 'tipo'] ) !!}
          <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
            <span class="fa fa-download"></span>
          </button>
          {!! Form::close() !!}
          <br>
          <table class="table table-bordered table-striped" id="tablaAtencionSucursal">
            <thead>
              <tr>
                <th class="text-center">Sucursal</th>
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
    var sucursalb           = [];

    $('.sucursal').select2();
    $('.sucursalb').select2();

    @if(isset($sucursalB))
      @foreach ($sucursalB as $sucursal_b)
        sucursalb.push({{ $sucursal_b }});
      @endforeach
    @endif

    function limpiarSelects() {
      sucursalb = [];
      $("#fechadesde").removeAttr('value');
      $("#fechahasta").removeAttr('value');
      var sucursal_select      =   $('.sucursalb');
      sucursal_select.empty().trigger("change");
      cargarSelectSucursal();
    }

    function cargarSelects() {
      cargarSelectSucursal();
    }

    function cargarSelectSucursal() {
      var sucursal_select      =   $('.sucursalb');
      sucursal_select.empty().trigger("change");

      $.ajax({
        type    : 'POST',
        url     : "{{ url('sucursal.cargarSucursales') }}",
        data    : {
                    "_token"   : token,
                  },
        dataType: 'json'
      })

      .done(function(data) {
        $.each(data.sucursales, function(index, val) {
          console.log(sucursalb);
          console.log(index);
          console.log(val);
          console.log(sucursalb.includes(val));
          if (sucursalb.includes(val) === true) {
              var option = new Option(index, val, true, true);
          }else{
              var option = new Option(index, val, false, false);
          }
          sucursal_select.append(option).trigger('change');
        });
      })
      .fail(function() {
          console.log("error");
      });
    }

    function GuardarValores(){
      var desdeExcel      =   $('#fechadesde').val();
      var hastaExcel      =   $('#fechahasta').val();
      var sucursalesExcel =   [];

      $.each($(".sucursalb option:selected"), function(){            
          sucursalesExcel.push($(this).val());
      });

      sucursalesExcel     =   JSON.stringify(sucursalesExcel);

      if(desdeExcel != ''){
          $('#desdeExcel').val(desdeExcel);
      }
    
      if(hastaExcel != ''){
          $('#hastaExcel').val(hastaExcel);
      }

      $('#sucursalExcel').val(sucursalesExcel);
    }

    $(document).ready(function() {

      cargarSelects();
      var sucursal_select      =   $('.sucursal');
      sucursal_select.val(null).trigger("change");

      var datosGrafico = [];

      $.ajax({
        url: "{{ url('reportes.getAtencionSucursal') }}",
        data    : { 
          fechadesde : fechadesde,
          fechahasta : fechahasta,
          sucursal   : sucursalb,
          tipo       : 'grafico',
          "_token"   : token
        },
        type: "POST"
      })

      .done(function(data) {
        $.each(JSON.parse(data.sucursales), function(index, val) {
           datosGrafico.push({label : index, value : val });
        });

        if (datosGrafico.length == 0) {
          var bar2 = new Morris.Donut({
            element: 'bar-chart4',
            resize: true,
            colors: ["#416BAF", "#05B151", "#2A9092", "#FFFF00"],
            data: [{label : 'Sin datos', value : 0 }],
            hideHover: 'auto'
          });
        }else{
          var bar2 = new Morris.Donut({
            element: 'bar-chart4',
            resize: true,
            colors: ["#416BAF", "#05B151", "#2A9092", "#FFFF00"],
            data: datosGrafico,
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

      $('#tablaAtencionSucursal').DataTable({
        processing: true,
        pageLength: 10,
        paginate: true,
        searching   : false,
        language: {
                    "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                  },
        order: [[ 0, "desc" ]],
        ajax: {
            url: "reportes.getAtencionSucursal",
            type: "POST",
            data    : {
              fechadesde : fechadesde,
              fechahasta : fechahasta,
              sucursal   : sucursalb,
              tipo       : 'table',
              "_token"   : token
            },
            type: "POST",
            dataType: "json"
        },
        columns: [
          {class : "text-center",
           data: 'sucursal'},
          {class : "text-center",
           data: 'atenciones'},
        ],
        colReorder: true,
      });
    });

  </script>
  
@endsection