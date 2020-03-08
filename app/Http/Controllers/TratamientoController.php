<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Malahierba\ChileRut\ChileRut;


use App\LogAccion;
use Auth;

use App\Atencion;
use App\Observacion;
use App\Paciente;
use App\Pago;
use App\TipoTratamiento;
use App\Tratamiento;


class TratamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #Se obtienen todos los tipo de tratamiento, menos el 3 que es el genérico
        $tipo_tratamientos = TipoTratamiento::where('id', '<>', '3')->get();

        foreach ($tipo_tratamientos as $tipo_tratamiento) {
            #El nombre se cambia de General Ortodoncia a Ortodoncia
            $tipo_tratamiento->nombre = ($tipo_tratamiento->nombre == 'General Ortodoncia') ? 'Ortodoncia' : $tipo_tratamiento->nombre;
        }

        $tipo_tratamientos = $tipo_tratamientos->pluck('nombre', 'id');

        return view('tratamiento.index')->with('tipo_tratamientos',$tipo_tratamientos);
                

    }

    public function getTabla(Request $request)
    {

        $folio              = $request->input('folio');
        $nombre_tratamiento = utf8_decode($request->input('nombre_tratamiento'));
        $tipo               = $request->input('tipo');
        $rut_paciente       = $request->input('rut_paciente');
        $apellido_paterno   = utf8_decode($request->input('apellido_paterno'));
        #Se obtienen datos de tratamientos que coincidan con los filtros de búsqueda
        $tratamientos = Tratamiento::select('folio', 'tratamientos.nombre', 'tipo_tratamientos.nombre As tipo', 'pacientes.rut', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), DB::raw("MAX(atenciones.fecha) As ultima_fecha"), 'pacientes.telefono', 'num_control As numero', 'valor');

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
             $tratamientos   =  $tratamientos->where('pacientes.rut', '=', $rut_paciente);
        }

        if (!is_null($apellido_paterno)) {
            $tratamientos   = $tratamientos->whereRaw('LOWER(pacientes.apellido_paterno) LIKE ? ','%'.utf8_encode((strtolower($apellido_paterno))).'%');
        }

        $tratamientos    =   $tratamientos
                                    ->groupBy('folio', 'tratamientos.nombre', 'tipo_tratamientos.nombre', 'pacientes.rut', 'paciente', 'pacientes.telefono', 'numero', 'valor')
                                    ->join('tipo_tratamientos', 'tipo_tratamiento_id', '=', 'tipo_tratamientos.id')
                                    ->join('pacientes', 'tratamientos.paciente_rut','=', 'rut')
                                    ->leftjoin('atenciones', 'tratamientos.folio','=', 'atenciones.tratamiento_folio')
                                    ->get();

        foreach ($tratamientos as $tratamiento) {
            if (is_null($tratamiento->ultima_fecha)) {
                $tratamiento->ultima_fecha = "No se han registrado atenciones";
            }else{
                $tratamiento->ultima_fecha = date_format(date_create($tratamiento->ultima_fecha), 'd/m/Y H:i:s');
            }

            #Se calcula el valor total del abono
            $abono              =   Atencion::select(DB::raw('SUM(abono) As abono_total'))
                                            ->where('tratamiento_folio', '=', $tratamiento->folio)
                                            ->first();

            if (is_null($abono->abono_total)) {
                $abono->abono_total    =   "0";
            }

            $deuda              =   $tratamiento->valor - $abono->abono_total;
            #Si el tratamiento es genérico, pasa a ser General, y si es General Ortodoncia pasa a ser Ortodoncia
            $tratamiento->tipo  = ($tratamiento->tipo == 'Genérico') ? 'General' : $tratamiento->tipo;
            $tratamiento->tipo  = ($tratamiento->tipo == 'General Ortodoncia') ? 'Ortodoncia' : $tratamiento->tipo;
            $tratamiento->deuda = '$ '.number_format($deuda, 0 , '', '.');
            $tratamiento->valor = '$ '.number_format($tratamiento->valor, 0, '', '.');
        }
        
        return Datatables::of($tratamientos)
            ->addColumn('action', function ($tratamientos) use ($request){
                if (!is_null($request->input('home_secretaria'))) {
                    #Esto será visto en la busqueda del home de la secretaria y el asistente
                    if(Auth::user()->perfil_id == 3){
                        return '<a class="btn btn-success"  href="RegistrarAtencion/'.$tratamientos->folio.'" role="button">Registrar atención</a>
                                <a class="btn btn-warning"  href="RegistrarReserva/'.$tratamientos->folio.'" role="button">Registrar reserva</a>
                            <a class="btn btn-info" href="tratamiento/'.$tratamientos->folio.'" title="Detalle" >
                                Ver detalle
                            </a>';
                    }elseif (Auth::user()->perfil_id == 4) {
                        return '<a class="btn btn-info" href="tratamiento/'.$tratamientos->folio.'" title="Detalle" >
                                Ver detalle
                            </a>';
                    }
                }else{
                    if(Auth::user()->perfil_id == 3 || Auth::user()->perfil_id == 4){
                        #Esto sólo puede ser visto por la secretaria y el asistente
                        return '<a class="iconos" href="tratamiento/'.$tratamientos->folio.'" title="Detalle" >
                                    <span class="fa fa-eye" aria-hidden="true"></span>
                                </a>';
                    }else{
                        return '<a class="iconos" href="'.url('/tratamiento/').'/'.$tratamientos->folio.'/edit" title="Editar" >
                                    <span class="fa fa-edit" aria-hidden="true"></span>
                                </a><a class="iconos" href="tratamiento/'.$tratamientos->folio.'" title="Detalle" >
                                    <span class="fa fa-eye" aria-hidden="true"></span>
                                </a>
                                <a class="iconos" href="#" data-toggle="modal" data-target="#modal-eliminar_'.$tratamientos->folio.'" title="Eliminar" >
                                    <span class="fa fa-trash-o" aria-hidden="true"></span>
                                </a>
                                <div class="modal fade" id="modal-eliminar_'.$tratamientos->folio.'" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-red">
                                                <h4 class="modal-title">Confirmar eliminación</h4>
                                            </div>

                                            <div class="modal-body">
                                                <h3>¿Está seguro de eliminar a este tratamiento?, se eliminaran todas las atenciones de este y no podrá ser utilizado</h3>
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                                <a  href="tratamiento/destroy/'.$tratamientos->folio.'" type="submit" class="btn btn-danger" role="button">Aceptar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    }
                }
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $numero_folio  = Tratamiento::select('folio')->orderBy('folio', 'desc')->first();
        #Si no hay números de folio registrados, comenzamos en 1
        if (empty($numero_folio)) {
            $numero_folio   = 1;
        }else{
            $numero_folio   = ($numero_folio->folio) + 1;
        }
        #Se obtienen todos los tipos de tratamiento menos el genérico
        $tipoTratamiento = TipoTratamiento::select('id', 'nombre')->where('id', '<>', 3)->pluck('nombre', 'id');

        return view('tratamiento.create')
                ->with('num_folio', $numero_folio)
                ->with('tipoTratamiento',$tipoTratamiento);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->input('nombreN'))){
            return redirect()->route('tratamiento.create')->withInput()->with('error','Debe ingresar un nombre de tratamiento');
        }if(empty($request->input('valorN'))){
            return redirect()->route('tratamiento.create')->withInput()->with('error','Debe ingresar el dígito verificador');
        }
        if(empty($request->input('rut_pacienteN'))){
            return redirect()->route('tratamiento.create')->withInput()->with('error','Debe ingresar el RUT del paciente');
        }else{
            $cantidad = Paciente::where('rut', '=', $request->input('rut_pacienteN'))->count();
            if ($cantidad == 0) {
                return redirect()->route('tratamiento.create')->withInput()->with('error','Este paciente no está registrado');
            }else{
                $paciente = Paciente::find($request->input('rut_pacienteN'));
                if ($paciente->estado == 0) {
                    return redirect()->route('tratamiento.create')->withInput()->with('error','Este paciente está inactivo');
                }
            }
        }
        if(empty($request->input('tipo_tratamientoN'))){
            return redirect()->route('tratamiento.index')->withInput()->with('error','Seleccione un tipo de tratamiento');
        }


        $tipo_tratamiento                   = $request->input('tipo_tratamientoN');
        $tratamientos_pacientes             = Tratamiento::where('tratamientos.paciente_rut', '=', $request->input('rut_pacienteN'))->where('tipo_tratamiento_id', '=', $tipo_tratamiento)->where('estado_deuda', '=', 1)->first();

        if (!empty($tratamientos_pacientes)) {
            if ($tratamientos_pacientes->estado_deuda == 1) {
                return back()->withInput()->with('error', 'No se puede crear el tratamiento debido a que este paciente tiene una deuda pendiente.');
            }
        }

        $tratamiento                        = new Tratamiento();
        $tratamiento->nombre                = $request->input('nombreN');
        $tratamiento->valor                 = $request->input('valorN');
        $tratamiento->paciente_rut          = $request->input('rut_pacienteN');
        if(empty($request->input('num_controlN'))){
            $tratamiento->num_control       = 1;
        }else{
            $tratamiento->num_control       = $request->input('num_controlN');
        }
        $tratamiento->tipo_tratamiento_id   = $request->input('tipo_tratamientoN');

        $count = mb_strlen($request->input('nombreN'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'Nombre demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $tratamiento->nombre = $request->input('nombreN');
        }

        if (!is_null($request->input('observacionN'))) {
            $tratamiento->observacion      = $request->input('observacionN');
        }

        $tratamiento->estado_deuda          =   0;

        $tratamiento->save();

        $ultimo_folio                       =   $tratamiento->folio;
        $precio_final                       =   $request->input('valorN');

        #Guardar log al guardar tratamiento
        LogAccion::create([
                    'accion' => "Guardar Tratamiento",
                    'detalle' => "Se guarda tratamiento ".$request->input('nombreN')." del paciente ".$request->input('rut_pacienteN'),
                    'usuario_rut' => Auth::user()->rut,
                ]);

        if($request->input('tipo_tratamientoN') == '1'){
            #Si se crea un tipo tratamiento 1 se ingresa directamente una
            return redirect()->action('AtencionController@registrarAtencion', ['folio' => $ultimo_folio])->with('success','Se creó el tratamiento correctamente');
        }

        /*if($request->input('tipo_tratamientoN') == '2'){
            #Si se selecciona tipo tratamiento 2, se crea otro tratamiento genérico
            $tratamiento                        = new Tratamiento();
            $tratamiento->nombre                = 'Tratamiento de ortodoncia ('.$request->input('nombreN').')';
            $tratamiento->valor                 = '0';
            $tratamiento->paciente_rut          = $request->input('rut_pacienteN');
            $tratamiento->num_control           = '1';
            $tratamiento->tipo_tratamiento_id   = '3';
            $tratamiento->estado_deuda          = '0';
            if (!is_null($request->input('observacionN'))) {
                $tratamiento->observacion      = $request->input('observacionN');
            }
            $tratamiento->estado_deuda          =   0;

            $tratamiento->save();
            #Guarda log al guardar tratamiento genérico
            LogAccion::create([
                    'accion' => "Guardar Tratamiento",
                    'detalle' => "Se guarda tratamiento genérico para ".$request->input('nombreN')." del paciente ".$request->input('rut_pacienteN'),
                    'usuario_rut' => Auth::user()->rut,
                ]);
        }*/

        return redirect()->route('tratamiento.index')->with('success','Tratamiento añadido correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($folio)
    {
        #Se obtiene el tratamiento asociado al número de folio, además de calcular el total pagado
        $tratamiento = Tratamiento::find($folio);
        $pagado      =  Atencion::select(DB::raw('SUM(abono) As pagado'))->where('tratamiento_folio', '=', $tratamiento->folio)->first();

        $deuda       =  intval($tratamiento->valor) - intval($pagado->pagado);
        $tratamiento->estado_deuda = ($deuda > 0) ? 'debe' : 'pagado' ;

        $tratamiento->valor     = number_format($tratamiento->valor, 0, '', '.');
        $tratamiento->pagado    = number_format($pagado->pagado, 0, '', '.');
        $tratamiento->deuda     = number_format($deuda, 0, '', '.');

        $paciente = $tratamiento->paciente->nombres.' '.$tratamiento->paciente->apellido_paterno.' '.$tratamiento->paciente->apellido_materno;

        $tipo_tratamiento = TipoTratamiento::select('tipo_tratamientos.nombre')->join('tratamientos', 'tratamientos.tipo_tratamiento_id','=','tipo_tratamientos.id')->where('tratamientos.folio', '=', $tratamiento->folio)->first();

        return view('tratamiento.show', compact('tratamiento'))->with('paciente', $paciente)->with('tipo_tratamiento',$tipo_tratamiento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($folio)
    {
        #Se obtienen datos del tratamiento que coincida con el folio
        $tratamiento = Tratamiento::select('tratamientos.*', 'pacientes.rut','pacientes.dv','pacientes.nombres', 'pacientes.apellido_paterno', 'pacientes.apellido_materno', 'pacientes.email', 'pacientes.telefono', 'tipo_tratamientos.nombre As tipo')->join('pacientes', 'tratamientos.paciente_rut', '=', 'pacientes.rut')->join('tipo_tratamientos', 'tipo_tratamiento_id', '=', 'tipo_tratamientos.id')->where('folio', '=', $folio)->first();

        #Tratamientos que sean tipo General Ortodoncia se cambian a Ortodoncia
        $tratamiento->tipo = ($tratamiento->tipo == 'General Ortodoncia') ? 'Ortodoncia' : $tratamiento->tipo ;

        return view('tratamiento.edit')->with('tratamiento', $tratamiento);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $folio)
    {
        if(empty($request->input('nombre'))){
            return redirect()->route('tratamiento.index')->withInput()->with('error','Debe ingresar un nombre de tratamiento');
        }if(empty($request->input('num_control'))){
            return redirect()->route('tratamiento.index')->withInput()->with('error','Debe ingresar el número de control');
        }if(empty($request->input('valor'))){
            return redirect()->route('tratamiento.index')->withInput()->with('error','Debe ingresar el dígito verificador');
        }
        #Obtiene el tratamiento que coincida con el folio y se actualizan valores
        $tratamiento                        = Tratamiento::find($folio);;
        $tratamiento->nombre                = $request->input('nombre');
        $tratamiento->valor                 = $request->input('valor');
        $tratamiento->num_control           = $request->input('num_control');

        $count = mb_strlen($request->input('nombre'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'Nombre demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $tratamiento->nombre = $request->input('nombre');
        }

        if (!is_null($request->input('observacion'))) {
            $tratamiento->observacion      = $request->input('observacion');
        }
        $tratamiento->save();
        #Guarda log al actualizar tratamiento
        LogAccion::create([
                    'accion' => "Actualizar Tratamiento",
                    'detalle' => "Se actualiza tratamiento ".$request->input('nombre')." del paciente ".$request->input('rut_paciente'),
                    'usuario_rut' => Auth::user()->rut,
                ]);

        return redirect()->route('tratamiento.index')->with('success','Tratamiento modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($folio)
    {
        $tratamiento            = Tratamiento::find($folio);
        $atenciones             = Atencion::where('tratamiento_folio', '=', $tratamiento->folio)->get();
        foreach ($atenciones as $atencion) {
            $pagos              = Pago::where('atenciones_id', '=', $atencion->id)->delete();
            LogAccion::create([
                'accion' => "Se eliminó pagos de atención ",
                'detalle' => "Se eliminó los pagos de la atención ".$atencion->id,
                'usuario_rut' => Auth::user()->rut,
            ]);

            $observacion        = Observacion::where('atencion_id', '=', $atencion->id)->delete();
            LogAccion::create([
                'accion' => "Se eliminó observaciones de atención ",
                'detalle' => "Se eliminó los observaciones de la atención ".$atencion->id,
                'usuario_rut' => Auth::user()->rut,
            ]);
        }

        $atenciones             = Atencion::where('tratamiento_folio', '=', $tratamiento->folio)->delete();
        LogAccion::create([
            'accion' => "Se eliminó atenciones de tratamiento ",
            'detalle' => "Se eliminó atenciones de tratamiento N°".$folio,
            'usuario_rut' => Auth::user()->rut,
        ]);

        $tratamiento            = Tratamiento::where('folio', '=', $folio)->delete();

        LogAccion::create([
            'accion' => "Se eliminó tratamiento ",
            'detalle' => "Se eliminó tratamiento N°".$folio,
            'usuario_rut' => Auth::user()->rut,
        ]);

        return redirect()->route('tratamiento.index')->with('success','Tratamiento eliminado correctamente');
    }

    public function exportExcel(Request $request)
    {
        $folio              = $request->input('folioExcel');
        $nombre_tratamiento = utf8_decode($request->input('nombreExcel'));
        $tipo               = $request->input('tipoExcel');
        $rut_paciente       = $request->input('rutExcel');
        $apellido_paterno   = utf8_decode($request->input('apellidoExcel'));
        #Se obtienen todos los tratamientos que cumplan con el filtro de búsqueda
        $tratamientos = Tratamiento::select('folio', 'tratamientos.nombre', 'tipo_tratamientos.nombre As tipo', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), DB::raw("MAX(atenciones.fecha) As ultima_fecha"), 'num_control As numero','valor');

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
             $tratamientos   =  $tratamientos->where('pacientes.rut', '=', $rut_paciente);
        }

        if (!is_null($apellido_paterno)) {
            $tratamientos   = $tratamientos->whereRaw('LOWER(pacientes.apellido_paterno) LIKE ? ','%'.utf8_encode((strtolower($apellido_paterno))).'%');
        }

        $tratamientos    =   $tratamientos
                                    ->groupBy('folio', 'tratamientos.nombre', 'tipo_tratamientos.nombre', 'pacientes.rut', 'paciente', 'pacientes.telefono', 'numero', 'valor')
                                    ->join('tipo_tratamientos', 'tipo_tratamiento_id', '=', 'tipo_tratamientos.id')
                                    ->join('pacientes', 'tratamientos.paciente_rut','=', 'rut')
                                    ->join('atenciones', 'tratamientos.folio','=', 'atenciones.tratamiento_folio')
                                    ->get();


        foreach ($tratamientos as $tratamiento) {
            #Obtiene el abono total
            $abono              =   Atencion::select(DB::raw('SUM(abono) As abono_total'))
                                            ->where('tratamiento_folio', '=', $tratamiento->folio)
                                            ->first();

            if (is_null($abono->abono_total)) {
                $abono->abono_total    =   "0";
            }

            $deuda              =   $tratamiento->valor - $abono->abono_total;

            $tratamiento->tipo  = ($tratamiento->tipo == 'Genérico') ? 'General' : $tratamiento->tipo;
            $tratamiento->tipo  = ($tratamiento->tipo == 'General Ortodoncia') ? 'Ortodoncia' : $tratamiento->tipo;
            $tratamiento->deuda = $deuda;
            $tratamiento->valor = $tratamiento->valor;
        }

        return Excel::create('ListadoTratamientos', function($excel) use ($tratamientos) {          
            $excel->sheet('Tratamientos', function($sheet) use ($tratamientos) {               
                $count = 2;

                $sheet->setColumnFormat(array(
                    'B' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY,
                    'G' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD,
                    'H' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                ));

                $sheet->row(1, ['Folio','Última atención', 'Tratamiento','Tipo','Paciente','Número de controles','Valor','Deuda']);
                $sheet->cells('A1:H1', function($cells) {
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });

                foreach ($tratamientos as $key => $value) {
                    $sheet->row($count, [$value->folio, $value->ultima_fecha, $value->nombre, $value->tipo, $value->numero, $value->paciente, $value->valor, $value->deuda]);
                    $count = $count +1;
                }
            });
        })->download('xlsx');
    }

    public function getPaciente(Request $request)
    {
        if ($request->ajax()) {
            $rut_paciente = $request->input('rut_pacienteN');
            #Obtiene datos del paciente que coincida con RUT
            $pacientes = Paciente::select(DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As nombre_paciente"), 'email', 'telefono')->where('estado','=', '1')->where('rut','=',$rut_paciente)->get();

            return response()->json([
                'pacientes' => $pacientes,
            ]);
        }
    }

    public function getTableAtenciones(Request $request)
    {
        $folio              = $request->input('folio');
        #Obtiene datos de atención que coincida con número de folio
        $atenciones         = Atencion::select('atenciones.id', 'num_atencion', 'fecha', DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As profesional"), 'abono', 'sucursales.nombre As sucursal')
                                ->join('profesionales', 'profesional_rut','=', 'rut')
                                ->join('sucursales', 'sucursal_id','=', 'sucursales.id')
                                ->where('tratamiento_folio', '=', $folio)
                                ->where('reserva', '=', 0)
                                ->get();

        $numatencion = 0;

        foreach ($atenciones as $atencion) {
            #Aplica formato a hora, fecha  y abono
            $atencion->num_atencion = $numatencion + 1;
            $atencion->hora         = date_format(date_create($atencion->fecha), 'H:i:s');
            $atencion->fecha        = date_format(date_create($atencion->fecha), 'd/m/Y');
            $atencion->abono        = '$ '.number_format($atencion->abono, 0, '', '.');
            $atencion->table        = '';
            if (!is_null($request->input('table'))) {
                $atencion->table = 'historial';
            }
            $numatencion++;
        }

        return Datatables::of($atenciones)
                                ->addColumn('action', function ($atenciones){
                                    if ($atenciones->table == 'historial') {
                                        return '<a href="'.url('atencion/'.$atenciones->id).'" title=Detalle>
                                                    <em class="fa fa-eye fa-lg"></em>
                                                </a>';
                                    }else{
                                        if(Auth::user()->perfil_id <= 2){
                                            #Esto solo lo puede ver el administrador y superadministrador
                                            return '</a><a href="'.url('atencion/'.$atenciones->id).'" title=Detalle>
                                                    <em class="fa fa-eye fa-lg"></em>
                                                </a><a class="iconos" href="#" data-toggle="modal" data-target="#modal-eliminar_'.$atenciones->id.'" title="Eliminar" >
                                                    <span class="fa fa-trash-o" aria-hidden="true"></span>
                                                </a>
                                                <div class="modal fade" id="modal-eliminar_'.$atenciones->id.'" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-red">
                                                                <h4 class="modal-title">Confirmar eliminación</h4>
                                                            </div>

                                                            <div class="modal-body">
                                                                <h3>¿Está seguro de eliminar a esta atención?</h3>
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
                                                </a>
                                                <a role="button" class="btn btn-info" href="'.url('atencion/observacion/'.$atenciones->id).'" title="Nueva observación"> Agregar observación
                                                </a>';
                                        }
                                        
                                    }
                                })
                                ->make(true);
    }

    public function exportAtencionesExcel(Request $request)
    {
        $folio              = $request->input('folioExcel');
        #Obtiene atenciones que coincidan con número de folio
        $atenciones         = Atencion::select('num_atencion', 'fecha', DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As profesional"), 'abono')
                                ->join('profesionales', 'profesional_rut','=', 'rut')
                                ->join('tratamientos','tratamiento_folio','=', 'tratamientos.folio')
                                ->where('tratamiento_folio', '=', $folio)
                                ->get();


        return Excel::create('ListadoAtenciones', function($excel) use ($atenciones) {          
            $excel->sheet('Tratamientos', function($sheet) use ($atenciones) {               
                $count = 2;
                #Formato a una celda en específico
                $sheet->setColumnFormat(array(
                    'B' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY,
                    'C' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4,
                    'E' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                ));

                $sheet->row(1, ['Número de control','Fecha','Hora','Profesional','Abono']);
                $sheet->cells('A1:E1'.$count, function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                
                foreach ($atenciones as $key => $value) {
                    $value->hora     = date_format(date_create($value->fecha), 'H:i:s');
                    $value->hora     = strtotime($value->hora);
                    $value->hora     = \PHPExcel_Shared_Date::PHPToExcel($value->hora);
                    $value->fecha    = date_format(date_create($value->fecha), 'Y-m-d');
                    $value->fecha    = strtotime($value->fecha);
                    $value->fecha    = \PHPExcel_Shared_Date::PHPToExcel($value->fecha);

                    $sheet->row($count, [$value->num_atencion, $value->fecha, $value->hora, $value->profesional, $value->abono]);
                    $count = $count +1;
                }
            });
        })->download('xlsx');

    }
}
