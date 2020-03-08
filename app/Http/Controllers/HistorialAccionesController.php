<?php

namespace App\Http\Controllers;

use App\HistorialAcciones;
use Illuminate\Http\Request;

class HistorialAccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('Historial de Acciones');
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
     * @param  \App\HistorialAcciones  $historialAcciones
     * @return \Illuminate\Http\Response
     */
    public function show(HistorialAcciones $historialAcciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HistorialAcciones  $historialAcciones
     * @return \Illuminate\Http\Response
     */
    public function edit(HistorialAcciones $historialAcciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HistorialAcciones  $historialAcciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HistorialAcciones $historialAcciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HistorialAcciones  $historialAcciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(HistorialAcciones $historialAcciones)
    {
        //
    }
}
