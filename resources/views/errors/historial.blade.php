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
        <li class="active">Errores</li>
@endsection

@section('main-content')
        <br>
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Búsqueda</h3>
            </div>
            
            <div class="box-body">
                <form action="" method="GET">
                    <input type="hidden" id="browser" name="browser" value="">
                    <div class="row">
                        <div class="form-group col-md-6">
                            {!! Form::label('fechadesde', 'Fecha desde', ['for' => 'fechadesde'] ) !!}
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                {!! Form::number('fechadesde', null , ['class' => 'form-control  pull-right hidden', 'id' => 'fechadesde', 'placeholder' => 'DD/MM/AAAA', 'autocomplete' => 'off', 'pattern' => '\d{1,2}/\d{1,2}/\d{4}', 'maxlength' => '10', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}

                                {!! Form::text('fechadesdeChrome', null , ['class' => 'form-control  pull-right hidden', 'id' => 'fechadesdeChrome', 'placeholder' => 'DD/MM/AAAA', 'autocomplete' => 'off', 'pattern' => '\d{1,2}/\d{1,2}/\d{4}', 'maxlength' => '10', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('fechahasta', 'Fecha hasta', ['for' => 'fechahasta'] ) !!}
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                {!! Form::number('fechahasta', null, ['class' => 'form-control  pull-right hidden', 'id' => 'fechahasta', 'placeholder' => 'DD/MM/AAAA', 'autocomplete' => 'off', 'pattern' => '\d{1,2}/\d{1,2}/\d{4}', 'maxlength' => '10', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
                                {!! Form::text('fechahastaChrome', null, ['class' => 'form-control  pull-right hidden', 'id' => 'fechahastaChrome', 'placeholder' => 'DD/MM/AAAA', 'autocomplete' => 'off', 'pattern' => '\d{1,2}/\d{1,2}/\d{4}', 'maxlength' => '10', 'onkeypress' => 'return onlyNumbers(event)']  ) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-danger">Buscar</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="box box-danger">
            <div class="box-header">
                <h3 class="box-title">Historial de errores</h3>
            </div>
            <div class="box-body">
                {!! Form::open([ 'route' => 'programas.exportExcel', 'method' => 'POST']) !!}
                    {!! Form::text('fechadesdeExcel', null , ['class' => 'hidden form-control', 'class' => 'hidden','id' => 'fechadesdeExcel']  ) !!}
                    {!! Form::text('fechahastaExcel', null , ['class' => 'hidden form-control', 'id' => 'fechahastaExcel']  ) !!}
                    {!! Form::text('fechadesdeChromeExcel', null , ['class' => 'hidden form-control', 'id' => 'fechadesdeChromeExcel' ]  ) !!}
                    {!! Form::text('fechahastaChromeExcel', null , ['class' => 'hidden form-control', 'id' => 'fechahastaChromeExcel']  ) !!}
                    <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" ><span class="fa fa-download"></span></button>
                {!! Form::close() !!}
                <table class="dataTables_wrapper table table-bordered" id="MyTableErrores">
                    <thead>
                        <tr>
                            <th class="text-center">Tipo de error</th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center">Usuario</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($errores as $error)
                        <tr>
                            <td><strong>{{ $error->tipo_error }}</strong></td>
                            <td>{{ $error->detalle }}</td>
                            <td><strong>{{ $error->user->name }}</strong></td>
                            <td><p class="hidden">{{ $error->created_at }}</p>{{ \Carbon\Carbon::parse($error->created_at)->format('d/m/Y H:i:s') }}</td>
                            <td class="text-center iconos">
                                @if(isset($error->mensaje))
                                <a href="{{ asset('/errores/'.$error->id) }}">
                                    <span class="fa fa-eye" aria-hidden="true" title="Detalle"></span>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>     
                </table>
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