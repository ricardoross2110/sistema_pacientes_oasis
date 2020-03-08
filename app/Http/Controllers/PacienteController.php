<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\DB;
use Malahierba\ChileRut\ChileRut;
use Maatwebsite\Excel\Facades\Excel;

use App\LogAccion;
use Auth;

use App\Paciente;
use App\Sucursal;
use App\Usuario;
use App\Tratamiento;
use App\TipoTratamiento;
use App\Atencion;
use helpers;
use DateTime;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #Se obtienen las sucursales para poder seleccionarlas
        $sucursales             = Sucursal::select('id', 'nombre')->pluck('nombre', 'id');

        return view('pacientes.index')
                                ->with('sucursales', $sucursales);
    }


    public function getTabla(Request $request)
    {
        $rut                = $request->input('rutB');
        $apellido_paterno   = utf8_decode($request->input('apellido_paternoB'));
        $telefonoB          = $request->input('telefonoB');
        $direccionB         = utf8_decode($request->input('direccionB'));
        $estadoB            = $request->input('estadoB');
        #Se extraen datos de paciente que coincidan con los datos ingresados por el usuario
        $pacientes          = Paciente::select('rut', 'dv', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As nombre_paciente"), 'telefono', 'estado');

        if(!is_null($rut)){
            $pacientes = $pacientes->where('rut','=',$rut);
        }

        if (!is_null($apellido_paterno)) {
            $pacientes  = $pacientes->whereRaw('LOWER(pacientes.apellido_paterno) LIKE ? ','%'.utf8_encode((strtolower($apellido_paterno))).'%');
        }

        if (!is_null($telefonoB)) {
            $pacientes  = $pacientes->whereRaw('LOWER(pacientes.telefono) LIKE ? ','%'.(strtolower($telefonoB)).'%');
        }

        if (!is_null($direccionB)) {
            $pacientes  = $pacientes->whereRaw('LOWER(pacientes.direccion) LIKE ? ','%'.utf8_encode((strtolower($direccionB))).'%');
        }

        if(!is_null($estadoB) && $estadoB <> "all"){
            $pacientes = $pacientes->where('pacientes.estado','=', $estadoB);
        }
        #Se ordena por RUT de forma ascendente
        $pacientes      = $pacientes->orderBy('rut', 'asc')
                                    ->get();

        foreach ($pacientes as $paciente){
            $paciente->estado = ($paciente->estado == 1) ? 'Activo' : 'Inactivo' ;
        }
        #Se genera tabla con los pacientes encontrados
        return Datatables::of($pacientes)
            ->addColumn('detalle_rut', function ($pacientes){                
                            return '<a href="'.url('/pacientes/').'/'.$pacientes->rut.'" title=Detalle>'.$pacientes->rut.'</a>';
            })
            ->addColumn('action', function ($pacientes) {
                if ($pacientes->estado == 'Activo') {
                    return '<a class="iconos" href="'.url('/pacientes/').'/'.$pacientes->rut.'/edit" title="Editar" >
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                        <a class="iconos" href="#" data-toggle="modal" data-target="#modal-eliminar_'.$pacientes->rut.'" title="Eliminar" >
                            <span class="fa fa-trash-o" aria-hidden="true"></span>
                        </a>
                        <div class="modal fade" id="modal-eliminar_'.$pacientes->rut.'" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-red">
                                        <h4 class="modal-title">Confirmar eliminación</h4>
                                    </div>

                                    <div class="modal-body">
                                        <h3>¿Está seguro de eliminar a este paciente?</h3>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                        <a href="'.url('/pacientes/destroy').'/'.$pacientes->rut.'" type="submit" class="btn btn-danger" role="button">Aceptar</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }else{
                    return '<a class="iconos" href="#" data-toggle="modal" data-target="#modal-activar_'.$pacientes->rut.'" title="Activar" >
                                <span class="fa fa-check-circle" aria-hidden="true"></span>
                            </a>
                        <div class="modal fade" id="modal-activar_'.$pacientes->rut.'" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-green">
                                        <h4 class="modal-title">Confirmar activación</h4>
                                    </div>

                                    <div class="modal-body">
                                        <h3>¿Está seguro de activar este paciente?</h3>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                        <a href="'.url('/pacientes/activate').'/'.$pacientes->rut.'" type="submit" class="btn btn-success" role="button">Aceptar</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
            })->rawColumns(['detalle_rut','action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pacientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #Validar si el RUT es válido o no
        $rut_validar = $request->input('rutN').'-'.$request->input('dvN');
        if (!valida_rut($rut_validar)) {
            return redirect()->back()->withInput()->with('error','RUT ingresado no es válido');
        }
        #Consultar si se ingresó un RUT, si se ingresó se consulta si ya está registrado o no
        if(empty($request->input('rutN'))){
            return redirect()->back()->withInput()->with('error','Debe ingresar un rut válido');
        }else{
            $paciente = Paciente::where('rut', '=', $request->input('rutN'))->get();
            if (count($paciente) > 0) {
                return redirect()->back()->withInput()->with('error','El RUT ingresado ya está asociado a un paciente');
            }
        }

        if(is_null($request->input('dvN'))){
            return redirect()->back()->withInput()->with('error','Debe ingresar el dígito verificador');
        }elseif(empty($request->input('nombreN'))){
            return redirect()->back()->withInput()->with('error','Debe ingresar los nombres');
        }elseif(empty($request->input('apellido_paternoN'))){
            return redirect()->back()->withInput()->with('error','Debe ingresar un apellido paterno');
        }elseif(empty($request->input('apellido_maternoN'))){
            return redirect()->back()->withInput()->with('error','Debe ingresar un apellido materno');
        }elseif(empty($request->input('telefonoN'))){
            return redirect()->back()->withInput()->with('error','Debe ingresar un teléfono');
        }elseif(empty($request->input('fecha_nacimientoN'))){
            return redirect()->back()->withInput()->with('error','Debe ingresar una fecha de nacimiento');
        }

        #Validación del correo
        if (!is_null($request->input('correoN'))) {
            $correo = $request->input('correoN');
            $resp   = false;
            
            if (filter_var($correo, FILTER_VALIDATE_EMAIL))
            {
                $resp = true;
            }
            if($resp == false){
                return redirect()->back()->withInput()->with('error','El correo ingresado es incorrecto, por favor intente nuevamente');
            }
        }

        $paciente                       = new Paciente();
        $paciente->rut                  = $request->input('rutN');
        $paciente->dv                   = $request->input('dvN');

        $count = mb_strlen($request->input('nombreN'), 'UTF-8');
        if($count > 25){
            return redirect()->back()->withInput()->with('error', 'Los nombres son demasiado largos, el máximo permitido es 25 caracteres');
        }else{
            $paciente->nombres = $request->input('nombreN');
        }

        $count = mb_strlen($request->input('apellido_paternoN'), 'UTF-8');
        if($count > 25){
            return redirect()->back()->withInput()->with('error', 'El apellido paterno demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $paciente->apellido_paterno = $request->input('apellido_paternoN');
        }

        $count = mb_strlen($request->input('apellido_maternoN'), 'UTF-8');
        if($count > 25){
            return redirect()->back()->withInput()->with('error', 'El apellido materno demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $paciente->apellido_materno = $request->input('apellido_maternoN');
        }

        $count = mb_strlen($request->input('correoN'), 'UTF-8');
        if($count > 100){
            return redirect()->back()->withInput()->with('error', 'El correo electrónico es demasiado largo, el máximo permitido es 100 caracteres');
        }else{
            $paciente->email = $request->input('correoN');
        }
        if (!is_null($request->input('direccionN'))) {
            $paciente->direccion            = $request->input('direccionN');
        }else{
            $paciente->direccion            = '';
        }
        
        $paciente->telefono             = $request->input('telefonoN');
        if (!is_null($request->input('facebookN'))) {
            $paciente->facebook             = $request->input('facebookN');
        }

        if (!is_null($request->input('instagramN'))) {
            $paciente->instagram            = $request->input('instagramN');
        }

        if (!is_null($request->input('observacionN'))) {
            $paciente->observacion            = $request->input('observacionN');
        }
        
        $fecha_nacimiento               = str_replace('/', '-', $request->input('fecha_nacimientoN'));
        $paciente->fecha_nacimiento     = date('Y-m-d', strtotime($fecha_nacimiento));
        $paciente->estado               = true;
        $paciente->fecha_registro       = date_format(date_create('America/Santiago'), 'Y-m-d H:i:m');
        #Se guarda paciente
        $paciente->save();


        #Guarda log al crear paciente
        LogAccion::create([
            'accion' => "Agregar Paciente",
            'detalle' => "Se crea Paciente: " .$request->input('nombreN').' '.$request->input('apellido_paternoN').' '.$request->input('apellido_maternoN'),
            'usuario_rut' => Auth::user()->rut,
        ]);
        
        if(Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 4){
            $numero_folio  = Tratamiento::select('folio')->orderBy('folio', 'desc')->first();
            #Si no hay números de folio registrados, comenzamos en 1
            if (empty($numero_folio)) {
                $numero_folio   = 1;
            }else{
                $numero_folio   = ($numero_folio->folio) + 1;
            }

            $rut                = $request->input('rutN');
            $nombre             = $request->input('nombreN').' '.$request->input('apellido_paternoN').' '.$request->input('apellido_maternoN');
            $correo             = $request->input('correoN');
            $telefono           = $request->input('telefonoN');

            #Se obtienen todos los tipos de tratamiento menos el genérico
            $tipoTratamiento = TipoTratamiento::select('id', 'nombre')->where('id', '<>', 3)->pluck('nombre', 'id');

            return view('tratamiento.create')
                ->with('rut', $rut)
                ->with('nombre', $nombre)
                ->with('correo', $correo)
                ->with('telefono', $telefono)
                ->with('num_folio', $numero_folio)
                ->with('tipoTratamiento',$tipoTratamiento);
        }

        return redirect()->back()->with('success','Paciente creado correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($rut)
    {

        $pacientes          = Paciente::select('pacientes.*')->where('rut','=',$rut)->get();
        #Si el estado es 1 se deja como Activo, si no es Inactivo
        foreach ($pacientes as $paciente){
            $paciente->estado = ($paciente->estado == 1) ? 'Activo' : 'Inactivo' ;
        }
        #Por cada paciente se calcula la edad
        foreach ($pacientes as $paciente) {
            $fecha_nacimiento   = new DateTime($paciente->fecha_nacimiento);
            $ahora              = new DateTime();

            $edad = $ahora->diff($fecha_nacimiento);

            $paciente->edad = $edad->y;
        }

        return view('pacientes.show')->with('pacientes', $pacientes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($rut)
    {
        #Se obtienen los datos del paciente
        $paciente = Paciente::where('rut', '=', $rut)
                ->first();
        $fecha_nacimiento = date_format(date_create($paciente->fecha_nacimiento), 'd/m/Y');

        return view('pacientes.edit', compact('paciente'))
                ->with('fecha_nacimiento', $fecha_nacimiento);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rut)
    {

        if(empty($request->input('nombres'))){
            return redirect()->route('pacientes.index')->withInput()->with('error','Debe ingresar un nombre');
        }elseif(empty($request->input('apellido_paterno'))){
            return redirect()->route('pacientes.index')->withInput()->with('error','Debe ingresar un apellido paterno');
        }elseif(empty($request->input('apellido_materno'))){
            return redirect()->route('pacientes.index')->withInput()->with('error','Debe ingresar un apellido materno');
        }elseif(empty($request->input('telefono'))){
            return redirect()->route('pacientes.index')->withInput()->with('error','Debe ingresar un teléfono');
        }
        #Se valida el correo electrónico
        if (!is_null($request->input('email'))) {
            $correo = $request->input('email');
            $resp   = false;
            if (filter_var($correo, FILTER_VALIDATE_EMAIL))
            {
                $resp = true;
            }
            if($resp == false){
                return redirect()->route('pacientes.index')->withInput()->with('error','Correo electrónico ingresado es incorrecto');
            }
        }

        $paciente                       = Paciente::find($rut);

        $count = mb_strlen($request->input('nombres'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'Los nombres son demasiado largos, el máximo permitido es 25 caracteres');
        }else{
            $paciente->nombres = $request->input('nombres');
        }

        $count = mb_strlen($request->input('apellido_paterno'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'El apellido paterno demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $paciente->apellido_paterno = $request->input('apellido_paterno');
        }

        $count = mb_strlen($request->input('apellido_materno'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'El apellido materno demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $paciente->apellido_materno = $request->input('apellido_materno');
        }

        $paciente->email = $request->input('email');


        $fecha_nacimiento               = str_replace('/', '-', $request->input('fecha_nacimiento'));
        $fecha_nacimiento              = date('Y-m-d', strtotime($fecha_nacimiento));

        $paciente->fecha_nacimiento     = $fecha_nacimiento;

        
        $paciente->telefono             = $request->input('telefono');
        if (!is_null($request->input('direccion'))) {
            $paciente->direccion            = $request->input('direccion');
        }
        if (!is_null($request->input('facebook'))) {
            $paciente->facebook             = $request->input('facebook');
        }

        if (!is_null($request->input('instagram'))) {
            $paciente->instagram            = $request->input('instagram');
        }

        if (!is_null($request->input('observacion'))) {
            $paciente->observacion            = $request->input('observacion');
        }
        #Se guarda las modificaciones del paciente
        $paciente->save();

        #Guarda log al editar paciente
        LogAccion::create([
            'accion' => "Editar Paciente",
            'detalle' => "Se edita Paciente: " .$request->input('nombres').' '.$request->input('apellido_paterno').' '.$request->input('apellido_materno'),
            'usuario_rut' => Auth::user()->rut,
        ]);

        //return redirect()->route('usuarios.index');
        return redirect()->route('pacientes.index')->with('success','Paciente modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rut)
    {
        $paciente           =   Paciente::find($rut);
        #Estado pasa a ser inactivo, o sea 0
        $paciente->estado   =   0;
        $paciente->save();

        #Guarda log al cambiar estado
        LogAccion::create([
            'accion' => "Cambiar estado Paciente",
            'detalle' => "Se desactivó el Paciente: " .$rut,
            'usuario_rut' => Auth::user()->rut,
        ]);

        return redirect()->route('pacientes.index')->with('success','Paciente desactivado correctamente');
    }

    public function activate($rut)
    {
        $paciente           =   Paciente::find($rut);
        #Estado pasa a ser Activo, o sea 1
        $paciente->estado   =   1;
        $paciente->save();

        #Guarda log al cambiar estado
        LogAccion::create([
            'accion' => "Cambiar estado Paciente",
            'detalle' => "Se activó el Paciente: " .$rut,
            'usuario_rut' => Auth::user()->rut,
        ]);

        return redirect()->route('pacientes.index')->with('success','Paciente activado correctamente');
    }

    public function cargarSucursal(Request $request)
    {

        if ($request->ajax()) {
            $sucursales   = Sucursal::select('id', 'nombre')->get();

            $sucursales   = $sucursales->pluck('id', 'nombre');

            return response()->json([
                "sucursales"    => $sucursales
            ]);
        }
    }

    public function exportExcel(Request $request)
    {
        $rut                = $request->input('rutExcel');
        $apellido_paterno   = utf8_decode($request->input('apellido_paternoExcel'));
        $telefonoB          = $request->input('telefonoExcel');
        $direccionB         = utf8_decode($request->input('direcionExcel'));
        $estadoB            = $request->input('estadoExcel');
        #Obtiene datos de paciente qeu coincidan con los filtros de búsqueda
        $pacientes          = Paciente::select('rut', 'dv', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As nombre_paciente"), 'telefono',  'estado');

        if(!is_null($rut)){
            $pacientes = $pacientes->where('rut','=',$rut);
        }

        if (!is_null($apellido_paterno)) {
            $pacientes  = $pacientes->whereRaw('LOWER(pacientes.apellido_paterno) LIKE ? ','%'.utf8_encode((strtolower($apellido_paterno))).'%');
        }

        if (!is_null($telefonoB)) {
            $pacientes  = $pacientes->whereRaw('LOWER(pacientes.telefono) LIKE ? ','%'.(strtolower($telefonoB)).'%');
        }

        if (!is_null($direccionB)) {
            $pacientes  = $pacientes->whereRaw('LOWER(pacientes.direccion) LIKE ? ','%'.utf8_encode((strtolower($direccionB))).'%');
        }

        if(!is_null($estadoB) && $estadoB <> "all"){
            $pacientes = $pacientes->where('pacientes.estado','=', $estadoB);
        }

        $pacientes      = $pacientes->orderBy('rut', 'asc')
                                    ->get();

        foreach ($pacientes as $paciente){
            $paciente->estado = ($paciente->estado == 1) ? 'Activo' : 'Inactivo' ;
        }

        return Excel::create('ListadoPacientes', function($excel) use ($pacientes) {
            $excel->sheet('Pacientes', function($sheet) use ($pacientes)
            {
                $count = 2;
                #Títulos de los encabezados
                $sheet->row(1, ['RUT', 'DV', 'Nombre', 'Teléfono', 'Estado']);
                #Contenido de la tabla
                foreach ($pacientes as $key => $value) {
                    $sheet->row($count, [$value->rut, $value->dv, $value->nombre_paciente, $value->telefono,  $value->estado]);
                    $count = $count +1;
                }
                #Se aplica un estilo para las celdas del encabezado
                $sheet->cells('A1:E1', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
            });
        })->download('xlsx');
    }

    public function getTableAtencion(Request $request)
    {
        if ($request->ajax()) {
            #Se obtiene los datos de Tratamientos
            $tratamientos = Tratamiento::select('folio','tratamientos.nombre As nombre', 'num_control', 'tratamientos.valor As total')
                                ->join('pacientes', 'paciente_rut','=', 'pacientes.rut')
                                ->where('paciente_rut', '=', $request->input('rut'))
                                ->get();

            foreach ($tratamientos as $tratamiento) {
                #Se obtiene el valor total del abono del tratamiento específico
                $abono              =   Atencion::select(DB::raw('SUM(abono) As abono_total'))->where('tratamiento_folio', '=', $tratamiento->folio)->first();

                if (is_null($abono->abono_total)) {
                    $abono->abono_total    =   "0";
                }

                $deuda              =   $tratamiento->total - $abono->abono_total;
                #Se da formato a la deuda y total
                $tratamiento->deuda    = '$ '.number_format($deuda, 0 , '', '.');
                $tratamiento->total    = '$ '.number_format($tratamiento->total, 0, '', '.');
            }
            #Se genera tabla de tratamientos
            return Datatables::of($tratamientos)->make(true);
        }
    }

    public function exportExcelAtenciones(Request $request)
    {
        #Se obtienen datos de tratamiento
        $tratamientos = Tratamiento::select('folio','tratamientos.nombre As nombre', 'num_control', 'tratamientos.valor As total')
                                        ->join('pacientes', 'paciente_rut','=', 'pacientes.rut')
                                        ->where('paciente_rut', '=', $request->input('rutExcel'))
                                        ->get();

        foreach ($tratamientos as $tratamiento) {
            #Total del abono
            $abono              =   Atencion::select(DB::raw('SUM(abono) As abono_total'))->where('tratamiento_folio', '=', $tratamiento->folio)->first();

            if (is_null($abono->abono_total)) {
                $abono->abono_total    =   "0";
            }

            $deuda              =   $tratamiento->total - $abono->abono_total;
            $tratamiento->deuda    = $deuda;
            $tratamiento->total    = $tratamiento->total;
        }

        return Excel::create('ListadoAtenciones', function($excel) use ($tratamientos) {
            $excel->sheet('Atenciones', function($sheet) use ($tratamientos)
            {
                $count = 1;
                #Se da un formato a una celda en específico
                $sheet->setColumnFormat(array(
                    'B' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY,
                    'C' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4,
                    'D' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD,
                    'E' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                ));

                foreach ($tratamientos as $key => $value) {
                    #Títulos de encabezado
                    $sheet->row($count, ['Folio', 'Tratamiento', 'Controles', 'Precio total', 'Deuda']);
                    $count = $count +1;
                    #Contenido de la tabla
                    $sheet->row($count, [$value->folio, $value->nombre, $value->num_control, $value->total, $value->deuda]);
                    $count = $count +1;
                    #Títulos de encabezado
                    $sheet->row($count, ['Número control', 'Fecha', 'Hora', 'Profesional', 'Sucursal', 'Abono']);
                    $atenciones         = Atencion::select('num_atencion', 'fecha', DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As profesional"), 'abono', 'sucursales.nombre As sucursal')
                                ->join('profesionales', 'profesional_rut','=', 'rut')
                                ->join('sucursales', 'sucursal_id','=', 'sucursales.id')
                                ->where('tratamiento_folio', '=', $value->folio)
                                ->get();

                    $count = $count +1;

                    foreach ($atenciones as $atencion) {
                        $atencion->hora     = date_format(date_create($atencion->fecha), 'H:i:s');
                        $atencion->hora     = strtotime($atencion->hora);
                        $atencion->hora     = \PHPExcel_Shared_Date::PHPToExcel($atencion->hora);
                        $atencion->fecha    = date_format(date_create($atencion->fecha), 'Y-m-d');
                        $atencion->fecha    = strtotime($atencion->fecha);
                        $atencion->fecha    = \PHPExcel_Shared_Date::PHPToExcel($atencion->fecha);
                        #Contenido de la tabla
                        $sheet->row($count, [$atencion->num_atencion, $atencion->fecha, $atencion->hora, $atencion->profesional, $atencion->sucursal, $atencion->abono, $atencion->deuda]);
                        $count = $count +1;
                    }
                    $count = $count +1;
                }
            });
        })->download('xlsx');

    }

}
