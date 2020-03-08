<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	if (!is_null(Auth::user())) {
		return Redirect::to('/home');
	}else{
		return Redirect::to('/login');
	}
});

Route::get('error_400', ['as' => 'error_400', 'uses' => 'HomeController@error400']);
Route::get('error_403', ['as' => 'error_403', 'uses' => 'HomeController@error403']);
Route::get('error_404', ['as' => 'error_404', 'uses' => 'HomeController@error404']);
Route::get('error_503', ['as' => 'error_503', 'uses' => 'HomeController@error503']);
Route::get('error_sql', ['as' => 'error_sql', 'uses' => 'HomeController@errorSql']);
Route::get('error', 	['as' => 'error', 'uses' => 'HomeController@errorGeneral']);

Route::get('/logout', function(){
	Auth::logout();
	Session::flush();
	return Redirect::to('/login');
});
//OK
Route::post('login.getRoles', 						'UserController@getRoles')->name('login.getRoles');
Route::post('login.saveRol', 						'UserController@saveRol')->name('login.saveRol');
Route::post('login.saveRolGoogle', 					'UserController@saveRolGoogle')->name('login.saveRolGoogle');

Route::resource('tratamiento', 						'TratamientoController');
Route::resource('observacion', 						'ObservacionController');

Route::post('sucursales.getTabla', 					'SucursalController@getTabla')->name('sucursales.getTabla');
Route::post('tratamiento.getTabla', 				'TratamientoController@getTabla')->name('tratamiento.getTabla');
Route::post('tratamiento.getTableAtenciones', 		'TratamientoController@getTableAtenciones')->name('tratamiento.getTableAtenciones');

Route::post('tratamiento.getPaciente', 				'TratamientoController@getPaciente')->name('tratamiento.getPaciente');
Route::post('atencion.getProfesionales', 			'AtencionController@getProfesionales')->name('atencion.getProfesionales');
Route::post('atencion.getDatosProfesional', 		'AtencionController@getDatosProfesional');
Route::post('reserva.getDatosFolio', 				'AtencionController@getDatosFolio');
Route::post('tratamiento.exportExcel', 				'TratamientoController@exportExcel')->name('tratamiento.exportExcel');
Route::post('tratamiento.exportAtencionesExcel',	'TratamientoController@exportAtencionesExcel')->name('tratamiento.exportAtencionesExcel');
Route::post('home.cargarTablePersonasAlDia', 		'HomeController@cargarTablePersonasAlDia')->name('home.cargarTablePersonasAlDia');
Route::post('home.cargarTablePersonasDeudas', 		'HomeController@cargarTablePersonasDeudas')->name('home.cargarTablePersonasDeudas');
Route::post('home.cargarTablePersonasAtrasado', 	'HomeController@cargarTablePersonasAtrasado')->name('home.cargarTablePersonasAtrasado');
//OK


Route::get('RegistrarAtencion/{folio?}', 			'AtencionController@registrarAtencion');
Route::get('RegistrarReserva/{folio?}', 			'AtencionController@registrarReserva');

Route::get('reserva', 								'AtencionController@indexReservas');
Route::get('reserva/{id}', 							'AtencionController@showReserva');
Route::get('activarReserva/{id}', 					'AtencionController@activarReserva');
Route::post('reserva.getTableReservas', 			'AtencionController@getTableReservas');
	Route::post('reservas.exportExcel',					'AtencionController@exportExcelReservas')->name('reservas.exportExcel');

Route::post('atencion.cargarAtencion', 				'AtencionController@cargarAtencion');
Route::post('atencion.guardarAtencion', 			'AtencionController@guardarAtencion')->name('atencion.guardarAtencion');

Route::resource('pacientes', 						'PacienteController', [
		'only' => ['create', 'store', 'show']
	]);

Route::resource('atencion', 						'AtencionController', [
		'only' => ['show']
	]);

Route::post('profesional.cargarProfesionales', 		'ProfesionalController@cargarProfesionales')->name('profesional.cargarProfesionales');
Route::post('usuario.cargarSecretarias', 			'UsuarioController@cargarSecretarias')->name('profesional.cargarSecretarias');

//A ESTAS RUTAS INGRESA SUPERADMINISTRADOR Y ADMINISTRADOR
Route::middleware('administracion', 'auth')->group( function () {
	Route::resource('usuarios', 						'UsuarioController');
	Route::resource('pacientes', 						'PacienteController', [
		'only' => ['index', 'edit', 'update']
	]);
	Route::resource('profesionales', 					'ProfesionalController');
	Route::resource('reportes', 						'ReportesController');
	Route::resource('atencion', 						'AtencionController', [
		'only' => ['index', 'create', 'store', 'edit', 'update']
	]);

	Route::get('HistorialAtencion', 					'AtencionController@historial');
	Route::get('HistorialAcciones', 					'HistorialAccionesController@index');

	Route::get('ReporteAtencionPeriodo', 				'ReportesController@ReporteAtencionPeriodo');
	Route::get('ReporteAtencionSucursal', 				'ReportesController@ReporteAtencionSucursal');
	Route::get('ReporteAtencionProfesional', 			'ReportesController@ReporteAtencionProfesional');
	Route::get('ReporteAtencionSecretaria', 			'ReportesController@ReporteAtencionSecretaria');
	Route::get('ReporteAtencionPaciente', 				'ReportesController@ReporteAtencionPaciente');
	Route::get('ReporteIngresoPeriodo',					'ReportesController@ReporteIngresoPeriodo');
	Route::get('ReporteIngresoSucursal',				'ReportesController@ReporteIngresoSucursal');
	Route::get('ReporteIngresoProfesional',				'ReportesController@ReporteIngresoProfesional');
	Route::get('ReporteIngresoSecretaria',				'ReportesController@ReporteIngresoSecretaria');
	Route::get('ReporteIngresoPaciente',				'ReportesController@ReporteIngresoPaciente');

	Route::post('reportes.getAtencionPeriodo', 			'ReportesController@getAtencionPeriodo')->name('reportes.getAtencionPeriodo');
	Route::post('reportes.getAtencionSucursal', 		'ReportesController@getAtencionSucursal')->name('reportes.getAtencionSucursal');
	Route::post('reportes.getAtencionProfesional', 		'ReportesController@getAtencionProfesional')->name('reportes.getAtencionProfesional');
	Route::post('reportes.getAtencionSecretaria', 		'ReportesController@getAtencionSecretaria')->name('reportes.getAtencionSecretaria');
	Route::post('reportes.getAtencionPaciente', 		'ReportesController@getAtencionPaciente')->name('reportes.getAtencionPaciente');
	Route::post('reportes.getIngresoPeriodo', 			'ReportesController@getIngresoPeriodo')->name('reportes.getIngresoPeriodo');
	Route::post('reportes.getIngresoSucursal', 			'ReportesController@getIngresoSucursal')->name('reportes.getIngresoSucursal');
	Route::post('reportes.getIngresoProfesional', 		'ReportesController@getIngresoProfesional')->name('reportes.getIngresoProfesional');
	Route::post('reportes.getIngresoSecretaria', 		'ReportesController@getIngresoSecretaria')->name('reportes.getIngresoSecretaria');
	Route::post('reportes.getIngresoPaciente', 			'ReportesController@getIngresoPaciente')->name('reportes.getIngresoPaciente');

	Route::post('reportes.ExcelAtencionPeriodo', 		'ReportesController@ExcelAtencionPeriodo')->name('reportes.ExcelAtencionPeriodo');
	Route::post('reportes.ExcelAtencionSucursal', 		'ReportesController@ExcelAtencionSucursal')->name('reportes.ExcelAtencionSucursal');
	Route::post('reportes.ExcelAtencionProfesional', 	'ReportesController@ExcelAtencionProfesional')->name('reportes.ExcelAtencionProfesional');
	Route::post('reportes.ExcelIngresoPeriodo', 		'ReportesController@ExcelIngresoPeriodo')->name('reportes.ExcelIngresoPeriodo');
	Route::post('reportes.ExcelIngresoSucursal', 		'ReportesController@ExcelIngresoSucursal')->name('reportes.ExcelIngresoSucursal');
	Route::post('reportes.ExcelIngresoProfesional', 	'ReportesController@ExcelIngresoProfesional')->name('reportes.ExcelIngresoProfesional');

	Route::post('home.changePassword', 					'UsuarioController@changePassword')->name('usuarios.changePassword');
	Route::post('home.getTabla', 						'SucursalController@getTabla')->name('sucursales.getTabla');
	Route::post('usuarios.getTabla', 					'UsuarioController@getTabla')->name('usuarios.getTabla');
	Route::post('usuarios.changePassword', 				'UsuarioController@changePassword')->name('usuarios.changePassword');
	Route::post('pacientes.getTabla', 					'PacienteController@getTabla')->name('pacientes.getTabla');
	Route::post('pacientes.getTableAtencion', 			'PacienteController@getTableAtencion')->name('pacientes.getTableAtencion');
	Route::post('profesionales.getTabla', 				'ProfesionalController@getTabla')->name('profesionales.getTabla');
	Route::post('atencion.getTablaHistorial', 			'AtencionController@getTablaHistorial')->name('atencion.getTablaHistorial');
	Route::post('profesionales.getTableAtencion', 		'ProfesionalController@getTableAtencion')->name('profesionales.getTableAtencion');

	//Eliminar desde la grilla
	Route::get('usuarios/destroy/{rut}', 				'UsuarioController@destroy');
	Route::get('pacientes/destroy/{rut}', 				'PacienteController@destroy');
	Route::get('profesionales/destroy/{rut}', 			'ProfesionalController@destroy');
	Route::get('tratamiento/destroy/{folio}', 			'TratamientoController@destroy');
	Route::get('atencion/destroy/{id}', 				'AtencionController@destroy');

	//Activar desde la grilla
	Route::get('usuarios/activate/{rut}', 				'UsuarioController@activate');
	Route::get('pacientes/activate/{rut}', 				'PacienteController@activate');
	Route::get('profesionales/activate/{rut}', 			'ProfesionalController@activate');

	//Obtener selects
	Route::post('sucursal.cargarSucursales', 			'SucursalController@cargarSucursales')->name('sucursal.cargarSucursales');

	//Excel
	Route::post('usuarios.exportExcel', 				'UsuarioController@exportExcel')->name('usuarios.exportExcel');
	Route::post('pacientes.exportExcel', 				'PacienteController@exportExcel')->name('pacientes.exportExcel');
	Route::post('pacientes.exportExcelAtenciones',		'PacienteController@exportExcelAtenciones')->name('pacientes.exportExcelAtenciones');
	Route::post('profesionales.exportExcel',			'ProfesionalController@exportExcel')->name('profesionales.exportExcel');
	Route::post('profesionales.exportExcelAtenciones',	'ProfesionalController@exportExcelAtenciones')->name('profesionales.exportExcelAtenciones');
	Route::post('exportExcelHistorial', 				'AtencionController@exportExcelHistorial')->name('exportExcelHistorial');

});

//A ESTAS RUTAS INGRESA SECRETARIA Y ASISTENTE
Route::middleware('atencion', 'auth')->group( function () {
	Route::get('atencion/observacion/{id}', 			'AtencionController@observacion');
});

//A ESTAS RUTAS INGRESAN TODOS
Route::middleware('todos', 'auth')->group( function () {

});

//A ESTAS RUTAS INGRESA SUPERADMINISTRADOR
Route::middleware('superadmin', 'auth')->group( function () {

});

//A ESTAS RUTAS INGRESA ADMINISTRADOR
Route::middleware('admin', 'auth')->group( function () {

});
//A ESTAS RUTAS INGRESA SECRETARIA
Route::middleware('secretaria', 'auth')->group( function () {

});
//A ESTAS RUTAS INGRESA ASISTENTE
Route::middleware('asistente', 'auth')->group( function () {

});

Route::get('login/google', 							'Auth\LoginController@redirectToProvider')->name('login/google');;
Route::get('login/google/callback', 				'Auth\LoginController@handleProviderCallback');
