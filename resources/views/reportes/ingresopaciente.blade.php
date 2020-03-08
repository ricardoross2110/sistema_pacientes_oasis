@extends('adminlte::layouts.app')

@section('htmlheader_title')
	Reporte ingreso por paciente
@endsection

@section('contentheader_title')
  Reporte ingreso por paciente
@endsection

@section('breadcrumb_nivel')  
  <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
  <li>{{ trans('adminlte_lang::message.reports') }}</li>
  <li class="active">Reporte ingreso por paciente</li>
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
                <div class="col-md-1 col-sm-6 col-xs-12">
                    {!! Form::label('fechadesde', 'Fecha desde:', ['for' => 'fechadesde'] ) !!}
                    {!! Form::text('fechadesde', null, ['class' => 'form-control pull-right','onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ) !!}
                </div>
                <div class="col-md-1 col-sm-6 col-xs-12">
                    {!! Form::label('fechahasta', 'Fecha hasta:', ['for' => 'fechahasta'] ) !!}
                    {!! Form::text('fechahasta', null, ['class' => 'form-control pull-right', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'DD/MM/AAAA']  ) !!}
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                    {!! Form::label('monto_minimo', 'Monto Mínimo:', ['for' => 'monto_minimo'] ) !!}
                    {!! Form::number('monto_minimo', null, ['class' => 'form-control pull-right', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'placeholder' => 'Ingrese monto minimo', 'min' => '0', 'max' => '99999999']  ) !!}
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                    {!! Form::label('monto_maximo', 'Monto Máximo:', ['for' => 'monto_maximo'] ) !!}
                    {!! Form::number('monto_maximo', null, ['class' => 'form-control pull-right','onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'placeholder' => 'Ingrese monto máximo', 'min' => '0', 'max' => '99999999']  ) !!}
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    {!! Form::label('sucursalB', 'Sucursal:', ['for' => 'sucursalB'] ) !!}
                    {!! Form::select('sucursalB[]', $sucursales, null, array('class' => 'form-control sucursalb', 'multiple', 'data-placeholder' => 'Seleccione sucursal')) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-sm-6 col-xs-12">
                    {!! Form::label('rut_paciente', 'Rut Paciente:', ['for' => 'rut_paciente'] ) !!}
                    {!! Form::text('rut_paciente', null, ['class' => 'form-control pull-right', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8',  'autocomplete' => 'off', 'placeholder' => 'Rut sin puntos, ni guión y ni digito verificador']  ) !!}
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    {!! Form::label('nombre_paciente', 'Nombre Paciente:', ['for' => 'nombre_paciente'] ) !!}
                    {!! Form::text('nombre_paciente', null, ['class' => 'form-control pull-right', 'onkeypress' => 'return soloLetras(event)', 'autocomplete' => 'off', 'placeholder' => 'Nombre del paciente que se buscara']  ) !!}
                </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
                    {!! Form::label('rut_profesional', 'Rut Profesional:', ['for' => 'rut_profesional'] ) !!}
                    {!! Form::text('rut_profesional', null, ['class' => 'form-control pull-right', 'onkeypress' => 'return onlyNumbers(event)',  'autocomplete' => 'off', 'placeholder' => 'Rut sin puntos, ni guión y ni digito verificador']  ) !!}
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    {!! Form::label('nombre_profesional', 'Nombre Profesional:', ['for' => 'nombre_profesional'] ) !!}
                    {!! Form::text('nombre_profesional', null, ['class' => 'form-control pull-right', 'onkeypress' => 'return soloLetras(event)', 'maxlength' => '10',  'autocomplete' => 'off', 'placeholder' => 'Nombre del profesional que se buscara']  ) !!}
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
  
  <div class="alert alert-warning" role="alert">
    Si no se aplican filtros de busqueda, muestra los datos del día actual y en todas las sucursales.
  </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box box-info">
                <div class="box-header">
                    Reporte de atenciones por paciente
                </div>
                <div class="box-body table-responsive">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            {!! Form::open(['route' => 'reportes.getIngresoPaciente', 'method' => 'POST']) !!}
                                {!! Form::text('fechadesdeExcel', null , ['class' => 'hidden', 'id' => 'fechadesdeExcel'] ) !!}
                                {!! Form::text('fechahastaExcel', null , ['class' => 'hidden', 'id' => 'fechahastaExcel'] ) !!}
                                {!! Form::text('monto_minimoExcel', null , ['class' => 'hidden', 'id' => 'monto_minimoExcel'] ) !!}
                                {!! Form::text('monto_maximoExcel', null , ['class' => 'hidden', 'id' => 'monto_maximoExcel'] ) !!}
                                {!! Form::text('rut_pacienteExcel', null , ['class' => 'hidden', 'id' => 'rut_pacienteExcel'] ) !!}
                                {!! Form::text('sucursalesExcel', null , ['class' => 'hidden', 'id' => 'sucursalesExcel'] ) !!}
                                {!! Form::text('nombre_pacienteExcel', null , ['class' => 'hidden', 'id' => 'nombre_pacienteExcel'] ) !!}
                                {!! Form::text('rut_profesionalExcel', null , ['class' => 'hidden', 'id' => 'rut_profesionalExcel'] ) !!}
                                {!! Form::text('nombre_profesionalExcel', null , ['class' => 'hidden', 'id' => 'nombre_profesionalExcel'] ) !!}
                                {!! Form::text('tipo', 'excel' , ['class' => 'hidden', 'id' => 'tipo'] ) !!}
                                <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                                    <span class="fa fa-download"></span>
                                </button>
                            {!! Form::close() !!}
                            <table class="table table-bordered table-striped" id="tablaIngresosPaciente">
                                <thead>
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Hora</th>
                                        <th class="text-center">Rut Paciente</th>
                                        <th class="text-center">Paciente</th>
                                        <th class="text-center">Rut Profesional</th>
                                        <th class="text-center">Profesional</th>
                                        <th class="text-center">Sucursal</th>
                                        <th class="text-center">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
        
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
    </div>            

@endsection

@section('scripts')
@parent

  <script type="text/javascript">
  
    var token               =  "{{ csrf_token() }}";
    var fechadesde          = $('#fechadesde').val();
    var fechahasta          = $('#fechahasta').val();
    var monto_minimo        = $('#monto_minimo').val();
    var monto_maximo        = $('#monto_maximo').val();
    var sucursalb           = [];
    var rut_paciente        = $('#rut_paciente').val();
    var nombre_paciente     = $('#nombre_paciente').val();
    var rut_profesional     = $('#rut_profesional').val();
    var nombre_profesional  = $('#nombre_profesional').val();

    function limpiarSelects() {
        sucursalb = [];
        $("#fechadesde").removeAttr('value');
        $("#fechahasta").removeAttr('value');
        $("#monto_minimo").removeAttr('value');
        $("#monto_maximo").removeAttr('value');
        var sucursal_select = $('.sucursalb');
        sucursal_select.empty().trigger("change");
        $("#rut_paciente").removeAttr('value');
        $("#nombre_paciente").removeAttr('value');
        $("#rut_profesional").removeAttr('value');
        $("#nombre_profesional").removeAttr('value');
        cargarSelectSucursal();
    }

    function GuardarValores(){
        var fechadesdeExcel         =   $('#fechadesde').val();
        var fechahastaExcel         =   $('#fechahasta').val();
        var monto_minimoExcel       =   $('#monto_minimo').val();
        var monto_maximoExcel       =   $('#monto_maximo').val();
        var rut_pacienteExcel       =   $('#rut_paciente').val();
        var nombre_pacienteExcel    =   $('#nombre_paciente').val();
        var rut_profesionalExcel    =   $('#rut_profesional').val();
        var nombre_profesionalExcel =   $('#nombre_profesional').val();
        var sucursalesExcel = [];

        $.each($(".sucursalb option:selected"), function(){            
            sucursalesExcel.push($(this).val());
        });

        console.log(sucursalesExcel);

        sucursalesExcel   =   JSON.stringify(sucursalesExcel);

        console.log(sucursalesExcel);
        
        if(fechadesdeExcel != ''){
            $('#fechadesdeExcel').val(fechadesdeExcel);
        }

        if(fechahastaExcel != ''){
            $('#fechahastaExcel').val(fechahastaExcel);
        }

        if(monto_minimoExcel != ''){
            $('#monto_minimoExcel').val(monto_minimoExcel);
        }

        if(monto_maximoExcel != ''){
            $('#monto_maximoExcel').val(monto_maximoExcel);
        }

        if(rut_pacienteExcel != ''){
            $('#rut_pacienteExcel').val(rut_pacienteExcel);
        }

        if(nombre_pacienteExcel != ''){
            $('#nombre_pacienteExcel').val(nombre_pacienteExcel);
        }

        if(rut_profesionalExcel != ''){
            $('#rut_profesionalExcel').val(rut_profesionalExcel);
        }

        if(nombre_profesionalExcel != ''){
            $('#nombre_profesionalExcel').val(nombre_profesionalExcel);
        }
        
        $('#sucursalesExcel').val(sucursalesExcel);
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
    
    $(document).ready(function() {
        cargarSelectSucursal();

        $('.sucursalb').select2();

        @if(isset($sucursalB))
            @foreach ($sucursalB as $sucursal_b)
                sucursalb.push({{ $sucursal_b }});
            @endforeach
        @endif

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

        $('#tablaIngresosPaciente').DataTable({
            processing: true,
            pageLength: 10,
            searching   : false,
            language: {
                        "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                    },
            order: [[ 0, "desc"], [1, "desc"]],
            ajax: {
                url     : "reportes.getIngresoPaciente",
                type    : "POST", 
                data    : {
                    fechadesde          : fechadesde,
                    fechahasta          : fechahasta,
                    monto_minimo        : monto_minimo,
                    monto_maximo        : monto_maximo,
                    sucursal            : sucursalb,
                    rut_paciente        : rut_paciente,
                    nombre_paciente     : nombre_paciente,
                    rut_profesional     : rut_profesional,
                    nombre_profesional  : nombre_profesional,
                    tipo        : 'table',
                    "_token"    : token
                },
                dataType: "json"
            },
            columns: [
                {class  : "text-center",
                 data   : 'fecha'},
                 
                {class  : "text-center",
                 data   : 'hora'},

                {class  : "text-center",
                 data   : 'rut_paciente'},
                 
                {class  : "text-center",
                 data   : 'paciente'},
                 
                {class  : "text-center",
                 data   : 'rut_profesional'},

                {class  : "text-center",
                 data   : 'profesional'},

                {class  : "text-center",
                 data   : 'sucursal'},
                 
                {class  : "text-center",
                 data   : 'monto'}
            ],            
            columnDefs: [
                { targets: 0, render: $.fn.dataTable.render.moment('YYYY/MM/DD', 'DD-MM-YYYY') },
                { targets: 7, render: $.fn.dataTable.render.number( '.', ',', 0, '$ ' ).display }
            ],     
            colReorder: true,
        });
    });

  </script>

@endsection