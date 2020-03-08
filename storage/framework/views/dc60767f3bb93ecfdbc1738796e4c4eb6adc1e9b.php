<?php $__env->startSection('htmlheader_title'); ?>
    <?php echo e(trans('adminlte_lang::message.clients')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    Pacientes
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.administracion')); ?></li>
    <li class="active"><?php echo e(trans('adminlte_lang::message.pacientes')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div>
        <a class="btn btn-success"  href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#createpaciente"  role="button">Agregar nuevo paciente</a>
        <?php echo $__env->make('pacientes.create', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Búsqueda</h3>
                </div>
                <?php echo e(Form::open(array('method' => 'GET'))); ?>

                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <?php echo Form::label('rutB', 'RUT:', ['for' => 'rutB'] ); ?>

                                <?php echo Form::text('rutB', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'pattern' => '^[0-9]{7,8}', 'maxlength' => '8', 'title' => 'Ingrese RUT sin puntos', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off'] ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('apellido_paternoB', 'Apellido paterno:', ['for' => 'apellido_paternoB'] ); ?>

                                <?php echo Form::text('apellido_paternoB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('telefonoB', 'Teléfono', ['for' => 'telefonoB'] ); ?>

                                <?php echo Form::text('telefonoB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el número de teléfono', 'maxlength' => '50', 'autocomplete' => 'off']  ); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <?php echo Form::label('direccionB', 'Dirección:', ['for' => 'direccionB'] ); ?>

                                <?php echo Form::text('direccionB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese la dirección', 'maxlength' => '150', 'autocomplete' => 'off']  ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('estadoB', 'Estado:', ['for' => 'estadoB'] ); ?>

                                <?php echo Form::select('estadoB', ['all' => 'Todos', '1' => 'Activos', '0' => 'Inactivos'], null, array('class' => 'form-control sucursal', 'placeholder' => 'Seleccione estado', 'style' => 'width: 100%')); ?>

                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php echo Form::reset('Limpiar', array('onClick'=> 'limpiarSelects()', 'class' => 'btn btn-default')); ?>

                        <?php echo Form::submit('Buscar', array('class' => 'btn btn-info')); ?>

                    </div>
                <?php echo e(Form::close()); ?>

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
                    <?php echo Form::open([  'route' => 'pacientes.exportExcel', 'method' => 'POST']); ?>

                        <?php echo Form::text('rutExcel', null , ['class'=> 'hidden', 'id' => 'rutExcel'] ); ?>

                        <?php echo Form::text('apellido_paternoExcel', null , ['class'=> 'hidden', 'id' => 'apellido_paternoExcel'] ); ?>

                        <?php echo Form::text('telefonoExcel', null , ['class'=> 'hidden', 'id' => 'telefonoExcel'] ); ?>

                        <?php echo Form::text('estadoExcel', null , ['class'=> 'hidden', 'id' => 'estadoExcel'] ); ?>

                        <?php echo Form::text('sucursalExcel', null , ['class'=> 'hidden', 'id' => 'sucursalExcel'] ); ?>

                        <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                            <span class="fa fa-download"></span>
                        </button>
                    <?php echo Form::close(); ?>

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

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
##parent-placeholder-16728d18790deb58b3b8c1df74f06e536b532695##

    <script type="text/javascript">


        var token               = "<?php echo e(csrf_token()); ?>";
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
                        "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>