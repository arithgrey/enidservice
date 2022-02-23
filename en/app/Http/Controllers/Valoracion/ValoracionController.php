<?php

namespace App\Http\Controllers\Valoracion;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Models\Valoracion;
use App\Http\Requests\ValoracionRequest;
use Illuminate\Http\Request;

class ValoracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        return Inertia::render("Valoraciones/Listado", [

            'valoraciones' => Valoracion::latest()
                ->where('titulo', 'LIKE', "%$request->q%")
                ->get()
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValoracionRequest $request)
    {

        $valoracion = Valoracion::create($request->all());



        return redirect()->route('valoracion.index')->with('status', 'Recibimos tu reseña!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Http\Response
     */
    public function show(Valoracion $valoracion)
    {
        return Inertia::render("Valoraciones/Detalle", [

            'valoracion' => $valoracion
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Http\Response
     */
    public function edit(Valoracion $valoracion)
    {
        return Inertia::render("Valoraciones/Editar", [

            'valoracion' => $valoracion
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Valoracion $valoracion)
    {

        $request->validate([
            'status' => "integer|between:1,5"
        ]);
        $valoracion->update($request->all());
        return back()->with('status', 'Actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Valoracion $valoracion)
    {
        $valoracion->delete();
        return redirect()->route('valoracion.index')->with('status', 'Valoración eliminada');
    }
}
