<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\DB;
use Malahierba\ChileRut\ChileRut;
use Maatwebsite\Excel\Facades\Excel;

use App\LogAccion;
use Auth;

use App\Tratamiento;
use App\Atencion;
use App\Profesional;
use App\Cargo;
use App\Profesion;
use App\TipoContrato;
use App\Sucursal;
use App\SucursalProfesional;
use App\Usuario;
use helpers;



class ProfesionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Se obtienen las sucursales, tipo de contrato y profesiones
        $sucursalB    = \Request::get('sucursalB');
        $sucursales   = Sucursal::select('id', 'nombre')->pluck('nombre', 'id');
        $profesiones  = Profesion::select('id','nombre')->orderBy('nombre','asc')->pluck('nombre','id');
        $tipoContrato = [];
        $tipoContrato = TipoContrato::select('id','nombre')->orderBy('nombre','asc')->pluck('nombre','id');
        return view('profesionales.index')
                ->with('sucursalB', $sucursalB)
                ->with('sucursales',$sucursales)
                ->with('profesiones',$profesiones)
                ->with('tipoContrato',$tipoContrato);
    }

    public function getTabla(Request $request)
    {
        $rutB               = $request->input('rutB');
        $apellido_paternoB  = utf8_decode($request->input('apellido_paternoB'));
        $correoB            = $request->input('correoB');
        $direccionB         = utf8_decode($request->input('direccionB'));
        $profesionB         = $request->input('profesionB');
        $estadoB            = $request->input('estadoB');
        $tipoContratoB      = $request->input('tipoContratoB');
        $sucursalB          = $request->input('sucursalB');

        #Obtener profesionales que coincidan con el filtro de búsqueda
        $profesionales          = Profesional::select('rut', 'dv', DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As nombre_profesional"), 'email', 'profesionales.direccion', 'profesiones.nombre As profesion', 'tipo_contrato.nombre As tipo_contrato','estado');

        if(!is_null($rutB)){
            $profesionales = $profesionales->where('rut','=',$rutB);
        }

        if (!is_null($apellido_paternoB)) {
            $profesionales  = $profesionales->whereRaw('LOWER(profesionales.apellido_paterno) LIKE ? ','%'.utf8_encode((strtolower($apellido_paternoB))).'%');
        }

        if (!is_null($correoB)) {
            $profesionales  = $profesionales->whereRaw('LOWER(profesionales.email) LIKE ? ','%'.(strtolower($correoB)).'%');
        }

        if (!is_null($direccionB)) {
            $profesionales  = $profesionales->whereRaw('LOWER(profesionales.direccion) LIKE ? ','%'.(utf8_encode(strtolower($direccionB))).'%');
        }

        if (!is_null($tipoContratoB)) {
            $profesionales  = $profesionales->where('profesionales.tipo_contrato_id','=', $tipoContratoB); 
        }

        if (!is_null($profesionB)) {
            $profesionales  = $profesionales->where('profesionales.profesion_id','=', $profesionB); 
        }

        if (!is_null($estadoB) && $estadoB <> "all") {
            $profesionales  = $profesionales->where('profesionales.estado','=', $estadoB); 
        }

        if (!is_null($sucursalB)) {
            $profesionales  = $profesionales->whereIn('sucursal_profesional.sucursal_id', $sucursalB); 
        }

        $profesionales      = $profesionales
                                    ->join('sucursal_profesional', 'profesional_rut','=', 'profesionales.rut')
                                    ->join('tipo_contrato', 'tipo_contrato_id','=', 'tipo_contrato.id')
                                    ->join('profesiones', 'profesion_id','=', 'profesiones.id')
                                    ->groupBy('profesionales.rut', 'dv', 'profesionales.nombres', 'profesionales.nombres', 'profesionales.apellido_paterno', 'profesionales.apellido_materno', 'profesionales.email', 'profesionales.direccion', 'profesiones.nombre', 'tipo_contrato.nombre', 'profesionales.estado')
                                    ->orderBy('rut', 'asc')
                                    ->get();
        #Si el estado es 1 queda Activo, caso contrario es Inactivo
        foreach ($profesionales as $profesional){
            $profesional->estado = ($profesional->estado == 1) ? 'Activo' : 'Inactivo' ;
        }
        #Genera la tabla
        return Datatables::of($profesionales)
            ->addColumn('detalle_rut', function ($profesionales){                
                            return '<a href="'.url('/profesionales/').'/'.$profesionales->rut.'" title=Detalle>'.$profesionales->rut.'</a>';
            })
            ->addColumn('action', function ($profesionales) {
                if ($profesionales->estado == 'Activo') {
                    return '<a class="iconos" href="'.url('/profesionales/').'/'.$profesionales->rut.'/edit" title="Editar" >
                            <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                        </a>
                        <a class="iconos" href="#" data-toggle="modal" data-target="#modal-eliminar_'.$profesionales->rut.'" title="Eliminar" >
                            <span class="fa fa-trash-o" aria-hidden="true"></span>
                        </a>
                        <div class="modal fade" id="modal-eliminar_'.$profesionales->rut.'" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-red">
                                        <h4 class="modal-title">Confirmar eliminación</h4>
                                    </div>

                                    <div class="modal-body">
                                        <h3>¿Está seguro de eliminar este profesional?</h3>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                        <a href="'.url('/profesionales/destroy').'/'.$profesionales->rut.'" type="submit" class="btn btn-danger" role="button">Aceptar</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }else{
                    return '<a class="iconos" href="#" data-toggle="modal" data-target="#modal-activar_'.$profesionales->rut.'" title="Activar" >
                                <span class="fa fa-check-circle" aria-hidden="true"></span>
                            </a>
                        <div class="modal fade" id="modal-activar_'.$profesionales->rut.'" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-green">
                                        <h4 class="modal-title">Confirmar activación</h4>
                                    </div>

                                    <div class="modal-body">
                                        <h3>¿Está seguro de activar este profesional?</h3>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                        <a href="'.url('/profesionales/activate').'/'.$profesionales->rut.'" type="submit" class="btn btn-success" role="button">Aceptar</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
            })
            ->rawColumns(['detalle_rut','action'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profesionales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #Revisar si el RUT ingresado es válido o no
        $rut_validar = $request->input('rutN').'-'.$request->input('dvN');
        if (!valida_rut($rut_validar)) {
            return redirect()->route('profesionales.index')->withInput()->with('error','RUT ingresado no es válido');
        }
        if(empty($request->input('rutN'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar un RUT');
        }else{
            $profesional = Profesional::where('rut', '=', $request->input('rutN'))->get();
            if (count($profesional) > 0) {
                #Si el contador es mayor a cero significa que el RUT ya está asociado a otro profesional
                return redirect()->route('profesionales.index')->withInput()->with('error','RUT ingresado ya está asociado a otro profesional');
            }
        }
        if(is_null($request->input('dvN'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar el dígito verificador');
        }elseif(empty($request->input('nombreN'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar un nombre');
        }elseif(empty($request->input('apellido_paternoN'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar un apellido paterno');
        }elseif(empty($request->input('apellido_maternoN'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar un apellido materno');
        }elseif(empty($request->input('correoN'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar un correo electrónico');
        }elseif(empty($request->input('direccionN'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar una dirección');
        }elseif(empty($request->input('sucursalN'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Seleccione una sucursal');
        }elseif(empty($request->input('profesionN'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Seleccione una profesión');
        }elseif(empty($request->input('tipoContratoN'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Seleccione un tipo de contrato');
        }

        $profesional = Profesional::where('email', '=', $request->input('correoN'))->get();
        if (count($profesional) > 0) {
            return redirect()->route('profesionales.index')->withInput()->with('error','El correo electrónico ingresado ya está asociado a otro profesional');
        }

        #Verificar que el correo electrónico ingresado sea válido
        $correo = $request->input('correoN');
        $resp   = false;
        if (filter_var($correo, FILTER_VALIDATE_EMAIL))
        {
            $resp = true;
        }
        if($resp == false){
            return redirect()->route('profesionales.index')->withInput()->with('error','Correo electrónico ingresado es incorrecto');
        }

        $profesional                       = new Profesional();
        $profesional->rut                  = $request->input('rutN');
        $profesional->dv                   = $request->input('dvN');
        
        $count = mb_strlen($request->input('nombreN'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'Los nombres son demasiado largos, el máximo permitido es 25 caracteres');
        }else{
            $profesional->nombres = $request->input('nombreN');
        }

        $count = mb_strlen($request->input('apellido_paternoN'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'El apellido paterno demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $profesional->apellido_paterno = $request->input('apellido_paternoN');
        }

        $count = mb_strlen($request->input('apellido_maternoN'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'El apellido materno demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $profesional->apellido_materno = $request->input('apellido_maternoN');
        }

        $count = mb_strlen($request->input('correoN'), 'UTF-8');
        if($count > 100){
            return back()->with('error', 'Correo electrónico demasiado largo, el máximo permitido es 100 caracteres');
        }else{
            $profesional->email = $request->input('correoN');
        }

        $profesional->direccion            = $request->input('direccionN');
        $profesional->telefono             = $request->input('telefonoN');
        $profesional->estado               = true;
        $profesional->fecha_registro       = date_format(date_create('America/Santiago'), 'Y-m-d H:i:m');
        if (!is_null($request->input('observacionN'))) {
            $profesional->observacion         = $request->input('observacionN');
        }
        $profesional->tipo_contrato_id     = $request->input('tipoContratoN');
        $profesional->profesion_id         = $request->input('profesionN');
        #Guardar nuevo profesional
        $profesional->save();
        #Guarda Log cuando se crea un nuevo profesional
        LogAccion::create([
            'accion' => "Guardar Profesional",
            'detalle' => "Se guarda Profesional: " .$request->input('nombreN').' '.$request->input('apellido_paternoN').' '.$request->input('apellido_maternoN'),
            'usuario_rut' => Auth::user()->rut,
        ]);

        $sucursales = $request->input('sucursalN');
        #Por cada sucursal que posea el nuevo profesional, se agrega un elemento a la tabla SucursalProfesional
        foreach ($sucursales as $value => $sucursal) {
            $sucursal_profesional                   = new SucursalProfesional();
            $sucursal_profesional->sucursal_id      = $sucursal;
            $sucursal_profesional->profesional_rut  = $request->input('rutN');
            $sucursal_profesional->save();
            #Guarda log al asignar sucursal a profesional
            LogAccion::create([
                'accion' => "Asignar Sucursal a Profesional",
                'detalle' => "Se asigna Sucursal: " .$sucursal." al profesional ".$request->input('nombreN').' '.$request->input('apellido_paternoN').' '.$request->input('apellido_maternoN'),
                'usuario_rut' => Auth::user()->rut,
            ]);
        }

        //return redirect()->route('usuarios.index');
        return redirect()->route('profesionales.index')->with('success','Profesional creado correctamente');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($rut)
    {
        #Se obtienen datos de profesional que coincidan con el rut que ingresa
        $profesionales          = Profesional::select('profesionales.*',  'tipo_contrato.nombre As tipo_contrato', 'profesiones.nombre As profesion')->where('rut', '=', $rut)->orderBy('rut', 'asc')
                                    ->join('tipo_contrato', 'tipo_contrato_id','=', 'tipo_contrato.id')
                                    ->join('profesiones', 'profesion_id','=', 'profesiones.id')
                                    ->get();

        #Si el estado es 1 es activo, caso contrario es inactivo                             
        foreach ($profesionales as $profesional){
            $profesional->estado = ($profesional->estado == 1) ? 'Activo' : 'Inactivo' ;
        }
        #Se obtienen las sucursales en las que trabaja el profesional
        $sucursalesProfesional      = Sucursal::select('nombre')
                                    ->join('sucursal_profesional','sucursal_profesional.sucursal_id','=','sucursales.id')
                                    ->where('sucursal_profesional.profesional_rut','=', $rut)
                                    ->get();

        $sucursales                 = '';
        
        if ($sucursalesProfesional->count() > 1) {
            foreach ($sucursalesProfesional as $sucursal) {
               $sucursales .= $sucursal->nombre.', ';
            }
            $sucursales = rtrim($sucursales,", ");
        }else{
            $sucursales = $sucursalesProfesional->first()->nombre;
        }
        
        return view('profesionales.show')->with('profesionales', $profesionales)->with('sucursales',$sucursales);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($rut)
    {
        #Se obtiene datos del profesional y sus sucursales
        $profesional = Profesional::where('rut', '=', $rut)->first();
        $sucursalesProfesional = Sucursal::where('profesional_rut', '=', $rut)->join('sucursal_profesional', 'sucursales.id', '=', 'sucursal_id')->get();
        #Se obtienen sucursales, profesiones y tipo de contrato para poder seleccionar
        $sucursales = Sucursal::pluck('nombre', 'id');
        $profesiones = Profesion::orderBy('nombre','asc')->pluck('nombre', 'id');
        $tipoContrato = tipoContrato::orderBy('nombre','asc')->pluck('nombre', 'id');

        return view('profesionales.edit', compact('profesional'))
                                ->with('sucursales', $sucursales)
                                ->with('sucursalesProfesional', $sucursalesProfesional)
                                ->with('profesiones', $profesiones)
                                ->with('tipoContrato', $tipoContrato);
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
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar un nombre');
        }elseif(empty($request->input('apellido_paterno'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar un apellido paterno');
        }elseif(empty($request->input('apellido_materno'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar un apellido materno');
        }elseif(empty($request->input('email'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar un correo electrónico');
        }elseif(empty($request->input('telefono'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar un teléfono');
        }elseif(empty($request->input('direccion'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Debe ingresar una dirección');
        }elseif(empty($request->input('profesion_id'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Seleccione una profesion');
        }elseif(empty($request->input('tipo_contrato_id'))){
            return redirect()->route('profesionales.index')->withInput()->with('error','Seleccione un tipo de contrato');
        }
        #Verificar si el correo electrónico ingresado es válido
        $correo = $request->input('email');
        $resp   = false;
        if (filter_var($correo, FILTER_VALIDATE_EMAIL))
        {
            $resp = true;
        }
        if($resp == false){
            return redirect()->route('profesionales.index')->withInput()->with('error','Correo electrónico incorrecto');
        }

        $profesional                       = Profesional::find($rut);

        $count = mb_strlen($request->input('nombres'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'Los nombres son demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $profesional->nombres = $request->input('nombres');
        }

        $count = mb_strlen($request->input('apellido_paterno'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'El apellido paterno demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $profesional->apellido_paterno = $request->input('apellido_paterno');
        }

        $count = mb_strlen($request->input('apellido_materno'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'El apellido materno demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $profesional->apellido_materno = $request->input('apellido_materno');
        }

        $count = mb_strlen($request->input('email'), 'UTF-8');
        if($count > 100){
            return back()->with('error', 'Correo electrónico demasiado largo, el máximo permitido es 100 caracteres');
        }else{
            $profesional->email = $request->input('email');
        }

        $profesional->direccion            = $request->input('direccion');
        $profesional->telefono             = $request->input('telefono');
        $profesional->tipo_contrato_id     = $request->input('tipo_contrato_id');
        $profesional->profesion_id         = $request->input('profesion_id');
        if (!is_null($request->input('observacion'))) {
            $profesional->observacion            = $request->input('observacion');
        }
        #Guardar modificaciones del profesional
        $profesional->save();
        #Guarda log al actualizar datos del profesional
        LogAccion::create([
                'accion' => "Actualizar datos Profesional",
                'detalle' => "Se actualizan los datos del profesional: ".$request->input('nombreN').' '.$request->input('apellido_paternoN').' '.$request->input('apellido_maternoN'),
                'usuario_rut' => Auth::user()->rut,
            ]);

        SucursalProfesional::select('SucursalProfesional.*',  'tipo_contrato.nombre As tipo_contrato', 'profesiones.nombre As profesion')->where('profesional_rut', '=', $rut)
                                    ->delete();
        #Guarda log al resetear las sucursales                           
        LogAccion::create([
                'accion' => "Resetear Sucursales",
                'detalle' => "Se borraron todas las sucursales del profesional: ".$request->input('nombreN').' '.$request->input('apellido_paternoN').' '.$request->input('apellido_maternoN'),
                'usuario_rut' => Auth::user()->rut,
            ]);

        $sucursales = $request->input('sucursal');
        #Se agregan las nuevas sucursales al profesional
        foreach ($sucursales as $value => $sucursal) {
            $sucursal_profesional                   = new SucursalProfesional();
            $sucursal_profesional->sucursal_id      = $sucursal;
            $sucursal_profesional->profesional_rut  = $rut;
            $sucursal_profesional->save();
            #Guarda log al actualizar sucursales del profesional
            LogAccion::create([
                'accion' => "Actualizar asignación Sucursal a Profesional",
                'detalle' => "Se actualiza la asignación de Sucursal: " .$sucursal." al profesional ".$request->input('nombreN').' '.$request->input('apellido_paternoN').' '.$request->input('apellido_maternoN'),
                'usuario_rut' => Auth::user()->rut,
            ]);
        }

        return redirect()->route('profesionales.index')->with('success','Profesional modificado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $rut
     * @return \Illuminate\Http\Response
     */
    public function destroy($rut)
    {
        #Al destruir el estado pasa a ser 0
        $profesional           =   Profesional::find($rut);
        $profesional->estado   =   0;
        $profesional->save();
        #Guarda log al desactivar al profesional
        LogAccion::create([
                'accion' => "Desactivar Profesional",
                'detalle' => "Se desactiva profesional: ".$rut,
                'usuario_rut' => Auth::user()->rut,
            ]);

        return redirect()->route('profesionales.index')->with('success','Profesional desactivado correctamente');
    }

    public function activate($rut)
    {
        #Al activar el estado pasa a ser 1
        $profesional           =   Profesional::find($rut);
        $profesional->estado   =   1;
        $profesional->save();
        #Guarda log al activar al profesional
        LogAccion::create([
                'accion' => "Activar Profesional",
                'detalle' => "Se activa profesional: " .$rut,
                'usuario_rut' => Auth::user()->rut,
            ]);

        return redirect()->route('profesionales.index')->with('success','Profesional activado correctamente');
    }

    public function exportExcel(Request $request)
    {
        $rutB               = $request->input('rutExcel');
        $apellido_paternoB  = utf8_decode($request->input('apellido_paternoExcel'));
        $correoB            = $request->input('correoExcel');
        $direccionB         = utf8_decode($request->input('direccionExcel'));
        $estadoB            = json_decode($request->input('estadoExcel'));
        $sucursalB          = json_decode($request->input('sucursalExcel'));
        $profesionB         = $request->input('profesionExcel');
        $tipoContratoB      = $request->input('tipoContratoExcel');
        #Se obtienen datos de profesionales que coincidan con los filtros de búsqueda
        $profesionales          = Profesional::select('rut', 'dv', DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As nombre_profesional"), 'email', 'profesionales.direccion', 'profesiones.nombre As profesion', 'tipo_contrato.nombre As tipo_contrato','estado');

        if(!is_null($rutB)){
            $profesionales = $profesionales->where('rut','=',$rutB);
        }

        if (!empty($apellido_paternoB)) {
            $profesionales  = $profesionales->whereRaw('LOWER(profesionales.apellido_paterno) LIKE ? ','%'.utf8_encode((strtolower($apellido_paternoB))).'%');
        }

        if (!empty($correoB)) {
            $profesionales  = $profesionales->whereRaw('LOWER(profesionales.email) LIKE ? ','%'.(strtolower($correoB)).'%');
        }

        if (!empty($direccionB)) {
            $profesionales  = $profesionales->whereRaw('LOWER(profesionales.direccion) LIKE ? ','%'.(utf8_encode(strtolower($direccionB))).'%');
        }

        if (!is_null($tipoContratoB)) {
            $profesionales  = $profesionales->where('profesionales.tipo_contrato_id','=', $tipoContratoB); 
        }

        if (!is_null($profesionB)) {
            $profesionales  = $profesionales->where('profesionales.profesion_id','=', $profesionB); 
        }

        if (!is_null($estadoB) && $estadoB <> "all") {
            $profesionales  = $profesionales->where('profesionales.estado','=', $estadoB); 
        }

        if (!empty($sucursalB)) {
            $profesionales  = $profesionales->whereIn('sucursal_profesional.sucursal_id', $sucursalB); 
        }

        $profesionales      = $profesionales
                                    ->join('sucursal_profesional', 'profesional_rut','=', 'profesionales.rut')
                                    ->join('tipo_contrato', 'tipo_contrato_id','=', 'tipo_contrato.id')
                                    ->join('profesiones', 'profesion_id','=', 'profesiones.id')
                                    ->groupBy('profesionales.rut', 'dv', 'profesionales.nombres', 'profesionales.nombres', 'profesionales.apellido_paterno', 'profesionales.apellido_materno', 'profesionales.email', 'profesionales.direccion', 'profesiones.nombre', 'tipo_contrato.nombre', 'profesionales.estado')
                                    ->orderBy('rut', 'asc')
                                    ->get();
        #Si el estado es 1 es Activo, caso contrario es Inactivo
        foreach ($profesionales as $profesional){
            $profesional->estado = ($profesional->estado == 1) ? 'Activo' : 'Inactivo' ;
        }

        return Excel::create('ListadoProfesionales', function($excel) use ($profesionales) {
            $excel->sheet('Profesionales', function($sheet) use ($profesionales)
            {
                $count = 2;
                #Títulos de encabezados
                $sheet->row(1, ['RUT', 'DV', 'Nombre', 'Correo', 'Dirección', 'Profesión', 'Tipo de Contrato', 'Estado']);
                $sheet->cells('A1:H1', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                foreach ($profesionales as $key => $value) {
                    #Contenido de la tabla de Excel
                    $sheet->row($count, [$value->rut, $value->dv, $value->nombre_profesional, $value->email, $value->direccion, $value->profesion, $value->tipo_contrato, $value->estado]);
                    $count = $count +1;
                }
            });
        })->download('xlsx');
    }

    public function getTableAtencion(Request $request)
    {
        if ($request->ajax()) {
            #Obtiene datos de Atención asociada al RUT
           $atenciones = Atencion::select('atenciones.fecha As fecha', 'sucursales.nombre As sucursal', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), 'abono')
                                    ->join('tratamientos', 'tratamiento_folio', '=', 'tratamientos.folio')
                                    ->join('pacientes', 'pacientes.rut', '=', 'tratamientos.paciente_rut')
                                    ->join('sucursales', 'sucursales.id', '=', 'atenciones.sucursal_id')
                                    ->where('atenciones.profesional_rut', '=', $request->input('rut'))
                                    ->get(); 
            #Se aplican los respectivos formatos
           foreach ($atenciones as $atencion) {
                $atencion->hora         = date_format(date_create($atencion->fecha), 'H:i:s');
                $atencion->fecha        = date_format(date_create($atencion->fecha), 'd/m/Y');
                $atencion->abono        = '$ '.number_format($atencion->abono, 0, '', '.');
           }

           return Datatables::of($atenciones)->make(true);
        }
    }
    public function exportExcelAtenciones(Request $request)
    {
        #Se obtienen los datos de Atención asociada al RUT
         $atenciones = Atencion::select('atenciones.fecha As fecha', 'sucursales.nombre As sucursal', DB::raw("CONCAT(pacientes.nombres, ' ', pacientes.apellido_paterno, ' ', pacientes.apellido_materno) As paciente"), 'abono')
                                    ->join('tratamientos', 'tratamiento_folio', '=', 'tratamientos.folio')
                                    ->join('pacientes', 'pacientes.rut', '=', 'tratamientos.paciente_rut')
                                    ->join('sucursales', 'sucursales.id', '=', 'atenciones.sucursal_id')
                                    ->where('atenciones.profesional_rut', '=', $request->input('rutExcel'))
                                    ->get(); 

           foreach ($atenciones as $atencion) {
                $atencion->abono        = $atencion->abono;
           }

        return Excel::create('ListadoAtenciones', function($excel) use ($atenciones) {
            $excel->sheet('Atenciones', function($sheet) use ($atenciones)
            {
                $count = 2;
                #Se da formato a una celda en específico
                $sheet->setColumnFormat(array(
                    'A' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY,
                    'B' => \PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4,
                    'E' => \PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_USD
                ));
                #Títulos de encabezado
                $sheet->row(1, ['Fecha', 'Hora', 'Sucursal', 'Paciente', 'Abono']);
                #Se aplica estilo para las celdas
                $sheet->cells('A1:F1'.$count, function($cells) {
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
                    #Contenido de la tabla
                    $sheet->row($count, [$value->fecha, $value->hora, $value->sucursal, $value->paciente, $value->abono]);
                    $count = $count +1;
                }
            });
        })->download('xlsx');

    }

    public function cargarProfesionales(Request $request)
    {
        if ($request->ajax()) {
            $profesionales        = [];
            #Obtiene datos de profesionales
            $profesionales        = Profesional::select('profesionales.rut',  DB::raw("CONCAT(profesionales.nombres, ' ', profesionales.apellido_paterno, ' ', profesionales.apellido_materno) As nombre_profesional"))->get();

            $profesionales        = $profesionales->pluck('rut', 'nombre_profesional');

            return response()->json([
                "profesionales"    => $profesionales
            ]);
        }
    }

}
