<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuario;

class UsuarioController extends Controller
{
    //

    public function getRoles(Request $request)
    {
        dd("Hola");
        if ($request->ajax()) {
            $usuario = Usuario::select('rut', 'rol')->where('email','=',$request->input('valor'))->get();
            $counter = count($usuario);
            foreach ($usuario as $key => $value) {
            	$usuario = $value->rol;
                if ($usuario == null) {
                    $user = Usuario::find($value->rut);
                    $user->rol_select = null;
                    $user->save();
                }
            }

            if($counter > 0){
                return response()->json([
                    "usuario" => $usuario,
                    "count" => $counter
                ]);
            }else{
                return response()->json([
                    "usuario" => ' ',
                    "count" => '-1'
                ]);
            }
        }
    }

    public function saveRol(Request $request)
    {
        dd("Hola");
        if ($request->ajax()) {
            $usuario = Usuario::select('rut')->where('email','=',$request->input('email'))->get();
            $counter = count($usuario);

            if($counter > 0){
                $user = Usuario::find($usuario[0]->rut);
                $user->rol_select = $request->input('valor');
                $user->save();
                return response()->json([
                    "usuario" => $usuario,
                    "count" => $counter
                ]);
            }else{
                return response()->json([
                    "usuario" => ' ',
                    "count" => '-1'
                ]);
            }
        }
    }

    public function saveRolGoogle(Request $request)
    {
        dd("Hola");
        if ($request->ajax()) {
            $usuario = Usuario::select('rut')->where('email','=',$request->input('email'))->get();
            $counter = count($usuario);

            if($counter > 0){
                $user = Usuario::find($usuario[0]->rut);
                $user->rol_select = $request->input('valor');
                $user->save();
                auth()->login($user, true);
                return response()->json([
                    "usuario" => $usuario,
                    "count" => $counter
                ]);
            }else{
                return response()->json([
                    "usuario" => ' ',
                    "count" => '-1'
                ]);
            }
        }
    }


}
