@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
    Reportes
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
          {{ Form::open(array('method' => 'GET')) }}
            <div class="box-body">
              <div class="row">
                <div class="form-group col-md-4">
                  {!! Form::label('rutB', 'Rut', ['for' => 'rutB'] ) !!}
                  {!! Form::select('rutB[]', [], null, ['class' => 'form-control rut_select', 'multiple','data-placeholder' => 'Seleccione rut de cliente', 'pattern' => '[A-Za-záéíóúñÑÁÉÍÓÚ0-9, ]+', 'id' => 'rutb' ]) !!}
                </div>
                <div class="form-group col-md-4">
                  {!! Form::label('apellido_paternoB', 'Apellido paterno', ['for' => 'apellido_paternoB'] ) !!}
                  {!! Form::select('apellido_paternoB[]', [], null, ['class' => 'form-control apellidopaterno_select', 'multiple','data-placeholder' => 'Seleccione rut de cliente', 'data-placeholder' => 'Escribe el apellido paterno', 'id' => 'apellido_paternob' ]) !!}
                </div>
                <div class="form-group col-md-4">
                  {!! Form::label('estado', 'Estado', ['for' => 'estado'] ) !!}
                  {!! Form::select('estado', array('all' => 'Seleccione estado', '1' => 'Activo', '0' => 'Inactivo'), '', array('class' => 'form-control estado_select', 'value' => 'Seleccione estado')) !!}
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-4">
                  {!! Form::label('diassincompradesde', 'Días sin compra desde: ', ['for' => 'diassincompradesde'] ) !!}
                  {!! Form::number('diassincompradesde', null , ['class' => 'form-control', 'id' => 'diassincompradesde', 'placeholder' => 'Ingrese días sin compra','min' => '0' ,'max' => '9999' ]  ) !!}
                </div>
                <div class="form-group col-md-4">
                  {!! Form::label('diassincomprahasta', 'Días sin compra hasta: ', ['for' => 'diassincomprahasta'] ) !!}
                  {!! Form::number('diassincomprahasta', null , ['class' => 'form-control', 'id' => 'diassincomprahasta', 'placeholder' => 'Ingrese días sin compra','min' => '0' ,'max' => '9999' ]  ) !!}
                </div>
                <div class="form-group col-md-4">
                  {!! Form::label('antiguedaddesde', 'Antiguedad desde: ', ['for' => 'antiguedaddesde'] ) !!}
                  {!! Form::number('antiguedaddesde', null , ['class' => 'form-control', 'id' => 'antiguedaddesde', 'placeholder' => 'Ingrese antiguedad désde','min' => '0' ,'max' => '9999' ]  ) !!}
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-4">
                  {!! Form::label('antiguedadhasta', 'Antiguedad hasta: ', ['for' => 'antiguedadhasta'] ) !!}
                  {!! Form::number('antiguedadhasta', null , ['class' => 'form-control', 'id' => 'antiguedadhasta', 'placeholder' => 'Ingrese antiguedad hasta','min' => '0' ,'max' => '9999' ]  ) !!}
                </div>
                <div class="form-group col-md-4">
                  {!! Form::label('fechadesde', 'Rango de búsqueda de venta fecha desde', ['for' => 'fechadesde'] ) !!}
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    {!! Form::text('fechadesde', null , ['class' => 'form-control  pull-right', 'id' => 'fechadesde', 'placeholder' => 'DD/MM/AAAA', 'autocomplete' => 'off', 'pattern' => '\d{1,2}/\d{1,2}/\d{4}', 'maxlength' => '10', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
                  </div>
                </div>
                <div class="form-group col-md-4">
                  {!! Form::label('fechahasta', 'Rango de búsqueda de venta fecha hasta', ['for' => 'fechahasta'] ) !!}
                  <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    {!! Form::text('fechahasta', null, ['class' => 'form-control pull-right', 'id' => 'fechahasta', 'placeholder' => 'DD/MM/AAAA', 'autocomplete' => 'off', 'pattern' => '\d{1,2}/\d{1,2}/\d{4}', 'maxlength' => '10', 'onkeypress' => 'return onlyNumbers(event)']) !!}
                  </div>
                </div>
              </div>
            </div>
            <div class="box-footer">
              {!! Form::submit('Buscar', array('class' => 'btn btn-warning')) !!}
            </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Listado cliente-compra</h3>
          </div>
          <div class="box-body table-responsive">
            {!! Form::open([ 'route' => 'reportes.exportExcelReporteClientes', 'method' => 'POST']) !!}
              {!! Form::text('rutExcel', null , ['class' => 'hidden', 'id' => 'rutExcel'] ) !!}
              {!! Form::text('apellido_paternoExcel', null , ['class' => 'hidden', 'id' => 'apellido_paternoExcel'] ) !!}
              {!! Form::text('estadoExcel', null , ['class' => 'hidden', 'id' => 'estadoExcel'] ) !!}
              {!! Form::text('diassincompradesdeExcel', null , ['class' => 'hidden', 'id' => 'diassincompradesdeExcel'] ) !!}
              {!! Form::text('diassincomprahastaExcel', null , ['class' => 'hidden', 'id' => 'diassincomprahastaExcel'] ) !!}
              {!! Form::text('antiguedaddesdeExcel', null , ['class' => 'hidden', 'id' => 'antiguedaddesdeExcel'] ) !!}
              {!! Form::text('antiguedadhastaExcel', null , ['class' => 'hidden', 'id' => 'antiguedadhastaExcel'] ) !!}
              {!! Form::text('fechadesdeExcel', null , ['class' => 'hidden', 'id' => 'fechadesdeExcel'] ) !!}
              {!! Form::text('fechahastaExcel', null , ['class' => 'hidden', 'id' => 'fechahastaExcel'] ) !!}
              <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                <span class="fa fa-download"></span>
              </button>
            {!! Form::close() !!}
            <table class="table table-bordered table-striped" id="TablaReporteClientes">
              <thead>
                <tr>
                  <th class="text-center">Rut</th>
                  <th class="text-center">Nombre Completo</th>
                  <th class="text-center">Télefono</th>
                  <th class="text-center">Email</th>
                  <th class="text-center">Periodicidad</th>
                  <th class="text-center">Promedio de Compras Mensuales</th>
                  <th class="text-center">Promedio de Compras Anuales</th>
                  <th class="text-center">Compras del último Mes</th>
                  <th class="text-center">Compras del último año</th>
                  <th class="text-center">Dias desde ultima Compra</th>
                  <th class="text-center">Antiguedad (años)</th>
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

    $(function () {
      $('.rut_select').select2();
      $('.apellidopaterno_select').select2();
    });

    var token                 = "{{ csrf_token() }}";
    var rutb                  = [];
    var apellido_paternob     = [];
    var diassincompradesde    = $('#diassincompradesde').val();
    var diassincomprahasta    = $('#diassincomprahasta').val();
    var antiguedaddesde       = $('#antiguedaddesde').val();
    var antiguedadhasta       = $('#antiguedadhasta').val();
    var fechadesde            = $('#fechadesde').val();
    var fechahasta            = $('#fechahasta').val();

    var estado                = '{{ $estado }}';

     @if(isset($rutB))
      @foreach ($rutB as $rut_b)
        rutb.push("{{ $rut_b }}");
      @endforeach
    @endif
    @if(isset($apellido_paternoB))
      @foreach ($apellido_paternoB as $apellido_paterno_b)
        apellido_paternob.push("{{ $apellido_paterno_b }}");
      @endforeach
    @endif

    $(document).ready(function() {
      cargarSelects();
    });

    /*CargarSelects*/
    function cargarSelects() {
      console.log();
      cargarSelectRuts(apellido_paternob);
      cargarSelectApellidoPaterno(rutb);
    }

    function cargarSelectRuts(apellidopaterno) {
      var apellidop  = JSON.stringify(apellidopaterno);

      var rutSelect  = $('.rut_select');
      rutSelect.empty().trigger("change");

      $.ajax({
        type    : 'POST',
        url     : "{{ url('reportes.cargarselectrut') }}",
        data    : {
                    apellidop  : apellidop, 
                    estado     : estado, 
                    "_token"   : token,
                  },
        dataType: 'json'
      })
      .done(function(data) {
        $.each(data.ruts, function(index, val) {
          if (rutb.includes(val) === true) {
            var option = new Option(val, val, true, true);
          }else{
            var option = new Option(val, val, false, false);
          }
          rutSelect.append(option).trigger('change');
        });
      })
      .fail(function() {
        console.log("error");
      });
    }

    function cargarSelectApellidoPaterno(rut) {
      var rut        = JSON.stringify(rut);

      var apellidoPaternoSelect  = $('.apellidopaterno_select');
      apellidoPaternoSelect.empty().trigger("change");

      $.ajax({
        type    : 'POST',
        url     : "{{ url('reportes.cargarApellidoPaterno') }}",
        data    : {
                    rut        : rut, 
                    estado     : estado, 
                    "_token"   : token,
                  },
        dataType: 'json'
      })
      .done(function(data) {
        $.each(data.apellido_paterno, function(index, val) {
          if (apellido_paternob.includes(val) === true) {
            var option = new Option(val, val, true, true);
          }else{
            var option = new Option(val, val, false, false);
          }
          apellidoPaternoSelect.append(option).trigger('change');
        });
      })
      .fail(function() {
        console.log("error");
      });
    }

    $(document).ready(function () {
      
      /*Seleccionar*/
      $('.rut_select').on('select2:select', function (e) {
        var data = e.params.data;
        rutb.push(data.id);
        cargarSelects();
      });

      $('.rut_select').on('select2:unselect', function (e) {
        var data = e.params.data;
        var index = rutb.indexOf(data.id);

        if (index > -1) {
          rutb.splice(index, 1);
        }

        cargarSelects();
      });

      /*Seleccionar*/
      $('.apellidopaterno_select').on('select2:select', function (e) {
        var data = e.params.data;
        apellido_paternob.push(data.id);
        cargarSelects();
      });

      $('.apellidopaterno_select').on('select2:unselect', function (e) {
        var data = e.params.data;
        var index = apellido_paternob.indexOf(data.id);

        if (index > -1) {
          apellido_paternob.splice(index, 1);
        }

        cargarSelects();
      });

      /*Seleccionar*/
      $('.estado_select').change(function(e) {
        estado = $('.estado_select').val();
        cargarSelects();
      });
      
      //Date picker
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
          autoclose: true,
      });

      // datatable grilla TablaReporteClientes
      $('#TablaReporteClientes').DataTable({
          processing: true,
          pageLength: 10,
          searching   : false,
          language: {
             "url": '{!! asset('/plugins/datatables/latino.json') !!}'
          },
          order: [[ 0, "asc" ]],
          ajax: {
                url: "reportes.GetTablaReporteClientes",
                type: "POST",
                data:{
                    rut                 : rutb,
                    apellido_paterno    : apellido_paternob,
                    diassincompradesde  : diassincompradesde,
                    diassincomprahasta  : diassincomprahasta,
                    antiguedaddesde     : antiguedaddesde,
                    antiguedadhasta     : antiguedadhasta,
                    fechadesde          : fechadesde,
                    fechahasta          : fechahasta,
                    estado              : estado,
                    "_token"            : token,                     
                },
          },
          columns: [
              {class : "text-center",
                data: 'action'},
              {class : "text-center",
                data: 'nombre_completo'},
              {class : "text-center",
                data: 'telefono'},
              {class : "text-center",
                data: 'email'},
              {class : "text-center",
                data: 'periodicidad'},
              {class : "text-center",
                data: 'ventasmes'},
              {class : "text-center",
                data: 'ventasanio'},
              {class : "text-center",
                data: 'totalVentasMes'},
              {class : "text-center",
                data: 'totalVentasAnual'},
              {class : "text-center",
                data: 'diasUltima'},
              {class : "text-center",
                data: 'antiguedad'}
          ], 
          colReorder: true,
      });
    });

    function GuardarValores(){

        var rut                   = $('#rutb').val();
        var apellidopaterno       = $('#apellido_paternob').val();
        var estado                = $('#estado').val();
        var diassincompradesde    = $('#diassincompradesde').val();
        var diassincomprahasta    = $('#diassincomprahasta').val();
        var antiguedaddesde       = $('#antiguedaddesde').val();
        var antiguedadhasta       = $('#antiguedadhasta').val();
        var fecha_desde           = $('#fechadesde').val();
        var fecha_hasta           = $('#fechahasta').val();

        if(rut != ''){
            $('#rutExcel').val(rut);
        }

        if(apellidopaterno != ''){
            $('#apellido_paternoExcel').val(apellidopaterno);
        }

        if(estado != ''){
            $('#estadoExcel').val(estado);
        }

        if(diassincompradesde != ''){
            $('#diassincompradesdeExcel').val(diassincompradesde);
        }

        if(diassincomprahasta != ''){
            $('#diassincomprahastaExcel').val(diassincomprahasta);
        }

        if(antiguedaddesde != ''){
            $('#antiguedaddesdeExcel').val(antiguedaddesde);
        }

        if(antiguedadhasta != ''){
            $('#antiguedadhastaExcel').val(antiguedadhasta);
        }

        if(fecha_desde != ''){
            $('#fechadesdeExcel').val(fecha_desde);
        }

        if(fecha_hasta != ''){
            $('#fechahastaExcel').val(fecha_hasta);
        }
      }

  </script>

@endsection
