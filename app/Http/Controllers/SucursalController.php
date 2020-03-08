<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use Yajra\DataTables\Datatables;
use Illuminate\Support\Facades\DB;
use Malahierba\ChileRut\ChileRut;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
use App\Notificacion;
use App\Log;
use App\LogErrores;
use App\Usuario;
use App\Sucursal;
use DateTime;
use helpers;
use Morris;
use Auth;

class SucursalController extends Controller
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
        //
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

    public function getTabla(Request $request)
    {
        $sucursales     =   Sucursal::all();

        foreach ($sucursales as $sucursal) {
            if (is_null($sucursal->telefono)) {
                $sucursal->telefono = 'No tiene télefono';
            }
        }

        return Datatables::of($sucursales)->make(true);
    }

    public function cargarSucursales(Request $request)
    {
        if ($request->ajax()) {
            $sucursales        = [];

            $sucursales        = Sucursal::get();

            $sucursales        = $sucursales->pluck('id', 'nombre');

            return response()->json([
                "sucursales"    => $sucursales
            ]);
        }
    }
}
