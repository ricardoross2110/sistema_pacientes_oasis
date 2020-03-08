<?php $__env->startSection('htmlheader_title'); ?>
    <?php echo e(trans('adminlte_lang::message.usuarios')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
    Usuarios
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
    <li><?php echo e(trans('adminlte_lang::message.administracion')); ?></li>
    <li class="active"><?php echo e(trans('adminlte_lang::message.usuarios')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
    
    <?php echo Form::open([ 'route' => 'usuarios.store', 'method' => 'POST', 'onsubmit'=>'return validaCampos();' ]); ?>

    <div>
        <a class="btn btn-success"  href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#createusuario"  role="button">Agregar nuevo usuario</a>
        <?php echo $__env->make('/usuarios/create', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <?php echo Form::close(); ?>


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
                            <div class="form-group col-md-3">
                                <?php echo Form::label('rutB', 'RUT:', ['for' => 'rutB'] ); ?>

                                <?php echo Form::text('rutB', null , ['class' => 'form-control', 'placeholder' => 'Ej: 12345678', 'pattern' => '^[0-9]{7,8}', 'maxlength' => '8', 'title' => 'Ingresa RUT sin puntos', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off'] ); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo Form::label('apellido_paternoB', 'Apellido paterno:', ['for' => 'apellido_paternoB'] ); ?>

                                <?php echo Form::text('apellido_paternoB', null , ['class' => 'form-control', 'placeholder' => 'Ingrese el apellido paterno', 'maxlength' => '50', 'autocomplete' => 'off',  'onkeypress' => 'return soloLetras(event)']  ); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo Form::label('estadoB', 'Estado:', ['for' => 'estadoB'] ); ?>

                                <?php echo Form::select('estadoB', array('all' => 'Todos', '1' => 'Activo', '0' => 'Inactivo'), null, array('class' => 'form-control', 'placeholder' => 'Seleccione estado')); ?>

                            </div>
                            <div class="form-group col-md-3">
                                <?php echo Form::label('perfilB', 'Perfil:', ['for' => 'perfilB'] ); ?>

                                <?php echo Form::select('perfilB', $perfiles, null, array('class' => 'form-control', 'placeholder' => 'Seleccione perfil')); ?>

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
                    <h3 class="box-title">Listado usuarios</h3>
                </div>
                <div class="box-body table-responsive">
                    <?php echo Form::open([  'route' => 'usuarios.exportExcel',  'method' => 'POST']); ?>

                        <?php echo Form::text('rutExcel', null , ['class' => 'hidden', 'id' => 'rutExcel'] ); ?>

                        <?php echo Form::text('apellido_paternoExcel', null , ['class' => 'hidden', 'id' => 'apellido_paternoExcel'] ); ?>

                        <?php echo Form::text('estadoExcel', null , ['class' => 'hidden', 'id' => 'estadoExcel'] ); ?>

                        <?php echo Form::text('perfilExcel', null , ['class' => 'hidden', 'id' => 'perfilExcel'] ); ?>

                        <button type="submit" class="btn btn-success pull-right" title="Exportar a excel" onclick="GuardarValores();" >
                            <span class="fa fa-download"></span>
                        </button>
                    <?php echo Form::close(); ?>

                    <table class="table table-bordered table-striped" id="TablaMisClientes">
                        <thead>
                            <tr>
                                <th class="text-center">RUT</th>
                                <th class="text-center">DV</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Correo electrónico</th>
                                <th class="text-center">Perfil</th>
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
        var estadoB             = $('#estadoB').val();
        var perfilB             = $('#perfilB').val();
        var countDir            = 0;
        var i                   = 0;

        function limpiarSelects() {
            $("#rutB").removeAttr('value');
            $("#apellido_paternoB").removeAttr('value');
            $("#estadoB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
            $("#perfilB").attr('selectedIndex', '-1').find("option:selected").removeAttr("selected");
        }

        $('#TablaMisClientes').DataTable({
            processing: true,
            pageLength: 10,
            searching : false,
            language: {
                        "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                      },
            order: [[ 0, "asc" ]],
            ajax: {
                url: "usuarios.getTabla",
                type: "POST",
                data:{
                        rutB : rutB,
                        apellido_paternoB : apellido_paternoB,
                        estadoB : estadoB,
                        perfilB : perfilB,
                        "_token" : token,                     
                    },
            },
            columns: [
                    {class : "text-center",
                     data: 'rut'},
                    {class : "text-center",
                     data: 'dv'},
                    {class : "text-center",
                     data: 'nombres'},
                    {class : "text-center",
                     data: 'email'},
                    {class : "text-center",
                     data: 'perfil'},
                    {class : "text-center",
                     data: 'estado'},
                    {class : "text-center",
                     data: 'action', name: 'action', orderable: false, searchable: false}                  
                ],
            colReorder: true,
        });

        var tablaMisClientes    = $('#TablaMisClientes').DataTable();


        function validaCampos(){
            var ok = true;

            $('#perfil').find("option:selected").each(function(){
                if ($(this).val().trim() == 0) {
                    $("#mensaje").append("<div id='alerta-1' class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><i class='icon fa fa-ban'></i><strong>Favor seleccione perfil</strong></div>");
                    $("#mensaje").animate({
                                marginTop:'toggle',
                                display:'block'},
                                4000, function() {
                                    $("#alerta-1").remove();      
                    });
                    ok = false;
                }
            })

            if(ok == false){
                return ok;
            }

            var contrasena = document.getElementById("contrasena").value;
            if(contrasena == ''){
                $("#mensaje").append("<div id='alerta-1' class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>×</button><i class='icon fa fa-ban'></i><strong>Favor agregue contraseña</strong></div>");
                $("#mensaje").animate({
                            marginTop:'toggle',
                            display:'block'},
                            4000, function() {
                                $("#alerta-1").remove();      
                });
                ok = false;
            }

            return ok;
        }


        function GuardarValores(){

            var rutExcel                =   $('#rutB').val();
            var apellido_paternoExcel   =   $('#apellido_paternoB').val();
            var estadoExcel             =   $('#estadoB').val();
            var perfilExcel             =   $('#perfilB').val();
      
            if(rutExcel != ''){
                $('#rutExcel').val(rutExcel);
            }
          
            if(apellido_paternoExcel != ''){
                $('#apellido_paternoExcel').val(apellido_paternoExcel);
            }

            if(estadoExcel != ''){
                $('#estadoExcel').val(estadoExcel);
            }

            if(perfilExcel != ''){
                $('#perfilExcel').val(perfilExcel);
            }
        }

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>