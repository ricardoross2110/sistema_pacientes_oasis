<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\DB;
use Malahierba\ChileRut\ChileRut;
use Maatwebsite\Excel\Facades\Excel;

use App\LogAccion;
use Auth;

use App\Perfil;
use App\Usuario;
use App\UsuarioSucursal;
use App\Sucursal;
use helpers;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rutB = \Request::get('rutB');

        $perfiles = [];
        #Usuario podrá visualizar usuarios de igual o menor "rango", en este caso mayor número id
        foreach(Perfil::where('id','>=', Auth::user()->perfil_id)->orderBy('nombre', 'asc')->get() as $perfil):
            $perfiles[$perfil->id] = $perfil->nombre;
        endforeach;

        $sucursales = [];
        foreach (Sucursal::orderBy('nombre', 'asc')->get() as $sucursal) {
            $sucursales[$sucursal->id] = $sucursal->nombre ;
        }


        return view('usuarios.index')->with('rutB', $rutB)->with(array('perfiles' => $perfiles))->with(array('sucursales' => $sucursales));
    }

    public function getTabla(Request $request)
    {
        $rut                = $request->input('rutB');
        $apellido_paternoB  = $request->input('apellido_paternoB');
        $estado             = $request->input('estadoB');
        $perfil             = $request->input('perfilB');
        #Obtiene datos que cumplan con los filtros de búsqueda
        $usuarios = DB::table('usuarios')
                    ->select('rut', 'dv', 'email', 'usuarios.perfil_id', 'perfiles.nombre as perfil', 'estado', DB::raw("concat(usuarios.nombres, ' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno) as nombres"))
                    ->join('perfiles', 'perfiles.id', '=', 'usuarios.perfil_id')
                    ->where('perfil_id','>=', Auth::user()->perfil_id);

        if(!is_null($rut)){
            $usuarios = $usuarios->where('rut','=',$rut);
        }

        if(!is_null($apellido_paternoB)){
            $usuarios = $usuarios->where('apellido_paterno','LIKE','%'. $apellido_paternoB.'%');
        }

        if(!is_null($perfil)){
            $usuarios = $usuarios->where('perfil_id','=', $perfil);
        }

        if(!is_null($estado) && $estado <> "all"){
            $usuarios = $usuarios->where('usuarios.estado','=', $estado);
        }

        $usuarios = $usuarios->orderBy('rut', 'asc')->get();

        #Si el estado es 1 entonces es Activo, caso contrario es Inactivo
        foreach ($usuarios as $usuario){
            if ( $usuario->estado == 1 ){
                $usuario->estado = "Activo";
            }else{
                $usuario->estado = "Inactivo";
            }
        }

        return Datatables::of($usuarios)
            ->addColumn('rut', function ($usuarios){                
                            return '<a href="'.url('/usuarios/').'/'.$usuarios->rut.'" title=Detalle>'.$usuarios->rut.'</a>';
            })
            ->addColumn('action', function ($usuarios) {
                if ($usuarios->estado == 'Activo') {
                    if($usuarios->rut == Auth::user()->rut){
                        #Un usuario no podrá eliminarse a si mismo
                        return '<a class="iconos" href="'.url('/usuarios/').'/'.$usuarios->rut.'/edit" title="Editar" >
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>';
                    }else{
                        return '<a class="iconos" href="'.url('/usuarios/').'/'.$usuarios->rut.'/edit" title="Editar" >
                                    <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                                </a>
                                <a class="iconos" href="#" data-toggle="modal" data-target="#modal-eliminar_'.$usuarios->rut.'" title="Eliminar" >
                                    <span class="fa fa-trash-o" aria-hidden="true"></span>
                                </a>
                                <div class="modal fade" id="modal-eliminar_'.$usuarios->rut.'" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-red">
                                                <h4 class="modal-title">Confirmar eliminación</h4>
                                            </div>

                                            <div class="modal-body">
                                                <h3>¿Está seguro de eliminar a este usuario?</h3>
                                            </div>
                                            
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                                <a href="'.url('/usuarios/destroy').'/'.$usuarios->rut.'" type="submit" class="btn btn-danger" role="button">Aceptar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                    }
                }else{
                    return '<a class="iconos" href="#" data-toggle="modal" data-target="#modal-activar_'.$usuarios->rut.'" title="Activar" >
                                <span class="fa fa-check-circle" aria-hidden="true"></span>
                            </a>
                            <div class="modal fade" id="modal-activar_'.$usuarios->rut.'" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-green">
                                            <h4 class="modal-title">Confirmar activación</h4>
                                        </div>

                                        <div class="modal-body">
                                            <h3>¿Está seguro de activar este a usuario?</h3>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                                            <a href="'.url('/usuarios/activate').'/'.$usuarios->rut.'" type="submit" class="btn btn-success" role="button">Aceptar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                }
        })->rawColumns(['rut','action'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        #Un administrador (2) sólo podrá crear administrador, secretaria y asistente 
        if (Auth::user()->perfil_id == 2) {
            $perfiles = Perfil::where('id', '>', 1)->get();
        }else{
            $perfiles = Perfil::get();
        }

        $sucursales = Sucursal::get();

        return view('usuarios.index', compact('perfiles',$perfiles))->with('sucursales', $sucursales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->input('rut'))){
            return redirect()->route('usuarios.index')->withInput()->with('error','Debe ingresar un RUT');
        }else{
            $usuario = Usuario::where('rut', '=', $request->input('rut'))->get();
            if (count($usuario) > 0) {
                return redirect()->route('usuarios.index')->withInput()->with('error','Este RUT ya fue ingresado anteriormente');
            }
        }
        if(is_null($request->input('dv'))){
            return redirect()->route('usuarios.index')->withInput()->with('error','Debe ingresar dígito verificardor');
        }elseif(empty($request->input('nombres'))){
            return redirect()->route('usuarios.index')->withInput()->with('error','Debe ingresar los nombres');
        }elseif(empty($request->input('apellidoPaterno'))){
            return redirect()->route('usuarios.index')->withInput()->with('error','Debe ingresar el apellido paterno');
        }elseif(empty($request->input('apellidoMaterno'))){
            return redirect()->route('usuarios.index')->withInput()->with('error','Debe ingresar el apellido materno');
        }
        #Verificar si RUT ingresado es válido
        $rut_validar = $request->input('rut').'-'.$request->input('dv');
        #Verificar si correo electrónico ingresado es válido
        $correo = $request->input('email');
        $resp   = false;
        if (filter_var($correo, FILTER_VALIDATE_EMAIL))
        {
            $resp = true;
        }
        if($resp == false){
            return redirect()->route('usuarios.index')->withInput()->with('error','El correo electrónico incorrecto');
        }
        #Compara las contraseñas, verifica si son iguales
        if( $request->input('contrasena') != $request->input('recontrasena')){
            return redirect()->route('usuarios.index')->withInput()->with('error','Error al repetir contraseña');
        }

        $rutValido = true;
        if ($rutValido){
            $counter = Usuario::where('email','=',$request->input('email'))->count();
            #El correo ingresado no puedo estar asociado a otro usuario, debe ser 0
            if($counter == 0){
                $rut = str_replace('k', 'K', $request->input('rut'));

                $usuario = new Usuario;
                $usuario->rut = $rut;
                $usuario->dv  = $request->input('dv');
                $usuario->perfil_id = $request->input('perfil');

                $timeZone = 'America/Santiago'; 
                date_default_timezone_set($timeZone); 
                $now = date_create();
                $usuario->fecha_registro = date_format($now, 'Y-m-d H:i:s');

                $count = mb_strlen($request->input('nombres'), 'UTF-8');
                if($count > 50){
                    return back()->with('error', 'Los nombres son demasiado largos, el máximo permitido es de 50 caracteres');
                }else{
                    $usuario->nombres = $request->input('nombres');
                }

                $count = mb_strlen($request->input('apellidoPaterno'), 'UTF-8');
                if($count > 25){
                    return back()->with('error', 'El apellido paterno es demasiado largo, el máximo permitido es de 25 caracteres');
                }else{
                    $usuario->apellido_paterno = $request->input('apellidoPaterno');
                }

                $count = mb_strlen($request->input('apellidoMaterno'), 'UTF-8');
                if($count > 25){
                    return back()->with('error', 'El apellido materno es demasiado largo, el máximo permitido es de 25 caracteres');
                }else{
                    $usuario->apellido_materno = $request->input('apellidoMaterno');
                }

                $count = mb_strlen($request->input('email'), 'UTF-8');
                if($count > 100){
                    return back()->with('error', 'El correo electrónico es demasiado largo, el máximo permitido es de 100 caracteres');
                }else{
                    $usuario->email = $request->input('email');
                }

                $password  = $request->input('contrasena');
                #Verifica si la contraseña es válida
                if(!is_null($password)){

                    $resp = false;
                    if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.])([A-Za-z\d.]|[^ ]){6,25}$/",$password))
                    {
                        $resp = true;
                    }
                    if($resp == false){
                        return back()->with('error', 'Contraseña incorrecta');
                    }

                    $count = mb_strlen($password, 'UTF-8');
                    if($count > 25){
                        return back()->with('error', 'La contraseña es demasiado larga, el máximo permitido es de 25 caracteres');
                    }else{
                        $usuario->password = bcrypt($password);
                    }
                }else{
                    return back()->with('error', 'Debe ingresar una contraseña');
                }

                $usuario->estado  = 1;

                $usuario->save();

                //Guarda log al crear
                LogAccion::create([
                    'accion' => "Agregar Usuario",
                    'detalle' => "Se crea Usuario: " . $request->input('nombres')." ".$request->input('apellidoPaterno')." ".$request->input('apellidoMaterno'),
                    'usuario_rut' => Auth::user()->rut,
                ]);


                $usuario_sucursal                   =   new UsuarioSucursal;
                $usuario_sucursal->usuario_rut      =   $rut;
                $usuario_sucursal->sucursal_id      =   $request->input('sucursal');
                $usuario_sucursal->save();


                //return redirect()->route('usuarios.index');
                return redirect()->route('usuarios.index')->with('success','Usuario creado exitosamente');
            }else{
                return redirect()->route('usuarios.index')->with('error','El correo electrónico ingresado ya está asociado a otro usuario');
            }
        }else{
            return redirect()->route('usuarios.index')->with('error','RUT ingresado es incorrecto, por favor intente nuevamente');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($rut)
    {

        $usuario = Usuario::find($rut);
        #Si estado es 1 es Activo, caso contrario es Inactivo
        if ( $usuario->estado == 1 ){
            $usuario->estado = "Activo";
        }else{
            $usuario->estado = "Inactivo";
        }

        return view('usuarios.show')->with('usuario',$usuario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($rut)
    {
        $usuario = Usuario::find($rut);
        $sucursalActual = UsuarioSucursal::where('usuario_rut', '=', $rut)->first();

        $perfiles = [];
        #Al editar usuario, el administrador solo puede crear administrador, secretaria y asistente
        foreach(Perfil::where('id','>=', Auth::user()->perfil_id)->orderBy('nombre', 'asc')->get() as $perfil):
            $perfiles[$perfil->id] = $perfil->nombre;
        endforeach;

        $sucursales = [];
        foreach (Sucursal::orderBy('nombre', 'asc')->get() as $sucursal) {
            $sucursales[$sucursal->id] = $sucursal->nombre ;
        }

        return view('usuarios.edit', compact('usuario', 'perfiles'))->with(array('sucursales' => $sucursales))->with('sucursalActual', $sucursalActual->sucursal_id);
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
            return redirect()->route('usuarios.edit', $rut)->with('error','Debe ingresar un nombre');
        }elseif(empty($request->input('apellido_paterno'))){
            return redirect()->route('usuarios.edit', $rut)->with('error','Debe ingresar un apellido paterno');
        }elseif(empty($request->input('apellido_materno'))){
            return redirect()->route('usuarios.edit', $rut)->with('error','Debe ingresar un apellido materno');
        }
        #Verifica si el correo electrónica es válido
        if (!is_null($request->input('email'))) {
            $correo = $request->input('email');
            $resp   = false;
            if (filter_var($correo, FILTER_VALIDATE_EMAIL))
            {
                $resp = true;
            }
            if($resp == false){
                return redirect()->route('usuarios.index')->withInput()->with('error','Correo electrónico ingresado es incorrecto');
            }
        }

        $usuario = Usuario::find($rut);    
        $nombresAntiguo = $usuario->nombres;
        $correoAntiguo = $usuario->email;
        if($rut != Auth::user()->rut){
            $usuario->perfil_id = $request->input('perfil_id');
        }
        
        $count = mb_strlen($request->input('nombres'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'Los nombres son demasiado largos, el máximo permitido es 25 caracteres');
        }else{
            $usuario->nombres = $request->input('nombres');
        }

        $count = mb_strlen($request->input('apellido_paterno'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'El apellido paterno demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $usuario->apellido_paterno = $request->input('apellido_paterno');
        }

        $count = mb_strlen($request->input('apellido_materno'), 'UTF-8');
        if($count > 25){
            return back()->with('error', 'El apellido materno demasiado largo, el máximo permitido es 25 caracteres');
        }else{
            $usuario->apellido_materno = $request->input('apellido_materno');
        }


        $counter = Usuario::where('email','=',$request->input('email'))->count();
        #Verifica si el correo ingresado está asociado a otro usuario o no
        if($counter == 0 || $correoAntiguo == $request->input('email')){
            $count = mb_strlen($request->input('email'), 'UTF-8');
            if($count > 100){
                return back()->with('error', 'El correo electrónico es demasiado largo, el máximo permitido es 100 caracteres');
            }else{
                $usuario->email = $request->input('email');
            }
        }else{
            return redirect()->route('usuarios.index')->with('error','Correo electrónico ingresado ya está asociado a otro usuario');
        }

        $password = $request->input('contrasena');
        #Verifica si contraseña es válida
        if(!is_null($password)){

            $resp = false;
            if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.])([A-Za-z\d.]|[^ ]){6,25}$/",$password))
            {
                $resp = true;
            }
            if($resp == false){
                return redirect()->route('usuarios.index')->withInput()->with('error','Password incorrecta');
            }

            $count = mb_strlen($password, 'UTF-8');
            if($count > 25){
                return back()->with('error', 'Contraseña demasiado larga, el máximo permitido es 25 caracteres');
            }else{
                $usuario->password = bcrypt($password);
            }
        }
        
        $usuario->save();

        $sucursalActual = UsuarioSucursal::where('usuario_rut', '=', $rut)->delete();

        $usuario_sucursal                   =   new UsuarioSucursal;
        $usuario_sucursal->usuario_rut      =   $rut;
        $usuario_sucursal->sucursal_id      =   $request->input('sucursal');
        $usuario_sucursal->save();

        #Guarda log al editar usuario
        LogAccion::create([
                    'accion' => "Editar Usuario",
                    'detalle' => "Se editó datos de Usuario: " . $request->input('nombres')." ".$request->input('apellidoPaterno')." ".$request->input('apellidoMaterno'),
                    'usuario_rut' => Auth::user()->rut,
                ]);

        return redirect()->route('usuarios.index')->with('success','Usuario editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rut)
    {
        $usuario = Usuario::find($rut);
        if(!is_null($usuario)){
            $usuario->estado  = 0;

            $usuario->save();
            #Guarda log al desactivar usuario
            LogAccion::create([
                    'accion' => "Desactivar Usuario",
                    'detalle' => "Se desactivó Usuario: " .$rut,
                    'usuario_rut' => Auth::user()->rut,
                ]);

            return redirect()->route('usuarios.index')->with('success','Usuario eliminado correctamente');
        }else{
            return redirect()->route('usuarios.index')->with('error','Registro no existe');
        }
    }

    public function activate($rut)
    {
        $usuario = Usuario::find($rut);
        if(!is_null($usuario)){
            $usuario->estado  = 1;

            $usuario->save();
            #Guarda log al activar usuario
            LogAccion::create([
                    'accion' => "Activar Usuario",
                    'detalle' => "Se activó Usuario: " .$rut,
                    'usuario_rut' => Auth::user()->rut,
                ]);

            return redirect()->route('usuarios.index')->with('success','Usuario activado correctamente');
        }else{
            return redirect()->route('usuarios.index')->with('error','Registro no existe');
        }
    }

    public function exportExcel(Request $request)
    {
        $rut                = $request->input('rutExcel');
        $apellido_paternoB  = $request->input('apellido_paternoExcel');
        $estado             = $request->input('estadoExcel');
        $perfil             = $request->input('perfilExcel');

        #Se obtienen datos de usuarios que coincidan con filtro de búsqueda
        $usuarios = DB::table('usuarios')->select('rut', 'dv', 'email', 'usuarios.perfil_id', 'perfiles.nombre as perfil', 'estado', DB::raw("concat(usuarios.nombres, ' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno) as nombres"))
                    ->join('perfiles', 'perfiles.id', '=', 'usuarios.perfil_id')
                    ->where('perfil_id','>=', Auth::user()->perfil_id);

        if(!is_null($rut)){
            $usuarios = $usuarios->where('rut','=',$rut);
        }

        if(!is_null($apellido_paternoB)){
            $usuarios = $usuarios->where('apellido_paterno','LIKE','%'. $apellido_paternoB.'%');
        }

        if(!is_null($perfil)){
            $usuarios = $usuarios->where('perfil_id','=', $perfil);
        }

        if(!is_null($estado) && $estado <> "all"){
            $usuarios = $usuarios->where('usuarios.estado','=', $estado);
        }

        $usuarios = $usuarios->orderBy('rut', 'asc')->get();
        #Si el estado es 1 es Activo, caso contrario es Inactivo
        foreach ($usuarios as $usuario){
            if ( $usuario->estado == 1 ){
                $usuario->estado = "Activo";
            }else{
                $usuario->estado = "Inactivo";
            }
        }

        return Excel::create('ListadoUsuarios', function($excel) use ($usuarios) {
            $excel->sheet('Usuarios', function($sheet) use ($usuarios)
            {
                $count = 2;
                
                $sheet->row(1, ['RUT', 'DV', 'Nombre', 'Correo', 'Perfil', 'Estado']);
                $sheet->cells('A1:F1', function($cells) {
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                });
                foreach ($usuarios as $key => $value) {
                    $sheet->row($count, [$value->rut, $value->dv, $value->nombres, $value->email, $value->perfil, $value->estado]);
                    $count = $count +1;
                }
            });
        })->download('xlsx');
    }

    public function changePassword(Request $request){

        $usuario = Usuario::find($request->input('rut_usuario')); 
        #Comprueba si ambas contraseñas sean iguales
        if( $request->input('contrasena') != $request->input('recontrasena')){
            return redirect()->action('UsuarioController@edit', ['rut' => $request->input('rut_usuario')])->withInput()->with('error','Error al repetir la contraseña');
        }
        $password  = $request->input('contrasena');
        #Verificar si la contraseña es válida
        if(!is_null($password)){

            $resp = false;
            if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.])([A-Za-z\d.]|[^ ]){6,25}$/",$password))
            {
                $resp = true;
            }
            if($resp == false){
                return back()->with('error', 'Contraseña incorrecta');
            }

            $count = mb_strlen($password, 'UTF-8');
            if($count > 25){
                return back()->with('error', 'La contraseña es demasiado larga, el máximo permitido es de 25 caracteres');
            }else{
                $usuario->password = bcrypt($password);
                $usuario->save();
                #Guarda log al cambiar contraseña usuario
                LogAccion::create([
                    'accion' => "Cambiar contraseña Usuario",
                    'detalle' => "Se cambió contraseña de Usuario: " . $request->input('rut_usuario'),
                    'usuario_rut' => Auth::user()->rut,
                ]);
                //return redirect()->route('usuarios.index')->with('success','Se cambió la contraseña exitosamente');
                return redirect()->action('UsuarioController@edit', ['rut' => $request->input('rut_usuario')])->withInput()->with('success','Se cambió la contraseña exitosamente');
            }
        }else{
            return back()->with('error', 'Debe ingresar una contraseña');
        }
    }

    public function cargarSecretarias(Request $request)
    {
        if ($request->ajax()) {
            $secretarias        = [];
            #Obtiene datos de secretarias
            $secretarias        = Usuario::select('usuarios.rut',
                                                    DB::raw("CONCAT(usuarios.nombres, ' ', usuarios.apellido_paterno, ' ', usuarios.apellido_materno) As nombre_usuario")
                                                )
                                            ->where('usuarios.perfil_id', '=', 3)
                                            ->orderBy('nombre_usuario')
                                            ->get();

            $secretarias        = $secretarias->pluck('rut', 'nombre_usuario');

            return response()->json([
                "secretarias"    => $secretarias
            ]);
        }
    }
}
