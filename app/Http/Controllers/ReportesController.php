<?php

namespace App\Http\Controllers;

use App\LogAccion;
use Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use App\Atencion;
use App\Paciente;
use App\Profesional;
use App\Sucursal;
use App\Pago;
use App\TipoPago;
use App\Usuario;

class ReportesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ReporteAtencionPeriodo()
    {
        #Se obtiene día, mes y año actual
        $year = date_format(date_create('America/Santiago'), 'Y');
        $mes  = date_format(date_create('America/Santiago'), 'm');
        $dia  = date_format(date_create('America/Santiago'), 'd');
        #Si la suma del mes actual más 1 da 13, comenzamos en Enero
        if (($mes + 1) == 13) {
            $mes_inicio = 1;
        } else {
            $mes_inicio = $mes + 1;
        }
        #Lo obtenido anteriormente se concatena para crear la fecha inicio y fecha fin
        $fecha_inicio = ($year - 1).'-'.$mes_inicio.'-01';
        $fecha_fin    = $year.'-'.$mes.'-'.$dia.' 23:59:59';
        #Se aplica el respectivo formato
        $fecha_inicio = date_format(date_create($fecha_inicio),'d/m/Y');
        $fecha_fin    = date_format(date_create($fecha_fin),'d/m/Y');


        return view('reportes.atencionperiodo')
                    ->with('fecha_inicio', $fecha_inicio)
                    ->with('fecha_fin', $fecha_fin);
    }

    public function getAtencionPeriodo(Request $request)
    {
        #Se consulta si se desea listar o exportar a excel
        if ($request->input('tipo') == 'excel') {
            $fecha_inicio = $request->input('desdeExcel');
            $fecha_fin    = $request->input('hastaExcel');
        } else {
            $fecha_inicio = $request->input('fechadesde');
            $fecha_fin    = $request->input('fechahasta');
        }

        $fecha_inicio = str_replace('/', '-', $fecha_inicio);
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_inicio = $fecha_inicio.' 0:0:0';
        $fecha_fin    = str_replace('/', '-', $fecha_fin);
        $fecha_fin    = date('Y-m-d', strtotime($fecha_fin));
        $fecha_fin    = $fecha_fin.' 23:59:59';
        #Se obtienen las atenciones que cumplan con el filtro de búsqueda
        $atenciones = Atencion::select(DB::raw('YEAR(atenciones.fecha) As year'), DB::raw('MONTH(atenciones.fecha) As mes'), DB::raw('COUNT(atenciones.id) AS atenciones'))
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                    ->groupBy(DB::raw('YEAR(atenciones.fecha)'), DB::raw('MONTH(atenciones.fecha)'))
                    ->orderBy(DB::raw('YEAR(atenciones.fecha)'), 'desc')
                    ->orderBy(DB::raw('MONTH(atenciones.fecha)'), 'desc')
                    ->get();
        #Si la entrada es de tipo gráfico, enviamos datos
        if ($request->input('tipo') == 'grafico') {
            $atencionpormes = [];
            foreach ($atenciones as $atencion) {
                $atencionpormes[$atencion->year][$atencion->mes] = $atencion->atenciones;
            }
        }else{
            #En caso contrario, asignamos a cada valor un nombre, que será el mes
            foreach ($atenciones as $atencion) {
                if ($atencion->mes == '1') {
                    $atencion->mes = 'Enero';
                }else if ($atencion->mes == '2') {
                    $atencion->mes = 'Febrero';
                }else if ($atencion->mes == '3') {
                    $atencion->mes = 'Marzo';
                }else if ($atencion->mes == '4') {
                    $atencion->mes = 'Abril';
                }else if ($atencion->mes == '5') {
                    $atencion->mes = 'Mayo';
                }else if ($atencion->mes == '6') {
                    $atencion->mes = 'Junio';
                }else if ($atencion->mes == '7') {
                    $atencion->mes = 'Julio';
                }else if ($atencion->mes == '8') {
                    $atencion->mes = 'Agosto';
                }else if ($atencion->mes == '9') {
                    $atencion->mes = 'Septiembre';
                }else if ($atencion->mes == '10') {
                    $atencion->mes = 'Octubre';
                }else if ($atencion->mes == '11') {
                    $atencion->mes = 'Noviembre';
                }else if ($atencion->mes == '12') {
                    $atencion->mes = 'Diciembre';
                }
            }
        }
        #A partir de acá tendrá diferente comportamiento según el contenido de la  entrada
        if ($request->input('tipo') == 'table') {
            #Genera tabla
            return Datatables::of($atenciones)->make(true);
        }

        if ($request->input('tipo') == 'grafico') {
            #Envía información para generar el gráfico
            return  response()->json(['atencionpormes' => json_encode($atencionpormes)]);
        }

        if ($request->input('tipo') == 'excel') {
            #Genera archivo Excel
            return Excel::create('AtencionPeriodo', function($excel) use ($atenciones) {
                $excel->sheet('Atenciones', function($sheet) use ($atenciones){
                    $count = 2;                 
                    $sheet->row(1, ['Mes', 'Año', 'Número de atenciones']);
                    $sheet->cells('A1:C1', function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    foreach ($atenciones as $key => $value) {
                        $sheet->row($count, [$value->mes, $value->year, $value->atenciones]);
                        $count = $count +1;
                    }
                });
            })->download('xlsx');  
        }
    }

    public function ReporteAtencionSucursal()
    {
        #Se obtienen las sucursales
        $sucursalB  = \Request::get('sucursalB');
        $sucursales = Sucursal::select('id', 'nombre')->orderBy('nombre','asc')->pluck('nombre', 'id');
        #Se obtiene el año, el mes y el día actual
        $year = date_format(date_create('America/Santiago'), 'Y');
        $mes  = date_format(date_create('America/Santiago'), 'm');
        $dia  = date_format(date_create('America/Santiago'), 'd');
        #Si la suma del mes más 1 da 13, comenzamos en Enero
        if (($mes + 1) == 13) {
            $mes_inicio = 1;
        } else {
            $mes_inicio = $mes + 1;
        }
        #Lo obtenido anteriormente se concatena para crear la fecha inicio y fecha fin
        $fecha_inicio = ($year - 1).'-'.$mes_inicio.'-01';
        $fecha_fin    = $year.'-'.$mes.'-'.$dia.' 23:59:59';
        $fecha_inicio = date_format(date_create($fecha_inicio),'d/m/Y');
        $fecha_fin    = date_format(date_create($fecha_fin),'d/m/Y');

        return view('reportes.atencionsucursal')
                    ->with('fecha_inicio', $fecha_inicio)
                    ->with('fecha_fin', $fecha_fin)
                    ->with('sucursalB', $sucursalB)
                    ->with('sucursales',$sucursales);
    }

    public function getAtencionSucursal(Request $request)
    { 
        if ($request->input('tipo') == 'excel') {
            $fecha_inicio = $request->input('desdeExcel');
            $fecha_fin    = $request->input('hastaExcel');
            $sucursal     = json_decode($request->input('sucursalExcel'));
        }else{
            $fecha_inicio = $request->input('fechadesde');
            $fecha_fin    = $request->input('fechahasta');
            $sucursal     = $request->input('sucursal');
        }

        $fecha_inicio = str_replace('/', '-', $fecha_inicio);
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_inicio = $fecha_inicio.' 0:0:0';

        $fecha_fin = str_replace('/', '-', $fecha_fin);
        $fecha_fin = date('Y-m-d', strtotime($fecha_fin));
        $fecha_fin = $fecha_fin.' 23:59:59';
        //Se obtienen todas las atenciones que coincidan con el filtro de búsqueda
        $atenciones = Atencion::select('sucursales.nombre As sucursal', DB::raw('COUNT(atenciones.id) AS atenciones'))
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);

        if (!empty($sucursal)) {
            $atenciones = $atenciones->whereIn('sucursal_id', $sucursal); 
        }

        $atenciones = $atenciones
                    ->join('sucursales','sucursales.id','=','sucursal_id')
                    ->groupBy('sucursales.nombre')
                    ->get();

        if ($request->input('tipo') == 'table') {
            #Se genera el listado de atenciones
            return Datatables::of($atenciones)->make(true);
        }

        if ($request->input('tipo') == 'grafico') {
            #Se envía información para generar gráfico
            $sucursales = [];

            foreach ($atenciones as $atencion) {
                $sucursales[$atencion->sucursal] = $atencion->atenciones;
            }

            return  response()->json(['sucursales' => json_encode($sucursales)]);
        }

        if ($request->input('tipo') == 'excel') {
            #Se genera archivo Excel
            return Excel::create('AtencionSucursal', function($excel) use ($atenciones) {
                $excel->sheet('Atenciones', function($sheet) use ($atenciones)
                {
                    $count = 2;
                    $sheet->row(1, ['Sucursal', 'Número de atenciones']);
                    $sheet->cells('A1:B1', function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    foreach ($atenciones as $key => $value) {
                        $sheet->row($count, [$value->sucursal, $value->atenciones]);
                        $count = $count +1;
                    }
                });
            })->download('xlsx');  
        }
    }

    public function ReporteAtencionProfesional()
    {
        $profesionalB  = \Request::get('profesionalB');
        $profesionales = Profesional::select('profesionales.rut',  DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As nombre_profesional"))->orderBy('profesionales.nombres', 'asc')->pluck('nombre_profesional', 'rut');
        #Se obtiene el año, el mes y el día de hoy
        $year   =   date_format(date_create('America/Santiago'), 'Y');
        $mes    =   date_format(date_create('America/Santiago'), 'm');
        $dia    =   date_format(date_create('America/Santiago'), 'd');
        #Si la suma del mes más 1 da 13, comenzamos en Enero
        if (($mes + 1) == 13) {
            $mes_inicio = 1;
        } else {
            $mes_inicio = $mes + 1;
        }
        #Lo obtenido anteriormente se concatena para crear la fecha inicio y fecha fin
        $fecha_inicio = ($year - 1).'-'.$mes_inicio.'-01';
        $fecha_fin    = $year.'-'.$mes.'-'.$dia.' 23:59:59';

        $fecha_inicio = date_format(date_create($fecha_inicio),'d/m/Y');
        $fecha_fin    = date_format(date_create($fecha_fin),'d/m/Y');

        return view('reportes.atencionprofesional')
                    ->with('fecha_inicio', $fecha_inicio)
                    ->with('fecha_fin', $fecha_fin)
                    ->with('profesionalB', $profesionalB)
                    ->with('profesionales', $profesionales);
    }

    public function getAtencionProfesional(Request $request)
    {
        if ($request->input('tipo') == 'excel') {
            $fecha_inicio = $request->input('desdeExcel');
            $fecha_fin    = $request->input('hastaExcel');
            $profesional  = json_decode($request->input('profesionalExcel'));
        }else{
            $fecha_inicio = $request->input('fechadesde');
            $fecha_fin    = $request->input('fechahasta');
            $profesional  = $request->input('profesional');
        }

        $fecha_inicio = str_replace('/', '-', $fecha_inicio);
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_inicio = $fecha_inicio.' 0:0:0';

        $fecha_fin = str_replace('/', '-', $fecha_fin);
        $fecha_fin = date('Y-m-d', strtotime($fecha_fin));
        $fecha_fin = $fecha_fin.' 23:59:59';
        #Se obtienen todas las atenciones que coincidan con el filtro de búsqueda
        $atenciones = Atencion::select(DB::raw("CONCAT(profesionales.nombres,' ',profesionales.apellido_paterno,' ',profesionales.apellido_materno) As profesional"), DB::raw('COUNT(atenciones.id) AS atenciones'))
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);

        if (!empty($profesional)) {
            $atenciones = $atenciones->whereIn('profesional_rut', $profesional); 
        }

        $atenciones = $atenciones
                    ->join('profesionales','profesionales.rut','=','profesional_rut')
                    ->groupBy('profesional')
                    ->get();

        if ($request->input('tipo') == 'table') {
            #Se genera tabla
            return Datatables::of($atenciones)->make(true);
        }

        if ($request->input('tipo') == 'grafico') {
            #Se envía información para generar gráfico
            $profesionales = [];

            foreach ($atenciones as $atencion) {
                $profesionales[$atencion->profesional] = $atencion->atenciones;
            }

            return  response()->json(['profesionales' => json_encode($profesionales)]);
        }

        if ($request->input('tipo') == 'excel') {
            #Se genera archivo Excel
            return Excel::create('AtencionProfesional', function($excel) use ($atenciones) {
                $excel->sheet('Atenciones', function($sheet) use ($atenciones)
                {
                    $count = 2;
                    $sheet->row(1, ['Profesional', 'Número de atenciones']);
                    $sheet->cells('A1:B1', function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    foreach ($atenciones as $key => $value) {
                        $sheet->row($count, [$value->profesional, $value->atenciones]);
                        $count = $count +1;
                    }
                });
            })->download('xlsx');
        }
    }

    public function ReporteAtencionSecretaria()
    {
        $secretariaB  = \Request::get('secretariaB');
        $secretarias  = Usuario::select('usuarios.rut',
                            DB::raw("CONCAT(usuarios.nombres, ' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno) As nombre_usuario"))
                                    ->where('usuarios.perfil_id', '=', 3)
                                    ->orderBy('usuarios.nombres', 'asc')
                                    ->pluck('nombre_usuario', 'rut');

        #Se obtiene el año, el mes y el día de hoy
        $year   =   date_format(date_create('America/Santiago'), 'Y');
        $mes    =   date_format(date_create('America/Santiago'), 'm');
        $dia    =   date_format(date_create('America/Santiago'), 'd');
        #Si la suma del mes más 1 da 13, comenzamos en Enero
        if (($mes + 1) == 13) {
            $mes_inicio = 1;
        } else {
            $mes_inicio = $mes + 1;
        }
        #Lo obtenido anteriormente se concatena para crear la fecha inicio y fecha fin
        $fecha_inicio = ($year - 1).'-'.$mes_inicio.'-01';
        $fecha_fin    = $year.'-'.$mes.'-'.$dia.' 23:59:59';

        $fecha_inicio = date_format(date_create($fecha_inicio),'d/m/Y');
        $fecha_fin    = date_format(date_create($fecha_fin),'d/m/Y');

        return view('reportes.atencionsecretaria')
                    ->with('fecha_inicio', $fecha_inicio)
                    ->with('fecha_fin', $fecha_fin)
                    ->with('secretariaB', $secretariaB)
                    ->with('secretarias', $secretarias);
    }

    public function getAtencionSecretaria(Request $request)
    {
        if ($request->input('tipo') == 'excel') {
            $fecha_inicio = $request->input('desdeExcel');
            $fecha_fin    = $request->input('hastaExcel');
            $secretaria   = json_decode($request->input('secretariaExcel'));
        }else{
            $fecha_inicio = $request->input('fechadesde');
            $fecha_fin    = $request->input('fechahasta');
            $secretaria   = $request->input('secretaria');
        }

        $fecha_inicio = str_replace('/', '-', $fecha_inicio);
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_inicio = $fecha_inicio.' 0:0:0';

        $fecha_fin = str_replace('/', '-', $fecha_fin);
        $fecha_fin = date('Y-m-d', strtotime($fecha_fin));
        $fecha_fin = $fecha_fin.' 23:59:59';
        #Se obtienen todas las atenciones que coincidan con el filtro de búsqueda
        $atenciones = Atencion::select(
                                        DB::raw("CONCAT(usuarios.nombres,' ',usuarios.apellido_paterno,' ',usuarios.apellido_materno) As secretaria"),
                                        DB::raw('COUNT(atenciones.id) AS atenciones')
                                        )
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);

        if (!empty($secretaria)) {
            $atenciones = $atenciones->whereIn('usuario_rut', $secretaria); 
        }

        $atenciones = $atenciones
                    ->where('usuarios.perfil_id', '=', 3)
                    ->rightjoin('usuarios','usuarios.rut','=','usuario_rut')
                    ->groupBy('secretaria')
                    ->get();

        if ($request->input('tipo') == 'table') {
            #Se genera tabla
            return Datatables::of($atenciones)->make(true);
        }

        if ($request->input('tipo') == 'grafico') {
            #Se envía información para generar gráfico
            $secretarias = [];

            foreach ($atenciones as $atencion) {
                $secretarias[$atencion->secretaria] = $atencion->atenciones;
            }

            return  response()->json(['secretarias' => json_encode($secretarias)]);
        }

        if ($request->input('tipo') == 'excel') {
            #Se genera archivo Excel
            return Excel::create('AtencionSecretaria', function($excel) use ($atenciones) {
                $excel->sheet('Atenciones', function($sheet) use ($atenciones)
                {
                    $count = 2;
                    $sheet->row(1, ['Secretaria', 'Número de atenciones']);
                    $sheet->cells('A1:B1', function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    foreach ($atenciones as $key => $value) {
                        $sheet->row($count, [$value->secretaria, $value->atenciones]);
                        $count = $count +1;
                    }
                });
            })->download('xlsx');
        }
    }

    
    public function ReporteAtencionPaciente()
    {

            #Se obtiene el año, el mes y el día de hoy
            $year   =   date_format(date_create('America/Santiago'), 'Y');
            $mes    =   date_format(date_create('America/Santiago'), 'm');
            $dia    =   date_format(date_create('America/Santiago'), 'd');
            #Si la suma del mes más 1 da 13, comenzamos en Enero
            if (($mes + 1) == 13) {
                $mes_inicio = 1;
            } else {
                $mes_inicio = $mes + 1;
            }
            #Lo obtenido anteriormente se concatena para crear la fecha inicio y fecha fin
            $fecha_inicio = ($year - 1).'-'.$mes_inicio.'-01';
            $fecha_fin    = $year.'-'.$mes.'-'.$dia.' 23:59:59';
    
            $fecha_inicio = date_format(date_create($fecha_inicio),'d/m/Y');
            $fecha_fin    = date_format(date_create($fecha_fin),'d/m/Y');
    
            return view('reportes.atencionpaciente')
                        ->with('fecha_inicio', $fecha_inicio)
                        ->with('fecha_fin', $fecha_fin);
    }

    public function getAtencionPaciente(Request $request)
    {
        
        if ($request->input('tipo') == 'excel') {
            $fecha_inicio = $request->input('desdeExcel');
            $fecha_fin    = $request->input('hastaExcel');
            $paciente     = json_decode($request->input('pacienteExcel'));
        }else{
            $fecha_inicio = $request->input('fechadesde');
            $fecha_fin    = $request->input('fechahasta');
            $paciente     = $request->input('paciente');
        }

        $fecha_inicio = str_replace('/', '-', $fecha_inicio);
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_inicio = $fecha_inicio.' 0:0:0';

        $fecha_fin = str_replace('/', '-', $fecha_fin);
        $fecha_fin = date('Y-m-d', strtotime($fecha_fin));
        $fecha_fin = $fecha_fin.' 23:59:59';

        #Se obtienen todas las atenciones que coincidan con el filtro de búsqueda

        
        
        $atenciones =   Atencion::select(
                                            DB::raw('CONCAT(pacientes.rut, "-", pacientes.dv) As rut_paciente'),
                                            DB::raw('CONCAT(pacientes.nombres, " ", pacientes.apellido_paterno, " ", pacientes.apellido_materno) As paciente'),
                                            DB::raw('COUNT(atenciones.id) As atenciones_realizadas')
                                        )
                                ->join('tratamientos',  'atenciones.tratamiento_folio', '=', 'tratamientos.folio')
                                ->join('pacientes',     'tratamientos.paciente_rut',    '=', 'pacientes.rut')
                                ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);

        if (!empty($paciente)) {
            $atenciones = $atenciones->whereIn('pacientes.rut', $paciente); 
        }

        $atenciones = $atenciones
                    ->whereNotNull('atenciones.abono')
                    ->groupBy('rut_paciente', 'paciente')
                    ->orderBy('atenciones_realizadas', 'DESC')
                    ->orderBy('pacientes.rut')
                    ->get();


        if ($request->input('tipo') == 'table') {
            #Se genera tabla
            return Datatables::of($atenciones)->make(true);
        }

        if ($request->input('tipo') == 'excel') {
            #Se genera archivo Excel
            return Excel::create('AtencionPaciente', function($excel) use ($atenciones) {
                $excel->sheet('Atenciones', function($sheet) use ($atenciones)
                {
                    $count = 2;
                    $sheet->row(1, ['Paciente', 'Número de atenciones']);
                    $sheet->cells('A1:B1', function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    foreach ($atenciones as $value) {
                        $sheet->row($count, [$value->paciente, $value->atenciones_realizadas]);
                        $count = $count +1;
                    }
                });
            })->download('xlsx');
        }
    }

    public function ReporteIngresoPeriodo()
    {

        #Se obtiene año, mes y día de hoy
        $year = date_format(date_create('America/Santiago'), 'Y');
        $mes  = date_format(date_create('America/Santiago'), 'm');
        $dia  = date_format(date_create('America/Santiago'), 'd');
        
        #Si la suma del mes más 1 da 13, comenzamos en Enero
        if (($mes + 1) == 13) {
            $mes_inicio = 1;
        } else {
            $mes_inicio = $mes + 1;
        }

        $tipopago     = TipoPago::get();

        #Lo obtenido anteriormente se concatena para crear la fecha inicio y fecha fin
        $fecha_inicio =   ($year - 1).'-'.$mes_inicio.'-01';
        $fecha_fin    =   $year.'-'.$mes.'-'.$dia.' 23:59:59';

        $fecha_inicio = date_format(date_create($fecha_inicio),'d/m/Y');
        $fecha_fin    = date_format(date_create($fecha_fin),'d/m/Y');

        return view('reportes.ingresoperiodo')
                    ->with('tipopago', $tipopago)
                    ->with('fecha_inicio', $fecha_inicio)
                    ->with('fecha_fin', $fecha_fin);
    }

    public function getIngresoPeriodo(Request $request)
    {    
        if ($request->input('tipo') == 'excel') {
            $fecha_inicio = $request->input('desdeExcel');
            $fecha_fin    = $request->input('hastaExcel');
        }else{
            $fecha_inicio = $request->input('fechadesde');
            $fecha_fin    = $request->input('fechahasta');
        }

        $fecha_inicio = str_replace('/', '-', $fecha_inicio);
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_inicio = $fecha_inicio.' 0:0:0';

        $fecha_fin = str_replace('/', '-', $fecha_fin);
        $fecha_fin = date('Y-m-d', strtotime($fecha_fin));
        $fecha_fin = $fecha_fin.' 23:59:59';
        #Se obtienen todas las atenciones que coincidan con el filtro de búsqueda
        $atenciones = Atencion::select(DB::raw('YEAR(atenciones.fecha) As year'), DB::raw('MONTH(atenciones.fecha) As mes'), DB::raw('sum(atenciones.abono) AS ingreso'))
                                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin])
                                    ->groupBy(DB::raw('YEAR(atenciones.fecha)'), DB::raw('MONTH(atenciones.fecha)'))
                                    ->orderBy(DB::raw('YEAR(atenciones.fecha)'), 'desc')
                                    ->orderBy(DB::raw('MONTH(atenciones.fecha)'), 'desc')
                                    ->get();

        if ($request->input('tipo') == 'grafico') {
            $ingresopormes = [];

            foreach ($atenciones as $atencion) {
                $ingresopormes[$atencion->year][$atencion->mes] = $atencion->ingreso;
            }
        }else{
            foreach ($atenciones as $atencion) {
                if ($atencion->mes == '1') {
                    $atencion->mes = 'Enero';
                    $atencion->mes_num = 1;
                }else if ($atencion->mes == '2') {
                    $atencion->mes = 'Febrero';
                    $atencion->mes_num = 2;
                }else if ($atencion->mes == '3') {
                    $atencion->mes = 'Marzo';
                    $atencion->mes_num = 3;
                }else if ($atencion->mes == '4') {
                    $atencion->mes = 'Abril';
                    $atencion->mes_num = 4;
                }else if ($atencion->mes == '5') {
                    $atencion->mes = 'Mayo';
                    $atencion->mes_num = 5;
                }else if ($atencion->mes == '6') {
                    $atencion->mes = 'Junio';
                    $atencion->mes_num = 6;
                }else if ($atencion->mes == '7') {
                    $atencion->mes = 'Julio';
                    $atencion->mes_num = 7;
                }else if ($atencion->mes == '8') {
                    $atencion->mes = 'Agosto';
                    $atencion->mes_num = 8;
                }else if ($atencion->mes == '9') {
                    $atencion->mes = 'Septiembre';
                    $atencion->mes_num = 9;
                }else if ($atencion->mes == '10') {
                    $atencion->mes = 'Octubre';
                    $atencion->mes_num = 10;
                }else if ($atencion->mes == '11') {
                    $atencion->mes = 'Noviembre';
                    $atencion->mes_num = 11;
                }else if ($atencion->mes == '12') {
                    $atencion->mes = 'Diciembre';
                    $atencion->mes_num = 12;
                }
            }
        }

        $tipopago     = TipoPago::get();

        foreach ($atenciones as $atencion) {
            foreach ($tipopago as $pago) {
                $nombre_pago                    =   'tipo_pago_'.$pago->id;
                $cantidad_pago                  =   'cantidad_pago_'.$pago->id;
                $pago_atencion                  =   Pago::select(DB::raw('SUM(monto) As monto'))
                                                            ->join('atenciones', 'pagos.atenciones_id', '=', 'atenciones.id')
                                                            ->where('tipo_pago_id', '=', $pago->id)
                                                            ->whereBetween('atenciones.fecha', [$fecha_inicio, $fecha_fin])
                                                            ->whereMonth('atenciones.fecha', $atencion->mes_num)
                                                            ->whereYear('atenciones.fecha', $atencion->year)
                                                            ->groupBy('tipo_pago_id')->first();

                if (empty($pago_atencion)) {
                    $atencion->$nombre_pago         =  '$ 0';
                    $atencion->$cantidad_pago       =  0;
                }else{
                    $atencion->$nombre_pago         =  '$ '.number_format($pago_atencion->monto, 0, '', '.');
                    $atencion->$cantidad_pago       = $pago_atencion->monto;
                }
            }
        }

        if($request->input('tipo') == 'table'){
            #Se genera tabla
            foreach ($atenciones as $key => $atencion) {
                $atencion->ingreso = '$ '.number_format($atencion->ingreso, 0, '', '.');
            }
            return Datatables::of($atenciones)->make(true);
        }

        if ($request->input('tipo') == 'grafico') {
            #Se envían datos para generar gráfico
            return  response()->json(['ingresopormes' => json_encode($ingresopormes)]);
        }


        if ($request->input('tipo') == 'excel') {
            #Se genera archivo Excel
            return Excel::create('IngresoPeriodo', function($excel) use ($atenciones, $tipopago) {
                $excel->sheet('Ingresos', function($sheet) use ($atenciones, $tipopago)
                {
                    $count = 2;      
                    $sheet->setColumnFormat(array(
                        'C' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                    ));
                    $cabecera = ['Mes', 'Año', 'Ingreso'];
                    foreach ($tipopago as $pago) {
                        array_push($cabecera, $pago->nombre);
                    }

                    $sheet->row(1, $cabecera);
                    $sheet->cells('1', function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    foreach ($atenciones as $key => $value) {
                        $fila  =  [$value->mes, $value->year, $value->ingreso];
                        foreach ($tipopago as $pago) {
                            $cantidad_pago                  =   'cantidad_pago_'.$pago->id;
                            array_push($fila, $value->$cantidad_pago);
                        }
                        $sheet->row($count, $fila);
                        $count = $count +1;
                    }
                });
            })->download('xlsx'); 
        }
    }


    public function ReporteIngresoSucursal()
    {
        $sucursalB  = \Request::get('sucursalB');
        $sucursales = Sucursal::select('id', 'nombre')->get()->pluck('nombre', 'id');
        #Se obtiene año, mes y día actual
        $year = date_format(date_create('America/Santiago'), 'Y');
        $mes  = date_format(date_create('America/Santiago'), 'm');
        $dia  = date_format(date_create('America/Santiago'), 'd');

        if (($mes + 1) == 13) {
            $mes_inicio = 1;
        } else {
            $mes_inicio = $mes + 1;
        }
        #Lo obtenido anteriormente se concatena para crear la fecha inicio y fecha fin
        $fecha_inicio = ($year - 1).'-'.$mes_inicio.'-01';
        $fecha_fin    = $year.'-'.$mes.'-'.$dia.' 23:59:59';

        $fecha_inicio = date_format(date_create($fecha_inicio),'d/m/Y');
        $fecha_fin    = date_format(date_create($fecha_fin),'d/m/Y');

        $tipopago     = TipoPago::get();

        return view('reportes.ingresosucursal')
                    ->with('fecha_inicio', $fecha_inicio)
                    ->with('tipopago', $tipopago)
                    ->with('fecha_fin', $fecha_fin)
                    ->with('sucursalB', $sucursalB)
                    ->with('sucursales',$sucursales);
    }

    public function getIngresoSucursal(Request $request)
    {
        if ($request->input('tipo') == 'excel') {
            $fecha_inicio = $request->input('desdeExcel');
            $fecha_fin    = $request->input('hastaExcel');
            $sucursal     = json_decode($request->input('sucursalExcel'));
        }else{
            $fecha_inicio = $request->input('fechadesde');
            $fecha_fin    = $request->input('fechahasta');
            $sucursal     = $request->input('sucursal');
        }

        $fecha_inicio = str_replace('/', '-', $fecha_inicio);
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_inicio = $fecha_inicio.' 0:0:0';

        $fecha_fin = str_replace('/', '-', $fecha_fin);
        $fecha_fin = date('Y-m-d', strtotime($fecha_fin));
        $fecha_fin = $fecha_fin.' 23:59:59';
        #Se obtienen todas las atenciones que cumplan con el filtro de búsqueda
        $atenciones = Atencion::select('sucursales.id As sucursal_id', 'sucursales.nombre As sucursal', DB::raw('SUM(atenciones.abono) As ingreso'))
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);

        if (!empty($sucursal)) {
            $atenciones = $atenciones->whereIn('sucursal_id', $sucursal); 
        }

        $atenciones = $atenciones
                    ->join('sucursales','sucursales.id','=','sucursal_id')
                    ->groupBy('sucursales.id', 'sucursales.nombre')
                    ->get();

        $tipopago     = TipoPago::get();

        foreach ($atenciones as $atencion) {
            foreach ($tipopago as $pago) {
                $nombre_pago                    =   'tipo_pago_'.$pago->id;
                $cantidad_pago                  =   'cantidad_pago_'.$pago->id;
                $pago_atencion                  =   Pago::select(DB::raw('SUM(monto) As monto'))
                                                            ->join('atenciones', 'pagos.atenciones_id', '=', 'atenciones.id')
                                                            ->where('tipo_pago_id', '=', $pago->id)
                                                            ->whereBetween('atenciones.fecha', [$fecha_inicio, $fecha_fin])
                                                            ->where('atenciones.sucursal_id', '=', $atencion->sucursal_id)
                                                            ->groupBy('tipo_pago_id')->first();

                if (empty($pago_atencion)) {
                    $atencion->$nombre_pago         =  '$ 0';
                    $atencion->$cantidad_pago       =  0;
                }else{
                    $atencion->$nombre_pago         =  '$ '.number_format($pago_atencion->monto, 0, '', '.');
                    $atencion->$cantidad_pago       = $pago_atencion->monto;
                }
            }
        }

        if ($request->input('tipo') == 'table') {
            #Se genera tabla
            foreach ($atenciones as $atencion){
                $atencion->ingreso = '$ '.number_format($atencion->ingreso, 0, '', '.');
            }

            return Datatables::of($atenciones)->make(true);
        }

        if ($request->input('tipo') == 'grafico') {
            #Se envía información para generar gráfico
            $sucursales = [];

            foreach ($atenciones as $atencion) {
                $sucursales[$atencion->sucursal] = $atencion->ingreso;
            }

            return  response()->json(['sucursales' => json_encode($sucursales)]);
        }

        if ($request->input('tipo') == 'excel') {
            #Se genera Excel
            return Excel::create('IngresoSucursal', function($excel) use ($atenciones, $tipopago) {
                $excel->sheet('Atenciones', function($sheet) use ($atenciones, $tipopago)
                {
                    $count = 2;    
                    $sheet->setColumnFormat(array(
                        'B' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                    ));
                    $cabecera = ['Sucursal', 'Ingreso'];
                    foreach ($tipopago as $pago) {
                        array_push($cabecera, $pago->nombre);
                    }

                    $sheet->row(1, $cabecera);
                    $sheet->cells('1', function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    foreach ($atenciones as $key => $value) {
                        $fila  =  [$value->sucursal, $value->ingreso];
                        foreach ($tipopago as $pago) {
                            $cantidad_pago                  =   'cantidad_pago_'.$pago->id;
                            array_push($fila, $value->$cantidad_pago);
                        }
                        $sheet->row($count, $fila);
                        $count = $count +1;
                    }
                });
            })->download('xlsx'); 
        }
    }

    public function ReporteIngresoProfesional()
    {
        $profesionalB  = \Request::get('profesionalB');
        $profesionales = Profesional::select('profesionales.rut',  DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As nombre_profesional"))
                        ->get();

        $profesionales = $profesionales->pluck('nombre_profesional', 'rut');
        #Se obtiene año, mes y día actual
        $year = date_format(date_create('America/Santiago'), 'Y');
        $mes  = date_format(date_create('America/Santiago'), 'm');
        $dia  = date_format(date_create('America/Santiago'), 'd');

        if (($mes + 1) == 13) {
            $mes_inicio = 1;
        } else {
            $mes_inicio = $mes + 1;
        }
        #Lo obtenido anteriormente se concatena para crear la fecha inicio y fecha fin
        $fecha_inicio = ($year - 1).'-'.$mes_inicio.'-01';
        $fecha_fin    = $year.'-'.$mes.'-'.$dia.' 23:59:59';

        $fecha_inicio = date_format(date_create($fecha_inicio),'d/m/Y');
        $fecha_fin    = date_format(date_create($fecha_fin),'d/m/Y');

        return view('reportes.ingresoprofesional')
                    ->with('fecha_inicio', $fecha_inicio)
                    ->with('fecha_fin', $fecha_fin)
                    ->with('profesionalB', $profesionalB)
                    ->with('profesionales', $profesionales);
    }

    public function getIngresoProfesional(Request $request)
    {
        if ($request->input('tipo') == 'excel') {
            $fecha_inicio = $request->input('desdeExcel');
            $fecha_fin    = $request->input('hastaExcel');
            $profesional  = json_decode($request->input('profesionalExcel'));
        }else{
            $fecha_inicio = $request->input('fechadesde');
            $fecha_fin    = $request->input('fechahasta');
            $profesional  = $request->input('profesional');
        }

        $fecha_inicio = str_replace('/', '-', $fecha_inicio);
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_inicio = $fecha_inicio.' 0:0:0';

        $fecha_fin = str_replace('/', '-', $fecha_fin);
        $fecha_fin = date('Y-m-d', strtotime($fecha_fin));
        $fecha_fin = $fecha_fin.' 23:59:59';
        #Se obtienen todos las atenciones que cumplan con los filtros de búsqueda
        $atenciones = Atencion::select(DB::raw("CONCAT(profesionales.nombres,' ',profesionales.apellido_paterno,' ',profesionales.apellido_materno) As profesional"), DB::raw('SUM(atenciones.abono) AS ingreso'))
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);

        if (!empty($profesional)) {
            $atenciones = $atenciones->whereIn('profesional_rut', $profesional); 
        }

        $atenciones = $atenciones
                    ->join('profesionales','profesionales.rut','=','profesional_rut')
                    ->groupBy('profesional')
                    ->get();

        if ($request->input('tipo') == 'table') {
            #Se genera tabla
            foreach ($atenciones as $atencion){
                $atencion->ingreso = '$ '.number_format($atencion->ingreso, 0, '', '.');
            }

            return Datatables::of($atenciones)->make(true);
        }

        if ($request->input('tipo') == 'grafico') {
            #Se envía información para generar gráfico
            $profesionales = [];

            foreach ($atenciones as $atencion) {
                $profesionales[$atencion->profesional] = $atencion->ingreso;
            }

            return  response()->json(['profesionales' => json_encode($profesionales)]);
        }

        if ($request->input('tipo') == 'excel') {
            #Se genera archivo Excel
            return Excel::create('IngresoProfesional', function($excel) use ($atenciones) {
                $excel->sheet('Atenciones', function($sheet) use ($atenciones)
                {
                    $count = 2;         
                    $sheet->setColumnFormat(array(
                        'B' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                    ));
                    $sheet->row(1, ['Profesional', 'Ingreso']);
                    $sheet->cells('A1:B1', function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    foreach ($atenciones as $key => $value) {
                        $sheet->row($count, [$value->profesional, $value->ingreso]);
                        $count = $count +1;
                    }
                });
            })->download('xlsx');
        }
    }

    public function ReporteIngresoSecretaria()
    {
        $secretariaB  = \Request::get('secretariaB');
        $secretarias   =  Usuario::select('usuarios.rut',
                            DB::raw("CONCAT(usuarios.nombres, ' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno) As nombre_usuario"))
                                    ->where('usuarios.perfil_id', '=', 3)
                                    ->orderBy('usuarios.nombres', 'asc')
                                    ->pluck('nombre_usuario', 'rut');

        $secretarias = $secretarias->pluck('nombre_secretaria', 'rut');
        #Se obtiene año, mes y día actual
        $year = date_format(date_create('America/Santiago'), 'Y');
        $mes  = date_format(date_create('America/Santiago'), 'm');
        $dia  = date_format(date_create('America/Santiago'), 'd');

        if (($mes + 1) == 13) {
            $mes_inicio = 1;
        } else {
            $mes_inicio = $mes + 1;
        }
        #Lo obtenido anteriormente se concatena para crear la fecha inicio y fecha fin
        $fecha_inicio = ($year - 1).'-'.$mes_inicio.'-01';
        $fecha_fin    = $year.'-'.$mes.'-'.$dia.' 23:59:59';

        $fecha_inicio = date_format(date_create($fecha_inicio),'d/m/Y');
        $fecha_fin    = date_format(date_create($fecha_fin),'d/m/Y');

        return view('reportes.ingresosecretaria')
                    ->with('fecha_inicio', $fecha_inicio)
                    ->with('fecha_fin', $fecha_fin)
                    ->with('secretariaB', $secretariaB)
                    ->with('secretarias', $secretarias);
    }

    public function getIngresoSecretaria(Request $request)
    {
        if ($request->input('tipo') == 'excel') {
            $fecha_inicio = $request->input('desdeExcel');
            $fecha_fin    = $request->input('hastaExcel');
            $secretaria  = json_decode($request->input('secretariaExcel'));
        }else{
            $fecha_inicio = $request->input('fechadesde');
            $fecha_fin    = $request->input('fechahasta');
            $secretaria  = $request->input('secretaria');
        }

        $fecha_inicio = str_replace('/', '-', $fecha_inicio);
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_inicio = $fecha_inicio.' 0:0:0';

        $fecha_fin = str_replace('/', '-', $fecha_fin);
        $fecha_fin = date('Y-m-d', strtotime($fecha_fin));
        $fecha_fin = $fecha_fin.' 23:59:59';

        #Se obtienen todos las atenciones que cumplan con los filtros de búsqueda
        $atenciones = Atencion::select(DB::raw("CONCAT(usuarios.nombres,' ',usuarios.apellido_paterno,' ',usuarios.apellido_materno) As secretaria"), DB::raw('SUM(atenciones.abono) AS ingreso'))
                    ->whereBetween('fecha', [$fecha_inicio, $fecha_fin]);

        if (!empty($secretaria)) {
            $atenciones = $atenciones->whereIn('usuario_rut', $secretaria); 
        }

        $atenciones = $atenciones
                    ->where('usuarios.perfil_id', '=', 3)
                    ->rightjoin('usuarios','usuarios.rut','=','usuario_rut')
                    ->groupBy('usuarios.rut', 'usuarios.nombres', 'usuarios.apellido_paterno', 'usuarios.apellido_materno')
                    ->get();

        if ($request->input('tipo') == 'table') {
            #Se genera tabla
            foreach ($atenciones as $atencion){
                $atencion->ingreso = '$ '.number_format($atencion->ingreso, 0, '', '.');
            }

            return Datatables::of($atenciones)->make(true);
        }

        if ($request->input('tipo') == 'grafico') {
            #Se envía información para generar gráfico
            $secretarias = [];

            foreach ($atenciones as $atencion) {
                $secretarias[$atencion->secretaria] = $atencion->ingreso;
            }

            return  response()->json(['secretarias' => json_encode($secretarias)]);
        }

        if ($request->input('tipo') == 'excel') {
            #Se genera archivo Excel
            return Excel::create('IngresoSecretaria', function($excel) use ($atenciones) {
                $excel->sheet('Atenciones', function($sheet) use ($atenciones)
                {
                    $count = 2;         
                    $sheet->setColumnFormat(array(
                        'B' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                    ));
                    $sheet->row(1, ['Secretaria', 'Ingreso']);
                    $sheet->cells('A1:B1', function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    foreach ($atenciones as $key => $value) {
                        $sheet->row($count, [$value->secretaria, $value->ingreso]);
                        $count = $count +1;
                    }
                });
            })->download('xlsx');
        }
    }
    
    public function ReporteIngresoPaciente()
    {        
        $sucursalB  = \Request::get('sucursalB');
        $sucursales = Sucursal::select('id', 'nombre')->get()->pluck('nombre', 'id');

        return view('reportes.ingresopaciente')
                    ->with('sucursales',    $sucursales)
                    ->with('sucursalB',     $sucursalB);
    }

    public function getIngresoPaciente(Request $request)
    {
        if ($request->input('tipo') == 'excel') {
            $fechadesde         = $request->input('fechadesdeExcel');
            $fechahasta         = $request->input('fechahastaExcel');
            $monto_minimo       = $request->input('monto_minimoExcel');
            $monto_maximo       = $request->input('monto_maximoExcel');
            $sucursal           = json_decode($request->input('sucursalesExcel'));
            $rut_paciente       = $request->input('rut_pacienteExcel');
            $nombre_paciente    = $request->input('nombre_pacienteExcel');
            $rut_profesional    = $request->input('rut_profesionalExcel');
            $nombre_profesional = $request->input('nombre_profesionalExcel');
        }else{
            $fechadesde         = $request->input('fechadesde');
            $fechahasta         = $request->input('fechahasta');
            $monto_minimo       = $request->input('monto_minimo');
            $monto_maximo       = $request->input('monto_maximo');
            $sucursal           = $request->input('sucursal');
            $rut_paciente       = $request->input('rut_paciente');
            $nombre_paciente    = $request->input('nombre_paciente');
            $rut_profesional    = $request->input('rut_profesional');
            $nombre_profesional = $request->input('nombre_profesional');
        }

        if (!is_null($fechadesde)) {
            $fechadesde = str_replace('/', '-', $fechadesde);
            $fechadesde = date('Y-m-d', strtotime($fechadesde));
        }else{
            $fechadesde = date_format(date_create('America/Santiago'), 'Y-m-d');
        }

        if (!is_null($fechahasta)) {
            $fechahasta = str_replace('/', '-', $fechahasta);
            $fechahasta = date('Y-m-d', strtotime($fechahasta));
        }else{
            $fechahasta = date_format(date_create('America/Santiago'), 'Y-m-d');
        }

        $fechadesde = $fechadesde.' 0:0:0';
        $fechahasta = $fechahasta.' 23:59:59';

        #Se obtienen todos las atenciones que cumplan con los filtros de búsqueda
        $ingresos   =   Atencion::select(  
                                            'atenciones.fecha',
                                            DB::raw('CONCAT(pacientes.rut, "-", pacientes.dv) As rut_paciente'),
                                            DB::raw('CONCAT(pacientes.nombres, " ", pacientes.apellido_paterno, " ", pacientes.apellido_materno) As paciente'),
                                            DB::raw('CONCAT(profesionales.rut, "-", profesionales.dv) As rut_profesional'),
                                            DB::raw('CONCAT(profesionales.nombres, " ", profesionales.apellido_paterno, " ", profesionales.apellido_materno) As profesional'),
                                            'sucursales.nombre As sucursal',
                                            'atenciones.abono As monto')
                                ->join('tratamientos',  'atenciones.tratamiento_folio', '=', 'tratamientos.folio')
                                ->join('sucursales',    'atenciones.sucursal_id',       '=', 'sucursales.id')
                                ->join('pacientes',     'tratamientos.paciente_rut',    '=', 'pacientes.rut')
                                ->join('profesionales', 'atenciones.profesional_rut',   '=', 'profesionales.rut')
                                ->where('atenciones.reserva', '=', 0)
                                ->where('atenciones.fecha', '>=', $fechadesde)
                                ->where('atenciones.fecha', '<=', $fechahasta);

        if (!is_null($monto_minimo)) {
            $ingresos = $ingresos->where('atenciones.abono', '>=', $monto_minimo);
        }

        if (!is_null($monto_maximo)) {
            $ingresos = $ingresos->where('atenciones.abono', '<=', $monto_maximo);
        }

        if (!empty($sucursal)) {
            $ingresos = $ingresos->whereIn('sucursal_id', $sucursal); 
        }

        if (!is_null($rut_paciente)) {
            $ingresos = $ingresos->where('pacientes.rut', '=', $rut_paciente);
        }

        if (!is_null($nombre_paciente)) {
            $ingresos = $ingresos->where(DB::raw('CONCAT(pacientes.nombres, " ", pacientes.apellido_paterno, " ", pacientes.apellido_materno)'), 'LIKE', '%'.$nombre_paciente.'%');
        }

        if (!is_null($rut_profesional)) {
            $ingresos = $ingresos->where('profesionales.rut', '=', $rut_profesional);
        }

        if (!is_null($nombre_profesional)) {
            $ingresos = $ingresos->where(DB::raw('CONCAT(profesionales.nombres, " ", profesionales.apellido_paterno, " ", profesionales.apellido_materno)'), 'LIKE', '%'.$nombre_profesional.'%');
        }
        
        $ingresos   =  $ingresos->whereNotNull('atenciones.abono')
                                ->groupBy('atenciones.fecha', 'rut_paciente', 'paciente', 'rut_profesional', 'profesional', 'sucursal', 'monto')
                                ->orderBy('pacientes.rut')
                                ->get();

        foreach ($ingresos as $ingreso) {
            $ingreso->hora  = date_format(date_create($ingreso->fecha), 'H:i A');
            if ($request->input('tipo') == 'excel') {
                $ingreso->fecha = date_format(date_create($ingreso->fecha), 'Y-m-d');
            }else{
                $ingreso->fecha = date_format(date_create($ingreso->fecha), 'Y/m/d');
            }
        }

        if ($request->input('tipo') == 'table') {
            #Se genera tabla

            return Datatables::of($ingresos)->make(true);
        }
        
        if ($request->input('tipo') == 'excel') {
            #Se genera archivo Excel

            return Excel::create('IngresoPacientes', function($excel) use ($ingresos) {
                $excel->sheet('Ingresos', function($sheet) use ($ingresos)
                {
                    $count = 2;         
                    $sheet->setColumnFormat(array(
                        'A' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY ,
                        'H' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                    ));
                    $sheet->row(1, ['Fecha', 'Hora', 'Rut Paciente', 'Paciente', 'Rut Profesional', 'Profesional', 'Sucursal', 'Monto']);
                    $sheet->cells('A1:H1', function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    foreach ($ingresos as $value) {
                        $sheet->row($count, [
                                                \PHPExcel_Shared_Date::PHPToExcel(strtotime($value->fecha)),
                                                $value->hora,
                                                $value->rut_paciente,
                                                $value->paciente,
                                                $value->rut_profesional,
                                                $value->profesional,
                                                $value->sucursal,
                                                $value->monto
                                            ]);
                        $count = $count +1;
                    }
                });
            })->download('xlsx');
        }
    }
}