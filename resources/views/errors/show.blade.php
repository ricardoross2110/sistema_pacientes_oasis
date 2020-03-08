@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
    Historial de errores
@endsection

@section('contentheader_description')    
    Administración
@endsection

@section('footer_title')
    SGC-F014
@endsection

@section('breadcrumb_nivel')
        <li><a href="{{ url('/login') }}"><i class="fa fa-home"></i>Home</a></li>
        <li><a href="{{ url('/errores') }}">Errores</a></li>  
        <li class="active">Detalle</li>
@endsection

@section('main-content')
        <br>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title"><strong>Detalle del error</strong></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="tipo_error" for="tipo_error">Tipo</label>
                                <input class="form-control" id="tipo_error" disabled="disabled" name="tipo_error" type="text" value="{{ $errorDetails->tipo_error }}">
                            </div>
                             <div class="form-group col-md-4">
                                <label for="fecha" for="fecha">Fecha</label>
                                <input class="form-control" id="fecha" disabled name="fecha" type="text" value="{{ \Carbon\Carbon::parse($errorDetails->created_at)->format('d/m/Y H:i:s') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="usuario" for="usuario">Usuario</label>
                                <input class="form-control" id="usuario" disabled name="usuario" type="text" value="{{ $nameUser }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="detalle" for="detalle">Detalle</label>
                                <input class="form-control" id="detalle" disabled name="detalle" type="text" value="{{ $errorDetails->detalle }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="mensaje" for="mensaje">Mensaje</label>
                                <textarea class="form-control" id="mensaje" disabled name="mensaje" cols="50" rows="10">{{ $errorDetails->mensaje }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="{{ url('/errores') }}" type="button" class="btn btn-danger">Volver</a>
                    </div>      
                </div>
            </div>
        </div>
@endsection

@section('scripts')

@parent
<script type="text/javascript">

    function GuardarValores(){
        var codigoExcel             = document.getElementById('codigo').value;
        var nombreExcel             = document.getElementById('nombre').value;
        var browserExcel            = $('#browser').val();
        var modalidadExcel          = $('#modalidad').val();
        var fechadesdeExcel         = $('#fechadesde').val();
        var fechahastaExcel         = $('#fechahasta').val();
        var fechadesdeChromeExcel   = $('#fechadesdeChrome').val();
        var fechahastaChromeExcel   = $('#fechahastaChrome').val();

        if(browserExcel != ''){
            $('#browserExcel').val(browserExcel);
        }

        if(codigoExcel != ''){
            $('#codigoExcel').val(codigoExcel);
        }

        if(nombreExcel != ''){
            $('#nombreExcel').val(nombreExcel);
        }
        
        if(modalidadExcel != ''){
            $('#modalidadExcel').val(modalidadExcel);
        }

        if(fechadesdeExcel != ''){
            $('#fechadesdeExcel').val(fechadesdeExcel);
        }

        if(fechahastaExcel != ''){
            $('#fechahastaExcel').val(fechahastaExcel);
        }

        if(fechadesdeChromeExcel != ''){
            $('#fechadesdeChromeExcel').val(fechadesdeChromeExcel);
        }
        
        if(fechahastaChromeExcel != ''){
            $('#fechahastaChromeExcel').val(fechahastaChromeExcel);
        }
    }

</script>

<script type="text/javascript">

    $('#MyTableErrores').DataTable({
        processing: true,
        pageLength: 10,
        searching   : false,
        language: {
                 "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                  },
        order: [[ 3, "desc" ]]

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

    //Date picker
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
        autoclose: true,
    });

    if (navigator.userAgent.indexOf('Chrome') !=-1 || navigator.userAgent.indexOf('Firefox') !=-1) {    
        document.getElementById('browser').value = 1; //Chrome
        $('#fechadesdeChrome').removeClass('hidden');
        $('#fechahastaChrome').removeClass('hidden');
    }
    else {    
        document.getElementById('browser').value = 0; //Explorer
        $('#fechadesde').removeClass('hidden');
        $('#fechahasta').removeClass('hidden');
    }
</script>
@endsection