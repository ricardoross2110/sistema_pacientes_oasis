@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.clients') }}
@endsection

@section('contentheader_title')
    Pacientes
@endsection

@section('breadcrumb_nivel')
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>{{ trans('adminlte_lang::message.dashboard') }}</a></li>
    <li>{{ trans('adminlte_lang::message.administracion') }}</li>
    <li class="active">{{ trans('adminlte_lang::message.pacientes') }}</li>
@endsection

@section('main-content')

    <div>
        <a class="btn btn-success"  href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#createpaciente"  role="button">Agregar nuevo paciente</a>
        @include('pacientes.create')
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Búsqueda</h3>
                </div>
                {{ Form::open(array('method' => 'GET')) }}
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                {!! Form::label('rutB', 'RUT:', ['for' => 'rutB'] ) !!}
                                {!! Form::text('rutB', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'pattern' => '^[0-9]{7,8}', 'maxlength' => '8', 'title' => 'Ingrese RUT sin puntos', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off'] ) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('apellido_paternoB', 'Apellido paterno:', ['for' => 'apellido_paternoB'] ) !!}
                                {!! Form::text('apellido_paternoB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)',  'onkeypress' => 'return soloLetras(event)']  ) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('telefonoB', 'Teléfono', ['for' => 'telefonoB'] ) !!}
                                {!! Form::text('telefonoB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el número de teléfono', 'maxlength' => '50', 'autocomplete' => 'off']  ) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                {!! Form::label('direccionB', 'Dirección:', ['for' => 'direccionB'] ) !!}
                                {!! Form::text('direccionB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese la dirección', 'maxlength' => '150', 'autocomplete' => 'off']  ) !!}
                            </div>
                            <div class="form-group col-md-4">
                                {!! Form::label('estadoB', 'Estado:', ['for' => 'estadoB'] ) !!}
                                {!! Form::select('estadoB', ['all' => 'Todos', '1' => 'Activos', '0' => 'Inactivos'], null, array('class' => 'form-control sucursal', 'placeholder' => 'Seleccione estado', 'style' => 'width: 100%')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! Form::reset('Limpiar', array('onClick'=> 'limpiarSelects()', 'class' => 'btn btn-default')) !!}
                        {!! Form::submit('Buscar', array('class' => 'btn btn-info')) !!}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Listado pacientes</h3>
                </div>
                <div class="box-body table-responsive">
                    {!! Form::open([  'route' => 'pacientes.exportExcel', 'method' => 'POST']) !!}
                        {!! Form::text('rutExcel', null , ['class'=> 'hidden', 'id' => 'rutExcel'] ) !!}
                        {!! Form::text('apellido_paternoExcel', null , ['class'=> 'hidden', 'id' => 'apellido_paternoExcel'] ) !!}
                        {!! Form::text('telefonoExcel', null , ['class'=> 'hidden', 'id' => 'telefonoExcel'] ) !!}
                        {!! Form::text('estadoExcel', null , ['class'=> 'hidden', 'id' => 'estadoExcel'] ) !!}
                        {!! Form::text('sucursalExcel', null , ['class'=> 'hidden', 'id' => 'sucursalExcel'] ) !!}
                        <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                            <span class="fa fa-download"></span>
                        </button>
                    {!! Form::close() !!}
                    <table class="table table-bordered table-striped" id="TablaPacientes">
                        <thead>
                            <tr>
                                <th class="text-center">RUT</th>
                                <th class="text-center">DV</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Teléfono</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Acciones</th>
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


        var token               = "{{ csrf_token() }}";
        var rutB                = $('#rutB').val();
        var apellido_paternoB   = $('#apellido_paternoB').val();
        var telefonoB           = $('#telefonoB').val();
        var direccionB          = $('#direccionB').val();
        var estadoB             = $('#estadoB').val();
        var sucursalB           = $('#sucursalB').val();

        function limpiarSelects() {
            $("#rutB").removeAttr('value');
            $("#apellido_paternoB").removeAttr('value');
            $("#telefonoB").removeAttr('value');
            $("#direccionB").removeAttr('value');
            $("#telefonoB").removeAttr('value');
            $("#estadoB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
            $("#sucursalB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
        }

        //Date picker

        $('#fecha_nacimientoN').datepicker({
            format: "dd/mm/yyyy",
            language: 'es',
            todayHighlight: true,
            autoclose: true,
        });  

        var tablaPacientes    = $('#TablaPacientes').DataTable({
            processing: true,
            pageLength: 10,
            searching : false,
            language: {
                        "url": '{!! asset('/plugins/datatables/latino.json') !!}'
                      },
            order: [[ 0, "asc" ]],
            ajax: {
                url: "pacientes.getTabla",
                type: "POST",
                data:{
                        rutB                : rutB,
                        apellido_paternoB   : apellido_paternoB,
                        telefonoB           : telefonoB,
                        direccionB          : direccionB,
                        estadoB             : estadoB,
                        sucursalB           : sucursalB,
                        "_token"            : token,                     
                    },
            },
            columns: [
                    {class : "text-center",
                     data: 'detalle_rut'},
                    {class : "text-center",
                     data: 'dv'},
                    {class : "text-center",
                     data: 'nombre_paciente'},
                    {class : "text-center",
                     data: 'telefono'},
                    {class : "text-center",
                     data: 'estado'},
                    {class : "text-center",
                     data: 'action', name: 'action', orderable: false, searchable: false}
                ],
            colReorder: true,
        });

        function GuardarValores(){
            var rutExcel                =   $('#rutB').val();
            var apellido_paternoExcel   =   $('#apellido_paternoB').val();
            var estadoExcel             =   $('#estadoB').val();
            var telefonoExcel           =   $('#telefonoB').val();
            var direcionExcel           =   $('#direccionB').val();
            var sucursalExcel           =   $('#sucursalB').val();
      
            if(rutExcel != ''){
                $('#rutExcel').val(rutExcel);
            }
          
            if(apellido_paternoExcel != ''){
                $('#apellido_paternoExcel').val(apellido_paternoExcel);
            }

            if(estadoExcel != ''){
                $('#estadoExcel').val(estadoExcel);
            }

            if(telefonoExcel != ''){
                $('#telefonoExcel').val(telefonoExcel);
            }

            if(direcionExcel != ''){
                $('#direcionExcel').val(direcionExcel);
            }

            if(sucursalExcel != ''){
                $('#sucursalExcel').val(sucursalExcel);
            }
        }

    </script>

@endsection
