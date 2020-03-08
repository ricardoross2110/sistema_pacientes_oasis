<?php $__env->startSection('htmlheader_title'); ?>
    <?php echo e(trans('adminlte_lang::message.profesional')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    Profesionales
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.administracion')); ?></li>
    <li class="active"><?php echo e(trans('adminlte_lang::message.profesional')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>

    <div>
        <a class="btn btn-success"  href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#createprofesional"  role="button">Agregar nuevo profesional</a>
        <?php echo $__env->make('profesionales.create', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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

                                <?php echo Form::text('rutB', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678' , 'pattern' => '^[0-9]{7,8}', 'onkeypress' => 'return onlyNumbers(event)', 'maxlength' => '8', 'autocomplete' => 'off']  ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('apellido_paternoB', 'Apellido paterno:', ['for' => 'apellido_paternoB'] ); ?>

                                <?php echo Form::text('apellido_paternoB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('correoB', 'Correo electrónico:', ['for' => 'correoB'] ); ?>

                                <?php echo Form::text('correoB', null , ['class' => 'form-control', 'id' => 'correoB', 'placeholder' => 'Ingrese el correo electrónico', 'maxlength' => '50', 'autocomplete' => 'off']  ); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <?php echo Form::label('direccionB', 'Dirección:', ['for' => 'direccionB'] ); ?>

                                <?php echo Form::text('direccionB', null , ['class' => 'form-control', 'id' => 'direccionB', 'placeholder' => 'Ingrese el dirección', 'maxlength' => '50', 'autocomplete' => 'off']  ); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('estadoB', 'Estado:', ['for' => 'estadoB'] ); ?>

                                <?php echo Form::select('estadoB', ['all' => 'Todos', '1' => 'Activos', '0' => 'Inactivos'], null, array('class' => 'form-control', 'placeholder' => 'Seleccione estado')); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('sucursalB', 'Sucursal:', ['for' => 'sucursalB'] ); ?>

                                <?php echo Form::select('sucursalB[]', $sucursales, null, array('class' => 'form-control sucursalb', 'multiple', 'data-placeholder' => 'Seleccione sucursal')); ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <?php echo Form::label('profesionB', 'Profesión:', ['for' => 'profesionB'] ); ?>

                                <?php echo Form::select('profesionB', $profesiones, null, array('class' => 'form-control', 'placeholder' => 'Seleccione profesión')); ?>

                            </div>
                            <div class="form-group col-md-4">
                                <?php echo Form::label('tipoContratoB', 'Tipo de contrato:', ['for' => 'tipoContratoB'] ); ?>

                                <?php echo Form::select('tipoContratoB', $tipoContrato, null, array('class' => 'form-control', 'placeholder' => 'Seleccione tipo de contrato')); ?>

                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php echo Form::reset('Limpiar', array('onClick' => 'limpiarSelects()', 'class' => 'btn btn-default')); ?>

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
                    <h3 class="box-title">Listado profesionales</h3>
                </div>
                <div class="box-body table-responsive">
                    <?php echo Form::open(['route' => 'profesionales.exportExcel', 'method' => 'POST']); ?>

                        <?php echo Form::text('rutExcel', null , ['class' => 'hidden', 'id' => 'rutExcel'] ); ?>

                        <?php echo Form::text('apellido_paternoExcel', null , ['class' => 'hidden', 'id' => 'apellido_paternoExcel'] ); ?>

                        <?php echo Form::text('correoExcel', null , ['class' => 'hidden', 'id' => 'correoExcel'] ); ?>

                        <?php echo Form::text('direccionExcel', null , ['class' => 'hidden', 'id' => 'direccionExcel'] ); ?>

                        <?php echo Form::text('sucursalExcel', null , ['class' => 'hidden', 'id' => 'sucursalExcel'] ); ?>

                        <?php echo Form::text('estadoExcel', null , ['class' => 'hidden', 'id' => 'estadoExcel'] ); ?>

                        <?php echo Form::text('profesionExcel', null , ['class' => 'hidden', 'id' => 'profesionExcel'] ); ?>

                        <?php echo Form::text('tipoContratoExcel', null , ['class' => 'hidden', 'id' => 'tipoContratoExcel'] ); ?>

                        <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                            <span class="fa fa-download"></span>
                        </button>
                    <?php echo Form::close(); ?>

                    <table class="table table-bordered table-striped" id="TablaProfesionales">
                        <thead>
                            <tr>
                                <th class="text-center">RUT</th>
                                <th class="text-center">DV</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Correo</th>
                                <th class="text-center">Dirección</th>
                                <th class="text-center">Profesión</th>
                                <th class="text-center">Tipo contrato</th>
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
        var correoB             = $('#correoB').val();
        var direccionB          = $('#direccionB').val();
        var sucursalb           = [];
        var profesionB          = $('#profesionB').val();
        var tipoContratoB       = $('#tipoContratoB').val();
        var estadoB             = $('#estadoB').val();

        $('.sucursal').select2();
        $('.sucursalb').select2();

        <?php if(isset($sucursalB)): ?>
          <?php $__currentLoopData = $sucursalB; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sucursal_b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            sucursalb.push(<?php echo e($sucursal_b); ?>);
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        function limpiarSelects() {
            $("#rutB").removeAttr('value');
            $("#apellido_paternoB").removeAttr('value');
            $("#correoB").removeAttr('value');
            $("#direccionB").removeAttr('value');
            $("#estadoB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
            $("#profesionB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
            $("#tipoContratoB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
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
                url     : "<?php echo e(url('sucursal.cargarSucursales')); ?>",
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


        var tablaProfesionales = $('#TablaProfesionales').DataTable({
            processing: true,
            pageLength: 10,
            searching : false,
            language: {
                        "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                      },
            order: [[ 0, "asc" ]],
            ajax: {
                url: "profesionales.getTabla",
                type: "POST",
                data:{
                        rutB                : rutB,
                        apellido_paternoB   : apellido_paternoB,
                        correoB             : correoB,
                        direccionB          : direccionB,
                        sucursalB           : sucursalb,
                        profesionB          : profesionB,
                        tipoContratoB       : tipoContratoB,
                        estadoB             : estadoB,
                        "_token"            : token,                     
                    },
            },
            columns: [
                    {class : "text-center",
                     data: 'detalle_rut'},
                    {class : "text-center",
                     data: 'dv'},
                    {class : "text-center",
                     data: 'nombre_profesional'},
                    {class : "text-center",
                     data: 'email'},
                    {class : "text-center",
                     data: 'direccion'},
                    {class : "text-center",
                     data: 'profesion'},
                    {class : "text-center",
                     data: 'tipo_contrato'},
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
            var correoExcel             =   $('#correoB').val();
            var direccionExcel          =   $('#direccionB').val();
            var estadoExcel             =   $('#estadoB').val();
            var sucursalesExcel         =   [];     
            //var sucursalExcel           =   JSON.stringify($('#sucursalB').val());
            var profesionExcel          =   $('#profesionB').val();
            var tipoContratoExcel       =   $('#tipoContratoB').val();

            $.each($(".sucursalb option:selected"), function(){            
                sucursalesExcel.push($(this).val());
            });
      
            sucursalesExcel     =   JSON.stringify(sucursalesExcel);

            if(rutExcel != ''){
                $('#rutExcel').val(rutExcel);
            }
          
            if(apellido_paternoExcel != ''){
                $('#apellido_paternoExcel').val(apellido_paternoExcel);
            }

            if(correoExcel != ''){
                $('#correoExcel').val(correoExcel);
            }

            if(direccionExcel != ''){
                $('#direccionExcel').val(direccionExcel);
            }

            if(estadoExcel != ''){
                $('#estadoExcel').val(estadoExcel);
            }

            $('#sucursalExcel').val(sucursalesExcel);

            if(profesionExcel != ''){
                $('#profesionExcel').val(profesionExcel);
            }
            if(tipoContratoExcel != ''){
                $('#tipoContratoExcel').val(tipoContratoExcel);
            }
        }

        $(document).ready(function() {
            cargarSelects();

            var sucursal_select      =   $('.sucursal');
            sucursal_select.val(null).trigger("change");

        });

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>