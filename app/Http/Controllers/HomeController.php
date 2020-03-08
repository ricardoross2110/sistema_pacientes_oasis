<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Atencion;
use App\Notificacion;
use App\LogAccion;
use App\LogErrores;
use App\Paciente;
use App\Usuario;
use App\Tratamiento;
use App\TipoTratamiento;
use App\Sucursal;
use App\Santoral;
use DateTime;
use DateTimeImmutable;
use helpers;
use Morris;
use Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(){

        $usuario = Usuario::find(Auth::user()->rut);

        date_default_timezone_set('America/Santiago');
        $date = Carbon::now();
        $pacientesclumplehoy = Paciente::whereDay('fecha_nacimiento', '=', $date->day)->whereMonth('fecha_nacimiento', '=', $date->month)->get();
        $santoHoy = Santoral::whereDay('fecha','=', $date->day)->whereMonth('fecha', '=', $date->month)->get();
        #Por cada paciente que esté de cumpleaños se calcula su edad
        foreach ($pacientesclumplehoy as $paciente) {
            $fecha_nacimiento   = new DateTime($paciente->fecha_nacimiento);
            $ahora              = new DateTime();

            $edad = $ahora->diff($fecha_nacimiento);

            $paciente->edad = $edad->y;
        }
        #Se obtienen todos los pacientes que tengan una deuda pendiente
        $pacientes_con_deuda    =   Tratamiento::select('folio', 'paciente_rut')->where('estado_deuda', '=', 1)->groupBy('folio', 'paciente_rut')->get();

        $pacientes_un_mes       =   [];
        $pacientes_dos_meses    =   [];
        $pacientes_tres_meses   =   [];

        $fecha_actual       =   date_format(date_create('America/Santiago'), 'Y-m-d H:s:i');
        $fecha_actual       =   Carbon::createFromFormat('Y-m-d H:s:i', $fecha_actual);
        #Se recorre cada paciente que posea una deuda pendiente
        foreach ($pacientes_con_deuda as $condeuda) {
            $atencion           =   Atencion::where('tratamiento_folio', '=', $condeuda->folio)->orderBy('fecha', 'desc')->first();
            if (!is_null($atencion)) {
                $ultima_atencion    =   Carbon::createFromFormat('Y-m-d H:s:i', $atencion->fecha);
                $cant_meses         =   $fecha_actual->diffInMonths($ultima_atencion);
                #Si la deuda es menor a un mes
                if ($cant_meses < 1) {
                    if (!in_array($condeuda->paciente_rut, $pacientes_un_mes)) {
                        array_push($pacientes_un_mes, $condeuda->paciente_rut);
                    }
                #Si la deuda es mayor a un mes y menor a dos meses
                }else if ($cant_meses >= 1 && $cant_meses < 2) {
                    if (!in_array($condeuda->paciente_rut, $pacientes_dos_meses)) {
                        array_push($pacientes_dos_meses, $condeuda->paciente_rut);
                    }
                #Si la deuda es mayor a dos meses
                }else if ($cant_meses >= 2) {
                    if (!in_array($condeuda->paciente_rut, $pacientes_tres_meses)) {
                        array_push($pacientes_tres_meses, $condeuda->paciente_rut);
                    }
                }
            }
        }
        #Para formar el semáforo de deuda, se suma la cantidad de pacientes de los diferentes grupos formados anteriormente
        $pacientes_al_dia            =   count($pacientes_un_mes);
        $pacientes_deuda             =   count($pacientes_dos_meses);
        $pacientes_atrasadas         =   count($pacientes_tres_meses);

        #Se obtienen todos los tipo de tratamiento, menos el 3 que es el genérico
        $tipo_tratamientos = TipoTratamiento::where('id', '<>', '3')->get();

        foreach ($tipo_tratamientos as $tipo_tratamiento) {
            #El nombre se cambia de General Ortodoncia a Ortodoncia
            $tipo_tratamiento->nombre = ($tipo_tratamiento->nombre == 'General Ortodoncia') ? 'Ortodoncia' : $tipo_tratamiento->nombre;
        }

        $tipo_tratamientos = $tipo_tratamientos->pluck('nombre', 'id');

        return view ("adminlte::home")->with('pacientesclumplehoy', $pacientesclumplehoy)
                                        ->with('tipo_tratamientos',$tipo_tratamientos)
                                        ->with('santoHoy',$santoHoy)
                                        ->with('pacientes_al_dia', $pacientes_al_dia)
                                        ->with('pacientes_deuda', $pacientes_deuda)
                                        ->with('pacientes_atrasadas', $pacientes_atrasadas);
    }

    public function cargarTablePersonasAlDia(Request $request)
    {
        if ($request->ajax()) {
            #Se extraen datos de Tratamiento de personas con deudas
            $pacientes_con_deuda    =   Tratamiento::select('folio', 'paciente_rut')->where('estado_deuda', '=', 1)->groupBy('folio', 'paciente_rut')->get();

            $pacientes_un_mes       =   [];
            
            $fecha_actual           =   date_format(date_create('America/Santiago'), 'Y-m-d H:s:i');
            $fecha_actual           =   Carbon::createFromFormat('Y-m-d H:s:i', $fecha_actual);

            foreach ($pacientes_con_deuda as $condeuda) {
                $atencion           =   Atencion::where('tratamiento_folio', '=', $condeuda->folio)->orderBy('fecha', 'desc')->first();
                if (!is_null($atencion)) {
                    $ultima_atencion    =   Carbon::createFromFormat('Y-m-d H:s:i', $atencion->fecha);
                    $cant_meses         =   $fecha_actual->diffInMonths($ultima_atencion);
                    #Cada paciente que tenga una deuda de menos de un mes saldrá en la tabla
                    if ($cant_meses < 1) {
                        $paciente           =   Paciente::find($condeuda->paciente_rut);

                        $datos              =   array('rut' => $paciente->rut, 'folio' => $condeuda->folio, 'paciente' => $paciente->nombres.' '.$paciente->apellido_paterno.' '.$paciente->apellido_materno, 'ultima_atencion' => date_format(date_create($atencion->fecha), 'Y/m/d'));
                        array_push($pacientes_un_mes, $datos);

                    }
                }
            }

            $pacientes_un_mes   =   json_decode(json_encode($pacientes_un_mes), false);

            #Genera tabla con pacientes con menos de un mes de no pago
            return Datatables::of($pacientes_un_mes)
                                    ->addColumn('detalle_folio', function ($pacientes_atrasadas){                
                                                    return '<a href="'.url('/tratamiento/').'/'.$pacientes_atrasadas->folio.'" title=Detalle>'.$pacientes_atrasadas->folio.'</a>';
                                    })
                                    ->addColumn('detalle_rut', function ($pacientes_dos_mes){                
                                                    return '<a href="'.url('/pacientes/').'/'.$pacientes_dos_mes->rut.'" title=Detalle>'.$pacientes_dos_mes->rut.'</a>';
                                    })
                                    ->rawColumns(['detalle_rut', 'detalle_folio'])
                                    ->make(true);
        }
    }

    public function cargarTablePersonasDeudas(Request $request)
    {
        if ($request->ajax()) {
            #Se extraen datos de Tratamiento de personas con deudas
            $pacientes_con_deuda    =   Tratamiento::select('folio', 'paciente_rut', 'valor')->where('estado_deuda', '=', 1)->groupBy('folio', 'paciente_rut', 'valor')->get();

            $pacientes_dos_mes       =   [];
            
            $fecha_actual           =   date_format(date_create('America/Santiago'), 'Y-m-d H:s:i');
            $fecha_actual           =   Carbon::createFromFormat('Y-m-d H:s:i', $fecha_actual);

            foreach ($pacientes_con_deuda as $condeuda) {
                $atencion           =   Atencion::where('tratamiento_folio', '=', $condeuda->folio)->orderBy('fecha', 'desc')->first();
                
                if (!is_null($atencion)) {
                    $ultima_atencion    =   Carbon::createFromFormat('Y-m-d H:s:i', $atencion->fecha);
                    $cant_meses         =   $fecha_actual->diffInMonths($ultima_atencion);

                    if ($cant_meses >= 1 && $cant_meses < 2) {
                        #Cada paciente que tenga más de un mes o menos de dos meses de deuda saldrá en esta tabla
                        $total_atencion     =   Atencion::select(DB::raw('SUM(abono) As abono_total'))
                                                            ->where('tratamiento_folio', '=', $condeuda->folio)
                                                            ->first();

                        $deuda              =   $condeuda->valor - $total_atencion->abono_total;

                        $deuda              = '$ '.number_format($deuda, 0 , '', '.');
                                                    
                        $paciente           =   Paciente::find($condeuda->paciente_rut);

                        $datos              =   array('rut' => $paciente->rut, 'folio' => $condeuda->folio, 'paciente' => $paciente->nombres.' '.$paciente->apellido_paterno.' '.$paciente->apellido_materno, 'ultima_atencion' =>  date_format(date_create($atencion->fecha), 'Y/m/d'), 'deuda' => $deuda);

                        array_push($pacientes_dos_mes, $datos);
                    }
                }
            }

            $pacientes_dos_mes   =   json_decode(json_encode($pacientes_dos_mes), false);

            #Genera tabla de pacientes con dos meses de atraso
            return Datatables::of($pacientes_dos_mes)
                                    ->addColumn('detalle_folio', function ($pacientes_atrasadas){                
                                                    return '<a href="'.url('/tratamiento/').'/'.$pacientes_atrasadas->folio.'" title=Detalle>'.$pacientes_atrasadas->folio.'</a>';
                                    })
                                    ->addColumn('detalle_rut', function ($pacientes_dos_mes){                
                                                    return '<a href="'.url('/pacientes/').'/'.$pacientes_dos_mes->rut.'" title=Detalle>'.$pacientes_dos_mes->rut.'</a>';
                                    })
                                    ->rawColumns(['detalle_rut', 'detalle_folio'])
                                    ->make(true);
        }
    }

    public function cargarTablePersonasAtrasado(Request $request)
    {
        
        if ($request->ajax()) {
            #Se extraen datos de Tratamiento de personas con deudas
            $pacientes_con_deuda    =   Tratamiento::select('folio', 'paciente_rut', 'valor')->where('estado_deuda', '=', 1)->groupBy('folio', 'paciente_rut', 'valor')->get();

            $pacientes_atrasadas    =   [];
            
            $fecha_actual           =   date_format(date_create('America/Santiago'), 'Y-m-d H:s:i');
            $fecha_actual           =   Carbon::createFromFormat('Y-m-d H:s:i', $fecha_actual);

            foreach ($pacientes_con_deuda as $condeuda) {
                $atencion           =   Atencion::where('tratamiento_folio', '=', $condeuda->folio)->orderBy('fecha', 'desc')->first();
                if (!is_null($atencion)) {
                    $ultima_atencion    =   Carbon::createFromFormat('Y-m-d H:s:i', $atencion->fecha);
                    $cant_meses         =   $fecha_actual->diffInMonths($ultima_atencion);

                    if ($cant_meses >= 2) {
                        #Cada paciente que tenga más de dos meses de no pago saldrá en la tabla
                        $total_atencion     =   Atencion::select(DB::raw('SUM(abono) As abono_total'))
                                                            ->where('tratamiento_folio', '=', $condeuda->folio)
                                                            ->first();

                        $deuda              =   $condeuda->valor - $total_atencion->abono_total;

                        $deuda              =   '$ '.number_format($deuda, 0 , '', '.');
                                                    
                        $paciente           =   Paciente::find($condeuda->paciente_rut);

                        $datos              =   array('rut' => $paciente->rut, 'folio' => $condeuda->folio ,'paciente' => $paciente->nombres.' '.$paciente->apellido_paterno.' '.$paciente->apellido_materno, 'ultima_atencion' =>  date_format(date_create($atencion->fecha), 'Y/m/d'), 'deuda' => $deuda);

                        array_push($pacientes_atrasadas, $datos);
                    }
                }
            }

            $pacientes_atrasadas   =   json_decode(json_encode($pacientes_atrasadas), false);

            #Genera tabla de pacientes atrasados
            return Datatables::of($pacientes_atrasadas)
                                    ->addColumn('detalle_folio', function ($pacientes_atrasadas){                
                                                    return '<a href="'.url('/tratamiento/').'/'.$pacientes_atrasadas->folio.'" title=Detalle>'.$pacientes_atrasadas->folio.'</a>';
                                    })
                                    ->addColumn('detalle_rut', function ($pacientes_atrasadas){                
                                                    return '<a href="'.url('/pacientes/').'/'.$pacientes_atrasadas->rut.'" title=Detalle>'.$pacientes_atrasadas->rut.'</a>';
                                    })
                                    ->rawColumns(['detalle_folio', 'detalle_rut'])
                                    ->make(true);
        }
    }

    public function errorGeneral($message)
    {
        $mensaje = \Request::get('mensaje');

        $timeZone = 'America/Santiago'; 
        date_default_timezone_set($timeZone);      

        $logError               =   new LogErrores;
        $logError->usuario_rut      =   Auth::user()->rut;
        $logError->tipo_error   =   'Error General';
        $logError->detalle      =   'Ocurrió un error general al intentar realizar una acción no permitida.';
        $logError->mensaje      =   $mensaje;
        $logError->created_at    =  date_create();
        $logError->save();

        #Guarda log al producirse un error general
        LogAccion::create([
            'usuario_rut' => Auth::user()->rut,
            'accion' => "Error General",
            'detalle' => "Hubo un error no especifaco.",
        ]);

        return view('errors.general');
    }

    public function error400()
    {
        $timeZone = 'America/Santiago'; 
        date_default_timezone_set($timeZone);      

        $logError               =   new LogErrores;
        $logError->usuario_rut      =   Auth::user()->rut;
        $logError->tipo_error   =   'Error 400';
        $logError->detalle      =   'El usuario quiso ingresar a una página que ya no existe.';
        $logError->created_at    =   date_create();
        $logError->save();
        #Guarda log al producirse un error 400
        LogAccion::create([
            'usuario_rut' => Auth::user()->rut,
            'accion' => "Error 400",
            'detalle' => "El usuario quiso ingresar a una página que no existe.",
        ]);

        return view('errors.404');
    }
    
    public function error403()
    {
        $timeZone = 'America/Santiago'; 
        date_default_timezone_set($timeZone);      

        $logError               =   new LogErrores;
        $logError->usuario_rut      =   Auth::user()->rut;
        $logError->tipo_error   =   'Error 403';
        $logError->detalle      =   'El usuario quiso ingresar a una página la cuál no tiene el permiso.';
        $logError->created_at    =   date_create();
        $logError->save();
        #Guarda log al producirse un error 403
        LogAccion::create([
            'usuario_rut' => Auth::user()->rut,
            'accion' => "Error 403",
            'detalle' => "El usuario quiso ingresar a una página con acceso prohibido.",
        ]);
        return view('errors.403');
    }
    
    public function error404()
    {
        $timeZone = 'America/Santiago'; 
        date_default_timezone_set($timeZone);      

        $logError               =   new LogErrores;
        $logError->usuario_rut      =   Auth::user()->rut;
        $logError->tipo_error   =   'Error 404';
        $logError->detalle      =   'El usuario quiso ingresar a una página que no existe o no funciona.';
        $logError->created_at    =   date_create();
        $logError->save();
        #Guarda log al producirse un error 404
        LogAccion::create([
            'usuario_rut' => Auth::user()->rut,
            'accion' => "Error 404",
            'detalle' => "El usuario quiso ingresar a una página que no funciona o no existe.",
        ]);

        return view('errors.404');
    }
    
    public function error503()
    {
        $mensaje = \Request::get('mensaje');

        $timeZone = 'America/Santiago'; 
        date_default_timezone_set($timeZone);      

        $logError               =   new LogErrores;
        $logError->usuario_rut      =   Auth::user()->rut;
        $logError->tipo_error   =   'Error 503';
        $logError->detalle      =   'Ocurrió un error en el servidor.';
        $logError->mensaje      =   $mensaje;
        $logError->created_at    =   date_create();
        $logError->save();
        #Guarda log al producirse un error 503
        LogAccion::create([
            'usuario_rut' => Auth::user()->rut,
            'accion' => "Error 503",
            'detalle' => "Hay un problema con el servidor.",
        ]);

        return view('errors.404');
    }

    public function errorSql()
    {
        $mensaje = \Request::get('mensaje');

        $timeZone = 'America/Santiago'; 
        date_default_timezone_set($timeZone);

        $logError               =   new LogErrores;
        $logError->usuario_rut      =   Auth::user()->rut;
        $logError->tipo_error   =   'Error SQL';
        $logError->detalle      =   'Ocurrió un error de base de datos.';
        $logError->mensaje      =   $mensaje;
        $logError->created_at    =   date_create();
        $logError->save();
        #Guarda log al producirse un error sql
        LogAccion::create([
            'usuario_rut' => Auth::user()->rut,
            'accion' => "Error SQL",
            'detalle' => "El usuario ingresó un valor no valido para la base de datos.",
        ]);

        return view('errors.404');
    }    

}