<?php

namespace App\Http\Controllers\Backend\Valoracion;

use App\Http\Controllers\Controller;
use App\Models\Valoracion;
use App\Http\Requests\ValoracionRequest;

class ValoracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('valoraciones.index',
            [
                'valoraciones' => Valoracion::latest()->paginate()
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('valoraciones.crear');   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValoracionRequest $request)
    {
        
        dd($request);
        $post = Valoracion::create($request->all());

        return back()->with('status', 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Http\Response
     */
    public function show(Valoracion $valoracion)
    {
        return view('valoraciones.ver', ['valoracion' => $valoracion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Http\Response
     */
    public function edit(Valoracion $valoracion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Http\Response
     */
    public function update(ValoracionRequest $request, Valoracion $valoracion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Valoracion $valoracion)
    {
        //
    }
        
}
