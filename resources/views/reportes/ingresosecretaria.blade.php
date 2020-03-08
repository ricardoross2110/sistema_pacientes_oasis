@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Reporte ingresos por secretaria
@endsection

@section('contentheader_title')
  Reporte ingresos por secretaria
@endsection

@section('breadcrumb_nivel')  
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.reports') }}</li>
    <li class="active"> Reporte ingresos por secretaria</li>
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
              {!! Form::label('secretariaB', 'Secretaria:', ['for' => 'secretariaB'] ) !!}
              {!! Form::select('secretariaB[]', $secretarias, null, array('class' => 'form-control secretariab', 'multiple', 'data-placeholder' => 'Seleccione secretaria')) !!}
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
          Gráfico por secretaria
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
          Reporte de ingresos por secretaria
        </div>
        <div class="box-body table-responsive">
          {!! Form::open(['route' => 'reportes.getIngresoSecretaria', 'method' => 'POST']) !!}
          {!! Form::text('desdeExcel', null , ['class' => 'hidden', 'id' => 'desdeExcel'] ) !!}
          {!! Form::text('hastaExcel', null , ['class' => 'hidden', 'id' => 'hastaExcel'] ) !!}
          {!! Form::text('secretariaExcel', null , ['class' => 'hidden', 'id' => 'secretariaExcel'] ) !!}
          {!! Form::text('tipo', 'excel' , ['class' => 'hidden', 'id' => 'tipo'] ) !!}
          <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
            <span class="fa fa-download"></span>
          </button>
          {!! Form::close() !!}
          <br>
          <table class="table table-bordered table-striped" id="tablaIngresoSecretaria">
            <thead>
              <tr>
                <th class="text-center">Secretaria</th>
                <th class="text-center">Ingresos</th>
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
    var fechadesde           = $('#fechadesde').val();
    var fechahasta           = $('#fechahasta').val();

    var secretariab         = [];

    $('.secretaria').select2();
    $('.secretariab').select2();

    @if(isset($secretariaB))
      @foreach ($secretariaB as $secretaria_b)
        secretariab.push({{ $secretaria_b }});
      @endforeach
    @endif

    function limpiarSelects() {
      secretariab = [];
      $("#fechadesde").removeAttr('value');
      $("#fechahasta").removeAttr('value');
      var secretaria_select      =   $('.secretariab');
      secretaria_select.empty().trigger("change");
      cargarSelectSecretaria();
    }

    function cargarSelects() {
      cargarSelectSecretaria();
    }

    function cargarSelectSecretaria() {
      var secretaria_select      =   $('.secretariab');
      secretaria_select.empty().trigger("change");

      $.ajax({
        type    : 'POST',
        url     : "{{ url('usuario.cargarSecretarias') }}",
        data    : {
                    "_token"   : token,
                  },
        dataType: 'json'
      })
      .done(function(data) {
        $.each(data.secretarias, function(index, val) {
          console.log(secretariab);
          console.log(index);
          console.log(val);
          console.log(secretariab.includes(val));
          if (secretariab.includes(val) === true) {
              var option = new Option(index, val, true, true);
          }else{
              var option = new Option(index, val, false, false);
          }
          secretaria_select.append(option).trigger('change');
        });
      })
      .fail(function() {
          console.log("error");
      });
    }

    function GuardarValores(){
      var desdeExcel        =   $('#fechadesde').val();
      var hastaExcel        =   $('#fechahasta').val();
      var secretariasExcel  = [];

      $.each($(".secretariab option:selected"), function(){            
          secretariasExcel.push($(this).val());
      });

      secretariasExcel     =   JSON.stringify(secretariasExcel);

      if(desdeExcel != ''){
          $('#desdeExcel').val(desdeExcel);
      }
    
      if(hastaExcel != ''){
          $('#hastaExcel').val(hastaExcel);
      }
      $('#secretariasExcel').val(secretariasExcel);
    }

    $(document).ready(function() {
      cargarSelects();

      var secretaria_select      =   $('.secretariab');
      secretaria_select.val(null).trigger("change");

      var datosGrafico = [];

        $.ajax({
          url: "{{ url('reportes.getIngresoSecretaria') }}",
          data    : { 
            fechadesde  : fechadesde,
            fechahasta  : fechahasta,
            secretaria  : secretariab,
            tipo        : 'grafico',
            "_token"    : token
          },
          type: "POST"
        })
        .done(function(data) {
          $.each(JSON.parse(data.secretarias), function(index, val) {
             datosGrafico.push({'secretaria' : index, 'ingresos' : val });
          });
          
          if (datosGrafico.length == 0) {
            var bar = new Morris.Bar({
              element: 'bar-chart1',
              resize: true,
              data: [{'secretaria' : 'Sin datos', 'ingresos' : 0 }],
              barColors: ['#05B151'],
              xkey: 'secretaria',
              ykeys: ['ingresos'],
              labels: ['Ingresos'],
              hideHover: 'auto'
            });
          }else{
            var bar = new Morris.Bar({
              element: 'bar-chart1',
              resize: true,
              data: datosGrafico,
              barColors: ['#416BAF'],
              xkey: 'secretaria',
              ykeys: ['ingresos'],
              labels: ['Ingresos'],
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
            todayHighlight: true,
            autoclose: true
        });  
        $('#fechahasta').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true
        });   

      $('#tablaIngresoSecretaria').DataTable({
        processing: true,
        pageLength: 10,
        searching   : false,
        language: {
                    "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                  },
        order: [[ 0, "asc" ]],
        ajax: {
            url: "reportes.getIngresoSecretaria",
            type: "POST",
            data    : {
              fechadesde : fechadesde,
              fechahasta : fechahasta,
              secretaria : secretariab,
              tipo       : 'table',
              "_token"   : token
            },
            type: "POST",
            dataType: "json"
        },
        columns: [
          {class : "text-center",
           data: 'secretaria'},
          {class : "text-center",
           data: 'ingreso'}
        ],
        colReorder: true,
      });
    });

  </script>

@endsection