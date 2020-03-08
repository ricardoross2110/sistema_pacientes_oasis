<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\LogAccion;
use Auth;

use Calendar;

use App\Atencion;
use App\Observacion;
use App\Pago;
use App\Paciente;
use App\Profesional;
use App\Profesion;
use App\TipoTratamiento;
use App\TipoContrato;
use App\TipoPago;
use App\Tratamiento;
use App\Sucursal;
use Carbon\Carbon;

class AtencionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        return view ("atencion.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view ("atencion.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    public function show($id)
    {
        #Se extraen datos de Atención
        $atenciones = Atencion::select('tratamiento_folio', 'tratamientos.nombre As nombre', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), 'tratamientos.num_control As control', 'num_atencion', 'fecha', 'sucursales.nombre As sucursal', 'atenciones.id As atenciones_id',DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As profesional"), 'profesiones.nombre As profesion', 'tipo_contrato.nombre As tipo', 'atenciones.observacion', 'abono')
                            ->join('tratamientos', 'tratamientos.folio', '=', 'atenciones.tratamiento_folio')
                            ->join('pacientes', 'tratamientos.paciente_rut','=', 'pacientes.rut')
                            ->join('profesionales', 'profesional_rut','=', 'profesionales.rut')
                            ->join('sucursales', 'sucursales.id','=', 'sucursal_id')
                            ->join('profesiones', 'profesiones.id', '=', 'profesionales.profesion_id')
                            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'profesionales.tipo_contrato_id')
                            ->where('atenciones.id', '=', $id)
                            ->first();

        #Se extraen datos de Pago
        $pagos = Pago::select('tipo_pago.nombre As nombre', 'monto')
                        ->join('tipo_pago', 'tipo_pago.id', '=', 'pagos.tipo_pago_id')
                        ->where('pagos.atenciones_id', '=', $id)
                        ->get();

        #Se obtienen una lista de observaciones del sistema
        $observaciones = Observacion::where('atencion_id', '=', $atenciones->atenciones_id)->get();
        foreach ($observaciones as $observacion) {
            $observacion->hora  = date_format(date_create($observacion->fecha), 'H:i:s');
            $observacion->fecha = date_format(date_create($observacion->fecha), 'd/m/Y');
        }

        #Se recorren todos los pagos para aplicar formato
        foreach ($pagos as $pago) {
            $pago->monto    = '$ '.number_format($pago->monto, 0 , '', '.');
        }

        $atenciones->hora     = date_format(date_create($atenciones->fecha), 'H:i:s');
        $atenciones->fecha    = date_format(date_create($atenciones->fecha), 'd/m/Y');
        $atenciones->abono    = '$ '.number_format($atenciones->abono, 0, '', '.');

        return view("atencion.show")
                                ->with('atenciones', $atenciones)
                                ->with('observaciones', $observaciones)
                                ->with('pagos',$pagos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pagos              = Pago::where('atenciones_id', '=', $id)->delete();
        LogAccion::create([
            'accion' => "Se eliminó pagos de atención ",
            'detalle' => "Se eliminó los pagos de la atención ".$id,
            'usuario_rut' => Auth::user()->rut,
        ]);

        $observacion        = Observacion::where('atencion_id', '=', $id)->delete();
        LogAccion::create([
            'accion' => "Se eliminó observaciones de atención ",
            'detalle' => "Se eliminó los observaciones de la atención ".$id,
            'usuario_rut' => Auth::user()->rut,
        ]);

        $atencion           =   Atencion::where('id', '=', $id)->delete();

        return back()->with('success','Atención eliminado correctamente');
    }
    #Folio puede o no ser nulo, debido a que se puede llegar a este de dos formas
    public function registrarAtencion($folio = null)
    {

        $fecha              = date_format(date_create('America/Santiago'), 'd/m/Y');
        $hora               = date_format(date_create('America/Santiago'), 'H:i');
        $sucursales         = Sucursal::orderBy('nombre','asc')->pluck('nombre', 'id');
        $tipo_pago          = TipoPago::get();
        $tipo_pagoSelect    = TipoPago::pluck('nombre', 'id');

        if (!is_null($folio)) {
            $tratamiento    =   Tratamiento::find($folio);
            $paciente       =   Paciente::find($tratamiento->paciente_rut);
            $atencion       =   Atencion::where('tratamiento_folio', '=', $tratamiento->folio)->orderBy('num_atencion', 'desc')->get();
            if ($atencion->isEmpty()) {
                $n_atencion = 1;
            }else{
                $atencion   =   $atencion->first();
                $n_atencion =   ($atencion->num_atencion) + 1;
            }

            return view ("atencion.create", compact('tratamiento'), compact('paciente'))->with('folio', $folio)->with('n_atencion', $n_atencion)->with('fecha', $fecha)->with('hora', $hora)->with('sucursales', $sucursales)->with('tipo_pago', $tipo_pago)->with('tipo_pagoSelect', $tipo_pagoSelect);
        }else{
             return view ("atencion.create")->with('fecha', $fecha)->with('hora', $hora)->with('sucursales', $sucursales)->with('tipo_pago', $tipo_pago)->with('tipo_pagoSelect', $tipo_pagoSelect);
        }
    }

    #Folio puede o no ser nulo, debido a que se puede llegar a este de dos formas
    public function registrarReserva($folio = null)
    {
        
        $fecha              = date_format(date_create('America/Santiago'), 'd/m/Y');
        $hora               = date_format(date_create('America/Santiago'), 'H:i');

        if (Auth::user()->perfil_id >= 3) {
            $sucursales         = Sucursal::orderBy('nombre','asc')->where('id', Session()->get('sucursal_id'))->first();
        }else{
            $sucursales         = Sucursal::orderBy('nombre','asc')->pluck('nombre', 'id');
        }

        if (!is_null($folio)) {
            $tratamiento    =   Tratamiento::find($folio);
            $paciente       =   Paciente::find($tratamiento->paciente_rut);
            $atencion       =   Atencion::where('tratamiento_folio', '=', $tratamiento->folio)->orderBy('num_atencion', 'desc')->get();
            if ($atencion->isEmpty()) {
                $n_atencion = 1;
            }else{
                $atencion   =   $atencion->first();
                $n_atencion =   ($atencion->num_atencion) + 1;
            }

            return view ("atencion.reserva", compact('tratamiento'), compact('paciente'))->with('folio', $folio)->with('n_atencion', $n_atencion)->with('fecha', $fecha)->with('hora', $hora)->with('sucursales', $sucursales);
        }else{
             return view ("atencion.reserva")->with('fecha', $fecha)->with('hora', $hora)->with('sucursales', $sucursales);
        }
    }

    public function cargarAtencion(Request $request)
    {
        $folio          =   $request->input('n_folio');
        $tratamiento    =   Tratamiento::where('folio', '=', $folio)->get();
        #Evalúa si el número de folio ingresado está asociado a un tratamiento o no
        if ($tratamiento->isEmpty()) {
            return response()->json([
                "reponse"    => 'no_existe',
            ]);
        }else{
            $tratamiento    =   $tratamiento->first();
            #Evalúa si el tipo de tratamiento es genérico o no
            if ($tratamiento->tipo_tratamiento_id == 3) {
                return response()->json([
                    "reponse"    => 'folio_invalido',
                ]);
            }
            
            $paciente       =   Paciente::find($tratamiento->paciente_rut);
            $atencion       =   Atencion::where('tratamiento_folio', '=', $tratamiento->folio)->orderBy('num_atencion', 'desc')->get();
            #Calcula el número de la atención, evalúa si es la primera vez que se atiende el paciente en el respectivo tratamiento o no
            if ($atencion->isEmpty()) {
                $n_atencion = 1;
            }else{
                $atencion   =   $atencion->first();
                $n_atencion =   ($atencion->num_atencion) + 1;
            }
            
            return response()->json([
                "reponse"       => 'ok',
                'tratamiento'   => $tratamiento->nombre,
                'paciente'      => $paciente->nombres.' '.$paciente->apellido_paterno.' '.$paciente->apellido_materno,
                'num_controles' => $tratamiento->num_control,
                'n_atencion'    => $n_atencion
            ]);
        }


    }

    public function getProfesionales(Request $request)
    {
        $sucursal_id = $request->input('sucursal_id');
        #Extrae datos de Profesional
        $profesionales = Profesional::select('profesionales.rut',  DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As nombre_profesional"))->join('sucursal_profesional', 'profesionales.rut', '=','sucursal_profesional.profesional_rut')->where('profesionales.estado', '=', '1')->where('sucursal_profesional.sucursal_id', '=', $sucursal_id)->get();

        $profesionales = $profesionales->pluck('nombre_profesional', 'rut');

        return response()->json([
            "profesionales"    => $profesionales
        ]);
    }

    public function getDatosProfesional(Request $request)
    {
        $profesional_rut    =   $request->input('rut_profesional');
        #Busca un profesional por RUT
        $profesional        =   Profesional::find($profesional_rut);
        #Encuentra el tipo de contrato y profesión del Profesional recién buscado
        $tipo_contrato      =   TipoContrato::find($profesional->tipo_contrato_id);
        $profesion          =   Profesion::find($profesional->profesion_id);

        return response()->json([
            "tipo_contrato"     => $tipo_contrato->nombre,
            "profesion"         => $profesion->nombre
        ]);
    }


    public function historial(){
        #Obtiene todos los tipo de tratamientos distintos al genérico
        $tipo_tratamientos = TipoTratamiento::where('id', '<>', '3')->get();
        #Recorre los tipo de tratamientos y reemplaza General Ortodoncia por Ortodoncia
        foreach ($tipo_tratamientos as $tipo_tratamiento) {
            $tipo_tratamiento->nombre = ($tipo_tratamiento->nombre == 'General Ortodoncia') ? 'Ortodoncia' : $tipo_tratamiento->nombre;
        }

        $tipo_tratamientos = $tipo_tratamientos->pluck('nombre', 'id');

        return view("atencion.historial")->with('tipo_tratamientos', $tipo_tratamientos);
    }
    
    public function guardarAtencion(Request $request)
    {
        #Por cada entrada que esté vacía se mostrará mensaje
        if ($request->ajax()) {
            if (is_null($request->input('tipo'))) {
                if (empty($request->input('tratamiento_folio'))) {
                    return response()->json([ "tipo_mensaje" => "error", "mensaje" => 'Ingrese número de folio.' ]);
                }

                if (empty($request->input('num_atencion'))) {
                    return response()->json([ "tipo_mensaje" => "error", "mensaje" => 'Ingrese número de atención.' ]);
                }

                if (is_null($request->input('abono'))) {
                    return response()->json([ "tipo_mensaje" => "error", "mensaje" => 'Ingrese un precio en el abono.' ]);
                }
            }else{
                if (empty($request->input('paciente_rut'))) {
                    return response()->json([ "tipo_mensaje" => "error", "mensaje" => 'Ingrese rut del paciente.' ]);
                }
            }

            if (empty($request->input('fecha'))) {
                return response()->json([ "tipo_mensaje" => "error", "mensaje" => 'Ingrese fecha.' ]);
            }

            if (empty($request->input('hora'))) {
                return response()->json([ "tipo_mensaje" => "error", "mensaje" => 'Ingrese hora.' ]);
            }

            if (empty($request->input('sucursal_id'))) {
                return response()->json([ "tipo_mensaje" => "error", "mensaje" => 'Ingrese sucursal.' ]);
            }

            if (empty($request->input('profesional_rut'))) {
                return response()->json([ "tipo_mensaje" => "error", "mensaje" => 'Seleccione rut profesional.' ]);
            }


            $tratamiento_folio      =   $request->input('tratamiento_folio');
            $sucursal_id            =   $request->input('sucursal_id');

            if (is_null($request->input('tipo'))) {
                $num_atencion           =   $request->input('num_atencion');
                $tratamiento_folio      =   $request->input('tratamiento_folio');
                $abono                  =   $request->input('abono');
            }

            $fecha                  =   str_replace('/', '-', $request->input('fecha'));
            $fecha                  =   date('Y-m-d', strtotime($fecha));
            if (is_null($request->input('tipo'))) {
                $hora                   =   $request->input('hora');
            }else{
                $hora                   =   $request->input('hora');
                $hora                   =   date_format(date_create(Carbon::createFromFormat('H:i A', $hora)->toDateTimeString()), 'H:i');
            }
            $fecha_hora             =   $fecha.' '.$hora;

            if (!is_null($request->input('tipo'))) {
                $rut_paciente           =   $request->input('paciente_rut');
            }
            
            $profesional_rut        =   $request->input('profesional_rut');

            if (!is_null($request->input('tipo'))) {
                $disponibilidad         =   Atencion::where('profesional_rut', '=', $profesional_rut)
                                                    ->where('fecha', '=', $fecha_hora)
                                                    ->count();

                if ($disponibilidad == 1) {
                    return response()->json([ "tipo_mensaje" => "error", "mensaje" => 'El profesional seleccionado no está disponible para la hora indicada.' ]);
                }
            }

            if (empty($request->input('observacion'))) {
                $observacion        =   '';
            }else{
                $observacion        =   $request->input('observacion');
            }

            if (is_null($request->input('tipo'))) {
                if ($abono > 0) {
                    #Pueden existir cuatro pagos distintos al existir cuatro formas de pago
                    $pago1                  =   $request->input('pago1');
                    $pago2                  =   $request->input('pago2');
                    $pago3                  =   $request->input('pago3');
                    $pago4                  =   $request->input('pago4');

                    $tipo_pago1             =   $request->input('tipo_pago1');
                    $tipo_pago2             =   $request->input('tipo_pago2');
                    $tipo_pago3             =   $request->input('tipo_pago3');
                    $tipo_pago4             =   $request->input('tipo_pago4');

                    $total_pagado           =   $pago1 + $pago2 + $pago3 + $pago4;
                    #Si la suma de los pagos no es igual al abono se muestra mensaje
                    if ($abono != $total_pagado) {
                        return response()->json([ "tipo_mensaje" => "error", "mensaje" => 'El valor ingresado en medio de pago no es igual al total ingresado.' ]);
                    }
                }
            }



            if (!is_null($request->input('tipo'))) {
                $paciente                       =   Paciente::find($rut_paciente);

                if (is_null($paciente)) {
                    return response()->json([ "tipo_mensaje" => "error", "mensaje" => 'El rut ingresado no está registrado.' ]);
                }
            }
            if (!is_null($request->input('id_atencion'))) {
                #Se guarda la nueva atención
                $atencion                       = Atencion::find($request->input('id_atencion'));
                $atencion->reserva              = 0;
            }else{
                #Se guarda la nueva atención
                $atencion                       = new Atencion();
            }

            $atencion->tratamiento_folio    = $tratamiento_folio;

            if (is_null($request->input('tipo'))) {
                $atencion->num_atencion         = $num_atencion;
                $atencion->abono                = $abono;
            }else{
                $atencion->reserva              = 1;
                $atencion->paciente_rut         = $rut_paciente;
            }
            
            $atencion->profesional_rut      = $profesional_rut;    
            $atencion->observacion          = $observacion;
            $atencion->fecha                = $fecha_hora;
            $atencion->sucursal_id          = $sucursal_id;
            $atencion->usuario_rut          = Auth::user()->rut;

            $existe     =   Atencion::where('tratamiento_folio', '=', $tratamiento_folio);

            if (is_null($request->input('tipo'))) {
                $existe                         = $existe->where('num_atencion', '=', $num_atencion);
                $existe                         = $existe->where('abono', '=', $abono);
            }else{
                $existe                         = $existe->where('reserva', '=', 1);
                $existe                         = $existe->where('paciente_rut', '=', $rut_paciente);
            }

            $existe                         = $existe->where('profesional_rut', '=', $profesional_rut);
            $existe                         = $existe->where('observacion', '=', $observacion);
            $existe                         = $existe->where('fecha', '=', $fecha_hora);
            $existe                         = $existe->where('sucursal_id', '=', $sucursal_id);
            $existe                         = $existe->where('usuario_rut', '=', Auth::user()->rut);
            $existe                         = $existe->exists();

            if (!$existe) {
                $atencion->save();

                if (is_null($request->input('tipo'))) {
                    #Guarda log al cambiar estado
                    LogAccion::create([
                        'accion' => "Guardar atención",
                        'detalle' => "Se guarda atención: " .$request->input('num_atencion')." del tratamiento ".$request->input('tratamiento_folio'),
                        'usuario_rut' => Auth::user()->rut,
                    ]);

                    $tratamiento                    = Tratamiento::find($tratamiento_folio);
                    $abono_pagado                   = Atencion::select(DB::raw('SUM(abono) AS pagado'))->where('tratamiento_folio', '=', $tratamiento->folio)->first();

                    #Guarda log al cambiar estado
                    LogAccion::create([
                        'accion' => "Modificar tratamiento",
                        'detalle' => "Se editó el estado de deuda de tratamiento: " .$tratamiento_folio." del paciente ".$tratamiento->paciente_rut.".",
                        'usuario_rut' => Auth::user()->rut,
                    ]);

                    $deuda       =  intval($tratamiento->valor) - intval($abono_pagado->pagado);
                    $tratamiento->estado_deuda = ($deuda > 0) ? '1' : '0' ;
                    $tratamiento->save();

                    if ($abono > 0) {
                        $atencion_id                    = (Atencion::orderBy('id', 'desc')->first())->id;

                        if ($pago1 > 0) {
                            $pago                       = new Pago();
                            $pago->monto                = $pago1;
                            $pago->tipo_pago_id         = $tipo_pago1;
                            $pago->atenciones_id        = $atencion_id;

                            $existe_pago1               = Pago::where('monto', '=', $pago1)
                                                                ->where('tipo_pago_id', '=', $tipo_pago1)
                                                                ->where('atenciones_id', '=', $atencion_id)->exists();

                            if (!$existe_pago1) {
                                $pago->save();
                                #Guarda log al guardar pago
                                LogAccion::create([
                                    'accion' => "Guardar pago",
                                    'detalle' => "Se guarda pago de tipo: " .$tipo_pago1." a la atención: " .$request->input('num_atencion')." del tratamiento ".$request->input('tratamiento_folio'),
                                    'usuario_rut' => Auth::user()->rut,
                                ]);
                            }

                        }

                        if ($pago2 > 0) {
                            $pago                       = new Pago();
                            $pago->monto                = $pago2;
                            $pago->tipo_pago_id         = $tipo_pago2;
                            $pago->atenciones_id        = $atencion_id; 

                            $existe_pago2               = Pago::where('monto', '=', $pago2)
                                                                ->where('tipo_pago_id', '=', $tipo_pago2)
                                                                ->where('atenciones_id', '=', $atencion_id)->exists();

                            if (!$existe_pago2) {
                                $pago->save();
                                #Guarda log al guardar pago
                                LogAccion::create([
                                    'accion' => "Guardar pago",
                                    'detalle' => "Se guarda pago de tipo: " .$tipo_pago2." a la atención: " .$request->input('num_atencion')." del tratamiento ".$request->input('tratamiento_folio'),
                                    'usuario_rut' => Auth::user()->rut,
                                ]);
                            }

                        }

                        if ($pago3 > 0) {
                            $pago                       = new Pago();
                            $pago->monto                = $pago3;
                            $pago->tipo_pago_id         = $tipo_pago3;
                            $pago->atenciones_id        = $atencion_id; 

                            $existe_pago3               = Pago::where('monto', '=', $pago3)
                                                                ->where('tipo_pago_id', '=', $tipo_pago3)
                                                                ->where('atenciones_id', '=', $atencion_id)->exists();

                            if (!$existe_pago3) {
                                $pago->save();
                                #Guarda log al guardar pago
                                LogAccion::create([
                                    'accion' => "Guardar pago",
                                    'detalle' => "Se guarda pago de tipo: " .$tipo_pago3." a la atención: " .$request->input('num_atencion')." del tratamiento ".$request->input('tratamiento_folio'),
                                    'usuario_rut' => Auth::user()->rut,
                                ]); 
                            }
                                
                        }

                        if ($pago4 > 0) {
                            $pago                       = new Pago();
                            $pago->monto                = $pago4;
                            $pago->tipo_pago_id         = $tipo_pago4;
                            $pago->atenciones_id        = $atencion_id; 

                            $existe_pago4               = Pago::where('monto', '=', $pago4)
                                                                ->where('tipo_pago_id', '=', $tipo_pago4)
                                                                ->where('atenciones_id', '=', $atencion_id)->exists();

                            if (!$existe_pago4) {
                                $pago->save();
                                #Guarda log al guardar pago
                                LogAccion::create([
                                    'accion' => "Guardar pago",
                                    'detalle' => "Se guarda pago de tipo: " .$tipo_pago4." a la atención: " .$request->input('num_atencion')." del tratamiento ".$request->input('tratamiento_folio'),
                                    'usuario_rut' => Auth::user()->rut,
                                ]);
                            }
        
                        }
                    }
                }else{
                    #Guarda log al cambiar estado
                    LogAccion::create([
                        'accion' => "Guardar reserva",
                        'detalle' => "Se guarda nueva reserva para el paciente " .$request->input('rut_pacienteN'),
                        'usuario_rut' => Auth::user()->rut,
                    ]);
                }
            }

            return response()->json([ "tipo_mensaje" => "success",  "mensaje" => 'La atención se agregó correctamente.' ]);
        }
    }

    public function getTablaHistorial(Request $request)
    {

        $folio              = $request->input('folio');
        $nombre_tratamiento = utf8_decode($request->input('nombre_tratamiento'));
        $tipo               = $request->input('tipo');
        $rut_paciente       = $request->input('rut_paciente');
        $apellido_paterno   = utf8_decode($request->input('apellido_paterno'));
        #Extrae datos de Tratamiento
        $tratamientos   = Tratamiento::select('folio','tratamientos.nombre As nombre', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), 'num_control', 'tratamientos.valor As total', 'tipo_tratamientos.nombre As tipo');


        if (!is_null($folio)) {
             $tratamientos   =  $tratamientos->where('folio', '=', $folio);
        }

        if (!is_null($nombre_tratamiento)) {
            $tratamientos    = $tratamientos->whereRaw('LOWER(tratamientos.nombre) LIKE ? ','%'.utf8_encode((strtolower($nombre_tratamiento))).'%');
        }

        if (!is_null($tipo)) {
             $tratamientos   =  $tratamientos->where('tipo_tratamientos.id', '=', $tipo);
        }

        if (!is_null($rut_paciente)) {
             $tratamientos   =  $tratamientos->where('paciente_rut', '=', $rut_paciente);
        }

        if (!is_null($apellido_paterno)) {
            $tratamientos   = $tratamientos->whereRaw('LOWER(pacientes.apellido_paterno) LIKE ? ','%'.utf8_encode((strtolower($apellido_paterno))).'%');
        }

        $tratamientos    =   $tratamientos
                                          ->join('tipo_tratamientos', 'tipo_tratamiento_id', '=', 'tipo_tratamientos.id')
                                          ->join('pacientes', 'paciente_rut','=', 'pacientes.rut')
                                          ->get();

        foreach ($tratamientos as $tratamiento) {
            #Por cada tratamiento reemplaza Genérico por General y General Ortodoncia por Ortodoncia
            $tratamiento->tipo = ($tratamiento->tipo == 'Genérico') ? 'General' : $tratamiento->tipo;
            $tratamiento->tipo = ($tratamiento->tipo == 'General Ortodoncia') ? 'Ortodoncia' : $tratamiento->tipo;
            #Calcula el abono total de un tratamiento       
            $abono              =   Atencion::select(DB::raw('SUM(abono) As abono_total'))->where('tratamiento_folio', '=', $tratamiento->folio)->first();

            if (is_null($abono->abono_total)) {
                $abono->abono_total    =   "0";
            }
            #Calcula la deuda
            $deuda              =   $tratamiento->total - $abono->abono_total;
            #Aplica formato a deuda y total
            $tratamiento->deuda    = '$ '.number_format($deuda, 0 , '', '.');
            $tratamiento->total    = '$ '.number_format($tratamiento->total, 0, '', '.');
        }

        return Datatables::of($tratamientos)
                                ->addColumn('action', function ($tratamientos){                
                                    return '<a class="iconos" href="tratamiento/'.$tratamientos->folio.'"title="Ver atenciones" ><span class="fa fa-list" aria-hidden="true"></span></a>
                                    ';
                                })->rawColumns(['DT_RowId', 'action'])
                                ->make(true);
    }

    public function exportExcelHistorial(Request $request)
    {

        $folio              = $request->input('folio');
        $nombre_tratamiento = utf8_decode($request->input('nombre_tratamiento'));
        $tipo               = $request->input('tipo');
        $rut_paciente       = $request->input('rut_paciente');
        $apellido_paterno   = utf8_decode($request->input('apellido_paterno'));
        #Extrae datos de Tratamiento
        $tratamientos   = Tratamiento::select('folio','tratamientos.nombre As nombre', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), 'num_control', 'tratamientos.valor As total', 'tipo_tratamientos.nombre As tipo');


        if (!is_null($folio)) {
             $tratamientos   =  $tratamientos->where('folio', '=', $folio);
        }

        if (!is_null($nombre_tratamiento)) {
            $tratamientos    = $tratamientos->whereRaw('LOWER(tratamientos.nombre) LIKE ? ','%'.utf8_encode((strtolower($nombre_tratamiento))).'%');
        }

        if (!is_null($tipo)) {
             $tratamientos   =  $tratamientos->where('tipo_tratamientos.id', '=', $tipo);
        }

        if (!is_null($rut_paciente)) {
             $tratamientos   =  $tratamientos->where('pacientes_rut', '=', $rut_paciente);
        }

        if (!is_null($apellido_paterno)) {
            $tratamientos   = $tratamientos->whereRaw('LOWER(pacientes.apellido_paterno) LIKE ? ','%'.utf8_encode((strtolower($apellido_paterno))).'%');
        }

        $tratamientos    =   $tratamientos
                                          ->join('tipo_tratamientos', 'tipo_tratamiento_id', '=', 'tipo_tratamientos.id')
                                          ->join('pacientes', 'tratamientos.paciente_rut','=', 'pacientes.rut')
                                          ->get();

        foreach ($tratamientos as $tratamiento) {
            #Por cada tratamiento reemplaza Genérico por General y General Ortodoncia por Ortodoncia
            $tratamiento->tipo = ($tratamiento->tipo == 'Genérico') ? 'General' : $tratamiento->tipo;
            $tratamiento->tipo = ($tratamiento->tipo == 'General Ortodoncia') ? 'Ortodoncia' : $tratamiento->tipo;
            #Calcula el abono total de un tratamiento 
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
                #Aplica formato a una columna específica del archivo Excel
                $sheet->setColumnFormat(array(
                    'B' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY,
                    'C' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4,
                    'E' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD,
                    'F' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                ));

                foreach ($tratamientos as $key => $value) {
                    #Títulos encabezado, se aplica un estilo
                    $sheet->row($count, ['Folio', 'Tipo', 'Tratamiento', 'Controles', 'Precio total', 'Deuda']);
                    $sheet->cells('A'.$count.':F'.$count, function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    #Contenido de la tabla
                    $count = $count +1;
                    $sheet->row($count, [$value->folio, $value->tipo, $value->nombre, $value->num_control, $value->total, $value->deuda]);
                    $count = $count +1;
                    #Títulos encabezado, se aplica un estilo
                    $sheet->row($count, ['Número control', 'Fecha', 'Hora', 'Profesional', 'Sucursal', 'Abono']);
                    $sheet->cells('A'.$count.':F'.$count, function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    #Se extraen datos de Atención asociada al número de folio
                    $atenciones         = Atencion::select('num_atencion', 'fecha', DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As profesional"), 'abono', 'sucursales.nombre As sucursal')
                                ->join('profesionales', 'profesional_rut','=', 'rut')
                                ->join('sucursales', 'sucursal_id','=', 'sucursales.id')
                                ->where('tratamiento_folio', '=', $value->folio)
                                ->get();

                    $count = $count +1;

                    foreach ($atenciones as $atencion) {
                        #Por cada atención se aplica formato
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

    public function indexReservas()
    {
        #Se obtienen todos los tipo de tratamiento, menos el 3 que es el genérico
        $tipo_tratamientos = TipoTratamiento::where('id', '<>', '3')->get();

        $sucursal               =   null;

        if (!is_object(Auth::user()->perfil_id)) {
            if (Auth::user()->perfil_id <= 2) {
                $sucursal           =   Sucursal::get()->pluck('nombre', 'id');
            }

            $sucursales               =   Sucursal::get();
        }

        foreach ($tipo_tratamientos as $tipo_tratamiento) {
            #El nombre se cambia de General Ortodoncia a Ortodoncia
            $tipo_tratamiento->nombre = ($tipo_tratamiento->nombre == 'General Ortodoncia') ? 'Ortodoncia' : $tipo_tratamiento->nombre;
        }

        $tipo_tratamientos = $tipo_tratamientos->pluck('nombre', 'id');

        $events   = [];

        $paciente_rut       = \Request::get('rut_pacienteB');
        $apellido_paterno   = \Request::get('apellido_paterno_pacienteB');
        $profesional_rut    = \Request::get('rut_profesionalB');
        $nombrep            = \Request::get('nombres_profesionalB');
        $apellido_paternop  = \Request::get('apellido_paterno_profesionalB');
        $apellido_maternop  = \Request::get('apellido_materno_profesionalB');
        $fecha              = \Request::get('fechaB');
        $sucursal_id        = \Request::get('sucursalB');

        $atenciones         = Atencion::select('atenciones.id', 'fecha', 'paciente_rut', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), 'profesional_rut', DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As profesional"),'sucursales.nombre As sucursal', 'sucursales.color As sucursal_color')
                                ->join('profesionales', 'profesional_rut','=', 'profesionales.rut')
                                ->join('pacientes', 'paciente_rut','=', 'pacientes.rut')
                                ->join('sucursales', 'sucursal_id','=', 'sucursales.id');

        if (!is_null($paciente_rut)) {
            $atenciones     =   $atenciones->where('paciente_rut', '=', $paciente_rut);
        }

        if (!is_null($apellido_paterno)) {
            $atenciones     =   $atenciones->where('pacientes.apellido_paterno', '=', $apellido_paterno);
        }

        if (!is_null($profesional_rut)) {
            $atenciones     =   $atenciones->where('profesional_rut', '=', $profesional_rut);
        }

        if (!is_null($nombrep)) {
            $atenciones     =   $atenciones->where('profesionales.nombres', '=', $nombrep);
        }

        if (!is_null($apellido_paternop)) {
            $atenciones     =   $atenciones->where('profesionales.apellido_paterno', '=', $apellido_paternop);
        }

        if (!is_null($apellido_maternop)) {
            $atenciones     =   $atenciones->where('profesionales.apellido_materno', '=', $apellido_maternop);
        }

        if (!is_null($fecha)) {
            $fecha          = str_replace('/', '-', $fecha);
            $fecha          = date('Y-m-d', strtotime($fecha));
            $atenciones     = $atenciones->whereBetween('fecha', [$fecha.' 00:00:00', $fecha.' 23:59:59']);
        }

        if (Auth::user()->perfil_id >= 3) {
            $atenciones     =   $atenciones->where('sucursal_id', '=', session('sucursal_id'));
        }else{
            if (!is_null($sucursal_id)) {
                $atenciones     =   $atenciones->where('sucursal_id', '=', $sucursal_id);
            }
        }
        
        $atenciones     =   $atenciones->where('reserva', '=', 1)->get();

        foreach ($atenciones as $calendario) {
            $events[] = Calendar::event(
                $calendario->paciente,
                false,
                new \DateTime($calendario->fecha),
                new \DateTime($calendario->fecha.' +15 minutes'),
                1,
                [
                    'color' => $calendario->sucursal_color,
                    'url' => url('reserva').'/'.$calendario->id,
                    'description' => "Event Description",
                    'textColor' => '#FFF'
                ]
            );
        }

        $calendar = Calendar::addEvents($events)
                            ->setOptions([
                                            'firstDay' => 1,
                                            'lang' => 'es',
                                            'buttonText'=>[
                                                            'today' => 'Hoy',
                                                            'month' => 'Mes',
                                                            'week' => 'Semana',
                                                            'day' => 'Día'
                                                           ],
                                            'monthNames' => ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                                            'monthNamesShort' => ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
                                            'dayNames' => ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
                                            'dayNamesShort' => ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb']
                                        ])->setCallbacks([]);

        return view('atencion.index_reserva')->with('tipo_tratamientos',$tipo_tratamientos)->with('sucursal',$sucursal)->with('calendar', $calendar)->with('sucursales', $sucursales);
    }

    public function getTableReservas(Request $request)
    {
        $paciente_rut       = $request->input('paciente_rut');
        $apellido_paterno   = $request->input('apellido_paterno');
        $profesional_rut    = $request->input('profesional_rut');
        $apellido_paternop  = $request->input('apellido_paternop');
        $fecha              = $request->input('fecha');
        $sucursal_id        = $request->input('sucursal_id');

        $atenciones         = Atencion::select('atenciones.id', 'fecha', 'paciente_rut', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), 'profesional_rut', DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As profesional"), 'sucursales.nombre As sucursal')
                                        ->join('profesionales', 'profesional_rut','=', 'profesionales.rut')
                                        ->join('pacientes', 'paciente_rut','=', 'pacientes.rut')
                                        ->join('sucursales', 'sucursal_id','=', 'sucursales.id');

        if (!is_null($paciente_rut)) {
            $atenciones     =   $atenciones->where('paciente_rut', '=', $paciente_rut);
        }

        if (!is_null($apellido_paterno)) {
            $atenciones     =   $atenciones->where('pacientes.apellido_paterno', '=', $apellido_paterno);
        }

        if (!is_null($profesional_rut)) {
            $atenciones     =   $atenciones->where('profesional_rut', '=', $profesional_rut);
        }

        if (!is_null($apellido_paternop)) {
            $atenciones     =   $atenciones->where('profesionales.apellido_paterno', '=', $apellido_paternop);
        }

        if (!is_null($fecha)) {
            $fecha          = str_replace('/', '-', $fecha);
            $fecha          = date('Y-m-d', strtotime($fecha));
            $atenciones     = $atenciones->whereBetween('fecha', [$fecha.' 00:00:00', $fecha.' 23:59:59']);
        }

        if (Auth::user()->perfil_id >= 3) {
            $atenciones     =   $atenciones->where('sucursal_id', '=', session('sucursal_id'));
        }else{
            if (!is_null($sucursal_id)) {
                $atenciones     =   $atenciones->where('sucursal_id', '=', $sucursal_id);
            }
        }

        $atenciones     =   $atenciones->limit(10)->where('reserva', '=', 1)->get();

        $numatencion = 0;

        foreach ($atenciones as $atencion) {
            #Aplica formato a hora, fecha  y abono
            $atencion->num_atencion = $numatencion + 1;
            $atencion->hora         = date_format(date_create($atencion->fecha), 'h:i A');
            $atencion->fecha        = date_format(date_create($atencion->fecha), 'd/m/Y');
            $atencion->abono        = '$ '.number_format($atencion->abono, 0, '', '.');
        }

        return Datatables::of($atenciones)
                                ->addColumn('action', function ($atenciones){
                                        if(Auth::user()->perfil_id <= 3){
                                            #Esto solo lo puede ver el administrador y superadministrador
                                            return '<a href="'.url('reserva/'.$atenciones->id).'" title=Detalle>
                                                    <em class="fa fa-eye fa-lg"></em>
                                                </a>
                                                <a href="'.url('activarReserva/'.$atenciones->id).'" title=Detalle>
                                                    <em class="fa fa-check fa-lg"></em>
                                                </a>
                                                <a class="iconos" href="#" data-toggle="modal" data-target="#modal-eliminar_'.$atenciones->id.'" title="Eliminar" >
                                                    <span class="fa fa-trash-o" aria-hidden="true"></span>
                                                </a>
                                                <div class="modal fade" id="modal-eliminar_'.$atenciones->id.'" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-red">
                                                                <h4 class="modal-title">Confirmar eliminación</h4>
                                                            </div>

                                                            <div class="modal-body">
                                                                <h3>¿Está seguro de eliminar a esta reserva?</h3>
                                                            </div>
                                                            
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                                                <a  href="'.url('atencion/destroy/'.$atenciones->id).'" type="submit" class="btn btn-danger" role="button">Aceptar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>';
                                        }else{
                                            #Esto solo lo puede ver la secretaria y asistente
                                            return '<a href="'.url('atencion/'.$atenciones->id).'" title=Detalle>
                                                    <em class="fa fa-eye fa-lg"></em>
                                                </a>';
                                    }
                                })
                                ->make(true);
    }

    public function exportExcelReservas(Request $request)
    {
        $paciente_rut       = $request->input('rut_pacienteE');
        $apellido_paterno   = $request->input('apellido_paternoE');
        $profesional_rut    = $request->input('rut_profesionalE');
        $nombrep            = $request->input('nombres_profesionalE');
        $apellido_paternop  = $request->input('apellido_paterno_profesionalE');
        $apellido_maternop  = $request->input('apellido_materno_profesionalE');
        $fecha              = $request->input('fechaE');
        $sucursal_id        = $request->input('sucursalE');

        $atenciones         = Atencion::select('atenciones.id', 'fecha', 'paciente_rut', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), 'profesional_rut', DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As profesional"), 'sucursales.nombre As sucursal')
                                ->join('profesionales', 'profesional_rut','=', 'profesionales.rut')
                                ->join('pacientes', 'paciente_rut','=', 'pacientes.rut')
                                ->join('sucursales', 'sucursal_id','=', 'sucursales.id');

        if (!is_null($paciente_rut)) {
            $atenciones     =   $atenciones->where('paciente_rut', '=', $paciente_rut);
        }

        if (!is_null($apellido_paterno)) {
            $atenciones     =   $atenciones->where('pacientes.apellido_paterno', '=', $apellido_paterno);
        }

        if (!is_null($profesional_rut)) {
            $atenciones     =   $atenciones->where('profesional_rut', '=', $profesional_rut);
        }

        if (!is_null($nombrep)) {
            $atenciones     =   $atenciones->where('profesionales.nombres', '=', $nombrep);
        }

        if (!is_null($apellido_paternop)) {
            $atenciones     =   $atenciones->where('profesionales.apellido_paterno', '=', $apellido_paternop);
        }

        if (!is_null($apellido_maternop)) {
            $atenciones     =   $atenciones->where('profesionales.apellido_materno', '=', $apellido_maternop);
        }

        if (!is_null($fecha)) {
            $fecha          = str_replace('/', '-', $fecha);
            $fecha          = date('Y-m-d', strtotime($fecha));
            $atenciones     = $atenciones->whereBetween('fecha', [$fecha.' 00:00:00', $fecha.' 23:59:59']);
        }

        if (Auth::user()->perfil_id >= 3) {
            $atenciones     =   $atenciones->where('sucursal_id', '=', session('sucursal_id'));
        }else{
            if (!is_null($sucursal_id)) {
                $atenciones     =   $atenciones->where('sucursal_id', '=', $sucursal_id);
            }
        }

        $atenciones     =   $atenciones->where('reserva', '=', 1)->get();
        $numatencion = 0;

        foreach ($atenciones as $atencion) {
            #Por cada reserva se aplica formato
            $atencion->hora     = date_format(date_create($atencion->fecha), 'H:i A');
            $atencion->fecha    = date_format(date_create($atencion->fecha), 'Y-m-d');
            $atencion->fecha    = strtotime($atencion->fecha);
            $atencion->fecha    = \PHPExcel_Shared_Date::PHPToExcel($atencion->fecha);
        }

        return Excel::create('ListadoReservas', function($excel) use ($atenciones) {
            $excel->sheet('Reservas', function($sheet) use ($atenciones)
            {
                #Aplica formato a una columna específica del archivo Excel
                $sheet->setColumnFormat(array(
                    'C' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY,
                    'D' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4
                ));

                #Títulos encabezado, se aplica un estilo
                $sheet->row(1, ['Rut Paciente', 'Paciente', 'Fecha', 'Hora', 'Rut Profesional', 'Profesional', 'Sucursal']);
                $sheet->cells('A1:G1', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });

                $count = 2;
                
                foreach ($atenciones as $key => $value) {
                    #Contenido de la tabla
                    $sheet->row($count, [$value->paciente_rut, $value->paciente, $value->fecha, $value->hora, $value->profesional_rut, $value->profesional, $value->sucursal]);
                    $count = $count +1;
                }
            });
        })->download('xlsx');
    }

    public function showReserva($id)
    {
        
        #Se extraen datos de Atención
        $atenciones = Atencion::select('atenciones.paciente_rut', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), 'fecha', 'sucursales.nombre As sucursal', 'atenciones.id As atenciones_id',DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As profesional"), 'profesiones.nombre As profesion', 'tipo_contrato.nombre As tipo', 'atenciones.observacion')
                            ->join('pacientes', 'atenciones.paciente_rut','=', 'pacientes.rut')
                            ->join('profesionales', 'profesional_rut','=', 'profesionales.rut')
                            ->join('sucursales', 'sucursales.id','=', 'sucursal_id')
                            ->join('profesiones', 'profesiones.id', '=', 'profesionales.profesion_id')
                            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'profesionales.tipo_contrato_id')
                            ->where('atenciones.id', '=', $id)
                            ->first();

        #Se extraen datos de Pago
        $pagos = Pago::select('tipo_pago.nombre As nombre', 'monto')
                        ->join('tipo_pago', 'tipo_pago.id', '=', 'pagos.tipo_pago_id')
                        ->where('pagos.atenciones_id', '=', $id)
                        ->get();

        #Se obtienen una lista de observaciones del sistema
        $observaciones = Observacion::where('atencion_id', '=', $atenciones->atenciones_id)->get();
        foreach ($observaciones as $observacion) {
            $observacion->hora  = date_format(date_create($observacion->fecha), 'H:i:s');
            $observacion->fecha = date_format(date_create($observacion->fecha), 'd/m/Y');
        }

        #Se recorren todos los pagos para aplicar formato
        foreach ($pagos as $pago) {
            $pago->monto    = '$ '.number_format($pago->monto, 0 , '', '.');
        }

        $atenciones->hora     = date_format(date_create($atenciones->fecha), 'H:i:s');
        $atenciones->fecha    = date_format(date_create($atenciones->fecha), 'd/m/Y');
        $atenciones->abono    = '$ '.number_format($atenciones->abono, 0, '', '.');

        return view("atencion.show_reserva")
                                ->with('atenciones', $atenciones)
                                ->with('observaciones', $observaciones)
                                ->with('pagos',$pagos);
    }

    public function activarReserva(Request $request, $id)
    {
        $reservas           = Atencion::find($id);

        $folio              = $reservas->tratamiento_folio;

        $reserva            = true;

        $fecha              = date_format(date_create($reservas->fecha), 'd/m/Y');
        $hora               = date_format(date_create($reservas->fecha), 'H:i');
        $sucursales         = Sucursal::orderBy('nombre','asc')->pluck('nombre', 'id');
        $tipo_pago          = TipoPago::get();
        $tipo_pagoSelect    = TipoPago::pluck('nombre', 'id');

        #Extrae datos de Profesional
        $profesionales = Profesional::select('profesionales.rut',  DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As nombre_profesional"), 'profesiones.nombre As profesion', 'tipo_contrato.nombre As tipo')
                                ->join('profesiones', 'profesiones.id', '=', 'profesionales.profesion_id')
                                ->join('tipo_contrato', 'tipo_contrato.id', '=', 'profesionales.tipo_contrato_id')->join('sucursal_profesional', 'profesionales.rut', '=','sucursal_profesional.profesional_rut')->where('profesionales.estado', '=', '1')->where('sucursal_profesional.sucursal_id', '=', $reservas->sucursal_id)->get();


        $profesionalesSelect = $profesionales->pluck('nombre_profesional', 'rut');


        $tratamientos        =   Tratamiento::where('paciente_rut', '=', $reservas->paciente_rut)->get()->pluck('folio', 'folio');



        if (!is_null($folio)) {
            $tratamiento    =   Tratamiento::find($folio);
            $paciente       =   Paciente::find($tratamiento->paciente_rut);
            $atencion       =   Atencion::where('tratamiento_folio', '=', $tratamiento->folio)->orderBy('num_atencion', 'desc')->get();
            if ($atencion->isEmpty()) {
                $n_atencion = 1;
            }else{
                $atencion   =   $atencion->first();
                $n_atencion =   ($atencion->num_atencion) + 1;
            }

            return view ("atencion.create", compact('tratamiento'), compact('paciente'))->with('folio', $folio)->with('id_atencion', $id)->with('n_atencion', $n_atencion)->with('fecha', $fecha)->with('hora', $hora)->with('sucursales', $sucursales)->with('tipo_pago', $tipo_pago)->with('reserva', $reserva)->with('tipo_pagoSelect', $tipo_pagoSelect)->with('sucursalSelect', $reservas->sucursal_id)->with('profesionales', $profesionales)->with('profesionalesSelect', $profesionalesSelect)->with('reservas', $reservas)->with('tratamientos_folio', $tratamientos);
        }else{
            $paciente       =   Paciente::find($reservas->paciente_rut);
            return view ("atencion.create")->with('fecha', $fecha)->with('hora', $hora)->with('sucursales', $sucursales)->with('id_atencion', $id)->with('tipo_pago', $tipo_pago)->with('reserva', $reserva)->with('paciente', $paciente)->with('sucursalSelect', $reservas->sucursal_id)->with('tipo_pagoSelect', $tipo_pagoSelect)->with('profesionales', $profesionales)->with('profesionales', $profesionales)->with('profesionalesSelect', $profesionalesSelect)->with('reservas', $reservas)->with('tratamientos_folio', $tratamientos);
        }
    }

    public function observacion($id)
    {
        #Se extraej datos de Atención
        $atenciones = Atencion::select('tratamiento_folio', 'tratamientos.nombre As nombre', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), 'atenciones.id', 'num_atencion', 'fecha', 'sucursales.nombre As sucursal', DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As profesional"), 'profesiones.nombre As profesion', 'tipo_contrato.nombre As tipo', 'atenciones.observacion', 'abono')
                                ->join('tratamientos', 'tratamientos.folio', '=', 'atenciones.tratamiento_folio')
                                ->join('pacientes', 'tratamientos.paciente_rut','=', 'pacientes.rut')
                                ->join('profesionales', 'profesional_rut','=', 'profesionales.rut')
                                ->join('sucursales', 'sucursales.id','=', 'sucursal_id')
                                ->join('profesiones', 'profesiones.id', '=', 'profesionales.profesion_id')
                                ->join('tipo_contrato', 'tipo_contrato.id', '=', 'profesionales.tipo_contrato_id')
                                ->where('atenciones.id', '=', $id)
                                ->first();
        #Extrae datos de Pago
        $pagos = Pago::select('tipo_pago.nombre As nombre', 'monto')
                        ->join('tipo_pago', 'tipo_pago.id', '=', 'pagos.tipo_pago_id')
                        ->where('pagos.atenciones_id', '=', $id)
                        ->get();

        #Aplica respectivo formato a hora, fecha y abono
        $atenciones->hora     = date_format(date_create($atenciones->fecha), 'H:i:s');
        $atenciones->fecha    = date_format(date_create($atenciones->fecha), 'd/m/Y');
        $atenciones->abono    = '$ '.number_format($atenciones->abono, 0, '', '.');

        return view("atencion.observacion")
                                ->with('atenciones', $atenciones)
                                ->with('pagos',$pagos);
    }

    public function getTableHorasDisponibles(Request $request)
    {
        if (condition) {
            # code...
        }
    }
}
