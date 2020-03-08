<?php $__env->startSection('htmlheader_title'); ?>
  <?php echo e(trans('adminlte_lang::message.dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('contentheader_title'); ?>
  Bienvenido al sistema de gestión OASIS
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb_nivel'); ?>  
    <li><a href="<?php echo e(url('/home')); ?>"><i class="fa fa-dashboard"></i><?php echo e(trans('adminlte_lang::message.dashboard')); ?></a></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main-content'); ?>
 
    <div class="row">
      <?php if(Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 4): ?>
        <!-- Parte que visualizará secretaria y asistente, incluye una sección de "Acciones Rápidas" -->
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="box box-info">
            <div class="box-header text-center">
              <strong>Acciones Rápidas</strong>
            </div>
            <div class="box-body">              
              <a id="busqueda_button"  href="#" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".buscarPacienteModal" class=" btn btn-block btn-social btn-primary ">
                <i class="fa fa-search"></i> Buscar tratamientos por RUT
              </a>
              <?php if(Auth::user()->perfil_id == 3): ?>
              <a  href="<?php echo e(url('/tratamiento/create')); ?>" class="btn bg-purple btn-block btn-social ">
                <i class="fa fa-file-text"></i> Registrar tratamiento
              </a>
              <a  href="<?php echo e(url('/RegistrarReserva')); ?>" class="btn bg-purple btn-block btn-social ">
                <i class="fa fa-plus"></i> Registrar reserva
              </a>
              <a href="#" class="btn btn-block btn-social btn-success " data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#createpaciente">
                <i class="fa fa-user"></i> Agregar nuevo paciente
              </a>
              <?php endif; ?>
              <a  href="<?php echo e(url('/tratamiento')); ?>" class="btn btn-block btn-social btn-info">
                <i class="fa fa-eye"></i> Ver tratamientos
              </a>
              <a  href="<?php echo e(url('/reserva/')); ?>" class="btn btn-block btn-social btn-warning">
                <i class="fa fa-list"></i> Ver reservas
              </a>
            </div>
          </div>
        </div>
        
        <?php echo $__env->make('pacientes.create', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="modal fade buscarPacienteModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-blue">
                <h2 class="box-title text-center">Búsqueda</h2>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="form-group col-md-3">
                    <?php echo Form::label('rutT', 'Rut del paciente:' ); ?>

                    <?php echo Form::text('rutT', null , ['class' => 'form-control', 'placeholder' => 'Ingrese rut del paciente', 'maxlength' => '8', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off'] ); ?>

                  </div>
                  <div class="form-group col-md-3">
                    <?php echo Form::label('nombrePacienteT', 'Nombre del paciente:' ); ?>

                    <?php echo Form::text('nombrePacienteT', null , ['class' => 'form-control', 'placeholder' => 'Nombre del paciente', 'maxlength' => '150', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ); ?>

                  </div>
                  <div class="form-group col-md-3">
                    <?php echo Form::label('telefonoT', 'Teléfono:' ); ?>

                    <?php echo Form::text('telefonoT', null , ['class' => 'form-control', 'placeholder' => 'Número de telefono', 'maxlength' => '16', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ); ?>

                  </div>
                  <div class="form-group col-md-3">
                    <?php echo Form::label('tipo_tratamientoT', 'Tipo de tratamiento:', ['for' => 'tipo_tratamientoT'] ); ?>

                    <?php echo Form::select('tipo_tratamientoT',  $tipo_tratamientos, null, array('class' => 'form-control', 'placeholder' => 'Seleccione tipo de tratamiento', 'required')); ?>

                  </div>
                </div>
                <div class="row hidden">
                  <div class="form-group col-md-4">
                    <?php echo Form::label('nfolioT', 'N° de Folio:' ); ?>

                    <?php echo Form::text('nfolioT', null , ['class' => 'form-control', 'placeholder' => 'Número de Folio', 'maxlength' => '11', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off'] ); ?>

                  </div>
                  <div class="form-group col-md-4">
                    <?php echo Form::label('nombreTratamientoT', 'Nombre del Tratamiento:' ); ?>

                    <?php echo Form::text('nombreTratamientoT', null , ['class' => 'form-control', 'placeholder' => 'Nombre del tratamiento', 'maxlength' => '150', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ); ?>

                  </div>
                  <div class="form-group col-md-4">
                    <?php echo Form::label('controlesT', 'Controles:' ); ?>

                    <?php echo Form::text('controlesT', null , ['class' => 'form-control', 'placeholder' => 'Número de controles', 'maxlength' => '16', 'onkeypress' => 'return onlyNumbers(event)', 'autocomplete' => 'off', 'disabled'] ); ?>

                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-12">
                    <div class="box-footer">
                      <button  id="limpiar_button" type="button" class="btn btn-default pull-left">Limpiar</button>
                      <button  id="busquedar_ahora" type="button" class="btn btn-primary pull-right">Buscar</button>
                    </div>  
                  </div>
                </div>

                <div id="div_tabla_busqueda" class="row hidden">
                  <div class="form-group col-md-12 table-responsive">
                    <table id="tableTratamiento" class="table table-bordered table-striped table-hover">
                      <thead>
                        <tr>
                          <th class="text-center">Folio</th>
                          <th class="text-center">Tratamiento</th>
                          <th class="text-center">Tipo</th>
                          <th class="text-center">Rut</th>
                          <th class="text-center">Paciente</th>
                          <th class="text-center">Número de atenciones</th>
                          <?php if(Auth::user()->perfil_id == 3): ?>
                          <th class="text-center">Valor total</th>
                            <th class="text-center">Deuda</th>
                          <?php endif; ?>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
              <div class="modal-footer">
                <button id="cancelar_busqueda" type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="row">
            <div class="col-lg-12 col-md-12">          
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text text-center"><strong>Santoral del día</strong></span>
                    <br>
                    <?php if(count($santoHoy) == 0): ?>
                      <span class="info-box-text">Probando.</span>
                    <?php else: ?>
                      <?php $__currentLoopData = $santoHoy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$hoy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($i < 2): ?>
                          <span class="info-box-text">
                            <center>San(ta) <?php echo e($hoy->santo); ?></center>
                          </span>  
                        <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php if(count($santoHoy) > 2): ?>
                        <a href="#" class="pull-right small-box-footer" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cumplehoy">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
                        <div class="modal fade" id="cumplehoy" tabindex="-1" role="dialog" aria-labelledby="cumplehoyLabel" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header bg-yellow">
                                <h2 class="modal-title" id="cumplehoyLabel" style="text-align: center"><strong>Santoral del día</strong></h2>
                              </div>
                              <div class="modal-body text-center">
                                <table class="dataTables_wrapper table table-bordered" id="MyTable">
                                    <tbody>
                                    <?php $__currentLoopData = $santoHoy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$hoy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                      <td>
                                         San(ta) <?php echo e($hoy->santo); ?>

                                      </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  </tbody>
                                </table>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>
                    <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 col-md-12">
              <div class="row">
                <div class="col-lg-12 col-md-12">        
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-birthday-cake"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text text-center"><strong>Cumpleaños</strong></span>
                      <?php if(count($pacientesclumplehoy) == 0): ?>
                        <span class="info-box-text">
                          <center>No hay cumpleaños.</center>
                        </span>
                      <?php else: ?>
                        <?php $__currentLoopData = $pacientesclumplehoy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$hoy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if($i < 2): ?>
                            <span class="info-box-text">
                              <center><a href="<?php echo e(url('/pacientes/'.$hoy->rut)); ?>"><?php echo e($hoy->nombres); ?> <?php echo e($hoy->apellido_paterno); ?> <?php echo e($hoy->apellido_materno); ?></a> (<?php echo e($hoy->edad); ?> Años)</center>
                            </span>
                          <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if(count($pacientesclumplehoy) > 2): ?>
                          <a href="#" class="pull-right small-box-footer" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cumplehoy">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
                          <div class="modal fade" id="cumplehoy" tabindex="-1" role="dialog" aria-labelledby="cumplehoyLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header bg-green">
                                  <h2 class="modal-title" id="cumplehoyLabel" style="text-align: center"><strong>Cumpleaños de Hoy</strong></h2>
                                </div>
                                <div class="modal-body text-center  table-responsive">
                                  <table class="dataTables_wrapper table table-bordered" id="MyTable">
                                      <thead>
                                      </thead>
                                      <tbody>
                                      <?php $__currentLoopData = $pacientesclumplehoy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$hoy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr>
                                        <td>
                                          <a href="<?php echo e(url('/pacientes/'.$hoy->rut)); ?>"><?php echo e($hoy->nombres); ?> <?php echo e($hoy->apellido_paterno); ?> <?php echo e($hoy->apellido_materno); ?></a> (<?php echo e($hoy->edad); ?> Años)
                                        </td>
                                      </tr>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                  </table>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php endif; ?>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php else: ?>
      <!-- Parte que visualizará superadministrador y administrador, incluye "semáforo" de alertas de no pago -->
        <div class="col-md-4 col-sm-12 col-xs-12"> 
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-birthday-cake"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-center"><strong>Cumpleaños</strong></span>
              <br>
              <?php if(count($pacientesclumplehoy) == 0): ?>              
                <span class="info-box-text">
                  <center>No hay cumpleaños.</center>
                </span>
              <?php else: ?>
                <?php $__currentLoopData = $pacientesclumplehoy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$hoy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($i < 2): ?>
                    <span class="info-box-text">
                      <center><a href="<?php echo e(url('/pacientes/'.$hoy->rut)); ?>"><?php echo e($hoy->nombres); ?> <?php echo e($hoy->apellido_paterno); ?> <?php echo e($hoy->apellido_materno); ?></a> (<?php echo e($hoy->edad); ?> Años)</center>
                    </span>  
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(count($pacientesclumplehoy) > 2): ?>
                  <a href="#" class="pull-right small-box-footer" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cumplehoy">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
                  <div class="modal fade" id="cumplehoy" tabindex="-1" role="dialog" aria-labelledby="cumplehoyLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-green">
                          <h2 class="modal-title" id="cumplehoyLabel" style="text-align: center"><strong>Cumpleaños de Hoy</strong></h2>
                        </div>
                        <div class="modal-body text-center  table-responsive">
                          <table class="dataTables_wrapper table table-bordered" id="MyTable">
                              <thead>
                              </thead>
                              <tbody>
                              <?php $__currentLoopData = $pacientesclumplehoy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$hoy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <td>
                                  <h6><center><a href="<?php echo e(url('/pacientes/'.$hoy->rut)); ?>"><?php echo e($hoy->nombres); ?> <?php echo e($hoy->apellido_paterno); ?> <?php echo e($hoy->apellido_materno); ?></a> (<?php echo e($hoy->edad); ?> Años)</center></h6>
                                </td>
                              </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Aceptar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
            <div class="info-box-content">
              <span class="info-box-text text-center"><strong>Santoral del día</strong></span>
              <br>
              <?php if(count($santoHoy) == 0): ?>
                <span class="info-box-text">No hay santoral el día de hoy.</span>
              <?php else: ?>
                <?php $__currentLoopData = $santoHoy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$hoy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($i < 2): ?>
                    <span class="info-box-text">
                      <center>San(ta) <?php echo e($hoy->santo); ?></center>
                    </span>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(count($santoHoy) > 2): ?>
                  <a href="#" class="pull-right small-box-footer" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#cumplehoy">Ver todos <i class="fa fa-arrow-circle-right"></i></a>
                  <div class="modal fade" id="cumplehoy" tabindex="-1" role="dialog" aria-labelledby="cumplehoyLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header bg-yellow">
                          <h2 class="modal-title" id="cumplehoyLabel" style="text-align: center"><strong>Santoral del día</strong></h2>
                        </div>
                        <div class="modal-body text-center  table-responsive">
                          <table class="dataTables_wrapper table table-bordered" id="MyTable">
                              <tbody>
                              <?php $__currentLoopData = $santoHoy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$hoy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <tr>
                                <td>
                                   San(ta) <?php echo e($hoy->santo); ?>

                                </td>
                              </tr>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                          </table>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endif; ?>
      <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>
          <div class="info-box-content">
            <span class="info-box-text text-center">
              <strong>Fecha y hora</strong>
            </span>
            <h5 class="text-center"><p id="fecha_hora"></p></h5>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <?php if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2): ?>
        <div class="col-md-offset-2 col-md-8 col-sm-12 col-xs-12">
           <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title text-center">Alertas de no pago</h3>
              </div>

              <div class="box-body table-responsive no-padding">
                <ul class="nav nav-stacked">
                  <li><a id="personasAtrasadas" href="#" data-toggle="modal" data-target="#modalPersonasAtrasadas">Personas con más de un mes de no pago <span class="pull-right badge bg-red"><?php echo e($pacientes_atrasadas); ?></span></a></li>
                    <div class="modal fade" id="modalPersonasAtrasadas" tabindex="-1"aria-labelledby="modalPersonasAtrasadasLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg"role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-red">
                            <h2 class="modal-title" id="modalPersonasAtrasadasLabel"><center>Personas con atrasos de deudas</center></h2>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12  table-responsive">
                                <table class="table table-bordered table-striped" id="tablaPersonasConAtraso">
                                  <thead>
                                    <tr>
                                      <th class="text-center">RUT</th>
                                      <th class="text-center">Folio</th>
                                      <th class="text-center">Paciente</th>
                                      <th class="text-center">Última atención</th>
                                      <th class="text-center">Debe</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <li><a id="personasDeudas" href="#" data-toggle="modal" data-target="#modalPersonasConDeudas">Personas con deudas <span class="pull-right badge bg-yellow"><?php echo e($pacientes_deuda); ?></span></a></li>
                    <div class="modal fade" id="modalPersonasConDeudas" tabindex="-1"aria-labelledby="modalPersonasConDeudasLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg"role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-yellow">
                            <h2 class="modal-title" id="modalPersonasConDeudasLabel"><center>Personas con deudas</center></h2>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12  table-responsive">
                                <table class="table table-bordered table-striped" id="tablaPersonasConDeudas">
                                  <thead>
                                    <tr>
                                      <th class="text-center">RUT</th>
                                      <th class="text-center">Folio</th>
                                      <th class="text-center">Paciente</th>
                                      <th class="text-center">Última atención</th>
                                      <th class="text-center">Debe</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <li><a id="personasDia" href="#" data-toggle="modal" data-target="#modalPersonasAlDia">Personas al día <span class="pull-right badge bg-green"><?php echo e($pacientes_al_dia); ?></span></a></li>
                    <div class="modal fade" id="modalPersonasAlDia" tabindex="-1" aria-labelledby="modalPersonasAlDiaLabel" aria-hidden="true">
                      <div class="modal-dialog modal-lg"role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-green">
                            <h2 class="modal-title" id="modalPersonasAlDiaLabel"><center>Personas al día</center></h2>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-md-12  table-responsive">
                                <table class="table table-bordered table-striped" id="tablaPersonasAlDia">
                                  <thead>
                                    <tr>
                                      <th class="text-center">RUT</th>
                                      <th class="text-center">Folio</th>
                                      <th class="text-center">Paciente</th>
                                      <th class="text-center">Última atención</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                </ul>
              </div>

              <div class="box-footer">
                
              </div>
            </div>
        </div>
      <?php endif; ?>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="box box-info">
          <div class="box-header text-center">
            <strong>Información de las sucursales</strong>
          </div>
          <div class="box-body table-responsive">
            <table class="table table-bordered table-striped" id="tablaSucursal">
              <thead>
                <tr>
                  <th class="text-center">Sucursal</th>
                  <th class="text-center">Teléfono</th>
                  <th class="text-center">WhatsApp</th>
                  <th class="text-center">Dirección</th>
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

  <!-- scripts Gráficos -->
  <script type="text/javascript">
    var token                =  "<?php echo e(csrf_token()); ?>";

    var date  = new Date();
    /*Miércoles, 09 de enero de 2019 - 9:00 AM*/
    var days  = ["Domingo", "Lunes","Martes","Miércoles", "Jueves", "Viernes", "Sábado","Domingo"];

    setInterval(function() {
      var minuto = 0;
      var hora = 0;
      var dia = 0;
      console.log();
        date.setSeconds(date.getSeconds() + 1);
        var meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

        if (date.getMinutes() < 10) {
          minuto = '0' + date.getMinutes();
        }else{
          minuto = date.getMinutes();
        }

        if (date.getHours() < 10) {
          hora = '0' + date.getHours();
        }else{
          hora = date.getHours();
        }

        if (date.getDate() < 10) {
          dia = '0' + date.getDate();
        }else{
          dia = date.getDate();
        }

        $('#fecha_hora').html(days[date.getDay()] + ', ' + dia +' de ' + meses[date.getMonth()] + ' de ' + date.getFullYear() + '<br>' + hora +':' +minuto);
    }, 1000);

    function limpiar() {      
      $('#rutT').val(null);
      $('#nombrePacienteT').val(null);
      $('#telefonoT').val(null);
      $("#tipo_tratamientoT").val(null); 
    }

    $(document).ready(function() {
      var rutT    = $('#rutT').val();
      var nfolioT = $('#nfolioT').val();
      var tipo_tratamientoT = $('#tipo_tratamientoT').val();

      $('#fecha_nacimientoN').datepicker({
        format: "dd/mm/yyyy",
        language: 'es',
        todayHighlight: true,
        autoclose: true,
      });

      $('#tablaSucursal').DataTable({
        paging: true,
        processing: true,
        pageLength: 10,
        searching   : true,
        language: {
                    "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                  },
        order: [[ 0, "asc" ]],
        colReorder: true,
        ajax: {
            url: "<?php echo e(url('sucursales.getTabla')); ?>",
            type: "POST",
            data:{
                    "_token" : token,                     
                },
        },  
        columns: [
                {class : "text-center",
                 data: 'nombre'},
                {class : "text-center",
                 data: 'telefono'},
                {class : "text-center",
                 data: 'whatsapp'},
                {class : "text-center",
                 data: 'direccion'}
            ],
      });

      $('#tablaPersonasAlDia').DataTable({
        paging: true,
        processing: true,
        pageLength: 10,
        searching   : true,
        language: {
                    "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                  },
        order: [ 0, "asc" ],
        colReorder: true,
        ajax: {
            url: "<?php echo e(url('home.cargarTablePersonasAlDia')); ?>",
            type: "POST",
            data:{
                    "_token" : token,                     
                },
        },
        columnDefs: [
                    { targets: 3, render: $.fn.dataTable.render.moment('YYYY/MM/DD', 'DD-MM-YYYY') }
        ],     
        columns : [
                    {class : "text-center",
                     data: 'detalle_rut'},
                    {class : "text-center",
                     data: 'detalle_folio'},
                    {class : "text-center",
                     data: 'paciente'},
                    {class : "text-center",
                     data: 'ultima_atencion'}
                  ],
        colReorder: true
      });

      $('#rutT').keypress(function(e) {
        if(e.which == 13) {
          $('#busquedar_ahora').click();
        }
      });

      $('#cancelar_busqueda').click(function(e) {
        limpiar();
      });

      $('#limpiar_button').click(function(e) {
        limpiar();
      });

      $('#tablaPersonasConDeudas').DataTable({
        paging: true,
        processing: true,
        pageLength: 10,
        searching   : true,
        language: {
                    "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                  },
        order: [ 0, "asc" ],
        ajax: {
            url: "<?php echo e(url('home.cargarTablePersonasDeudas')); ?>",
            type: "POST",
            data:{
                    "_token" : token,                     
                },
        },
        columnDefs: [
                    { targets: 3, render: $.fn.dataTable.render.moment('YYYY/MM/DD', 'DD-MM-YYYY') }
        ],     
        columns : [
                    {class : "text-center",
                     data: 'detalle_rut'},
                    {class : "text-center",
                     data: 'detalle_folio'},
                    {class : "text-center",
                     data: 'paciente'},
                    {class : "text-center",
                     data: 'ultima_atencion'},
                    {class : "text-center",
                     data: 'deuda'}
                  ],
        colReorder: true
      });

      $('#tablaPersonasConAtraso').DataTable({
        paging: true,
        processing: true,
        pageLength: 10,
        searching   : true,
        language: {
                    "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>'
                  },
        order: [ 0, "asc" ],
        ajax: {
            url: "<?php echo e(url('home.cargarTablePersonasAtrasado')); ?>",
            type: "POST",
            data:{
                    "_token" : token,                     
                },
        },
        columnDefs: [
                    { targets: 3, render: $.fn.dataTable.render.moment('YYYY/MM/DD', 'DD-MM-YYYY') }
        ],     
        columns : [
                    {class : "text-center",
                     data: 'detalle_rut'},
                    {class : "text-center",
                     data: 'detalle_folio'},
                    {class : "text-center",
                     data: 'paciente'},
                    {class : "text-center",
                     data: 'ultima_atencion'},
                    {class : "text-center",
                     data: 'deuda'}
                  ],
        colReorder: true
      });

      var tableTratamiento = $('#tableTratamiento').DataTable({
        processing: true,
        pageLength: 10,
        searching   : false,
        language: { "url": '<?php echo asset('/plugins/datatables/latino.json'); ?>' },
        order: [ 0, "asc" ],
        colReorder: true,
        ajax: {
              url: "<?php echo e(url('tratamiento.getTabla')); ?>",
              type: "POST",
              data:{
                      rut_paciente        : rutT,
                      "_token"  : token,                     
                  },
          },
        columns: [
                  {class : "text-center",
                   data: 'folio'},
                  {class : "text-center",
                   data: 'nombre'},
                  {class : "text-center",
                   data: 'tipo'},
                  {class : "text-center",
                   data: 'rut'},
                  {class : "text-center",
                   data: 'paciente'},
                  {class : "text-center",
                   data: 'numero'},
                  <?php if(Auth::user()->perfil_id == 3): ?>
                    {class : "text-center",
                      data: 'valor'},
                    {class : "text-center",
                     data: 'deuda'},
                  <?php endif; ?>
                  {class : "text-center",
                   data: 'action', name: 'action', orderable: false, searchable: false}
              ]
        });

      $('#busqueda_button').click(function(e) {
        $('#div_tabla_busqueda').addClass('hidden');
      });

      $('#busquedar_ahora').click(function(e) {
        rutT    = $('#rutT').val();
        nfolioT = $('#nfolioT').val();
        tipo_tratamientoT = $('#tipo_tratamientoT').val();

        $('#div_tabla_busqueda').removeClass('hidden');


        $.ajax({
          url: "<?php echo e(url('tratamiento.getTabla')); ?>",
          type: "POST",
          data:{
                  rut_paciente        : rutT,
                  tipo                : tipo_tratamientoT,
                  home_secretaria     : true,
                  "_token"  : token,                     
              },
        })
        .done(function(data) {
          tableTratamiento.clear().draw();
          $.each(data.data, function(index, val) {
            $('#rutT').val(val.rut);
            $('#nombrePacienteT').val(val.paciente);
            $('#telefonoT').val(val.telefono);
            $('#nfolioT').val(val.folio);
            $('#nombreTratamientoT').val(val.nombre);
            $('#controlesT').val(val.numero);
            tableTratamiento.row.add( val ).draw().node();
          });
        })
        .fail(function(data) {
          console.log(data);
        });
        
      });
    });
  </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>