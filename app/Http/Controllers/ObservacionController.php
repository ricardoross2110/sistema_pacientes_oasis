<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\LogAccion;
use Auth;

use App\Observacion;

class ObservacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$atencion_id	=	$request->input('atencion_id');
    	$num_folio 	 	=	$request->input('num_folio');
        #Si al observación ingresada está vacía mostrará mensaje de error
        if (empty($request->input('texto_observacion'))) {
            return redirect()->action('AtencionController@observacion', ['id' => $atencion_id])->withInput()->with('error','Ingrese un comentario');
        }
        #Caso contrario, se guardará observación
        $observacion 				=	new Observacion();
        $observacion->atencion_id 	=	$atencion_id;
        $observacion->observacion 	=	$request->input('texto_observacion');
        $observacion->fecha 		=	date_format(date_create('America/Santiago'), 'Y-m-d H:i:s');
        $observacion->save();
        #Guarda log al guardar observación
        LogAccion::create([
                    'accion' => "Guardar observación",
                    'detalle' => "Se guarda observación del número de atención ".$request->input('atencion_id')." y del tratamiento ".$request->input('num_folio'),
                    'usuario_rut' => Auth::user()->rut,
                ]);
        #Muestra detalle del tratamiento que se estaba agregando observación
    	return redirect()->action('TratamientoController@show', ['folio' => $num_folio])->with('success','Se guardó la observación correctamente');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }
}
