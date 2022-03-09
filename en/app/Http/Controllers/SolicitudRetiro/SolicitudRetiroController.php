<?php

namespace App\Http\Controllers\SolicitudRetiro;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitudRetiroRequest;
use App\Models\SolicitudRetiro;
use Illuminate\Http\Request;


class SolicitudRetiroController extends Controller
{


    public function index(Request $request)
    {

        $solicitudRetiro = SolicitudRetiro::with('user')
            ->where('status', 0)
            ->paginate(10);

        return Inertia::render("SolicitudesRetiro/Listado", [

            'solicitudes_retiro' => $solicitudRetiro
        ]);
    }
    public function create()
    {

    }
    public function store(SolicitudRetiroRequest $request)
    {

        $request->user()->solicitudes_retiro()->create($request->all());

        return redirect()
            ->route('solicitud-retiro.index')
            ->with('status', 'Recibimos tu solicitud tu dinero está en camino,
            llegará en un plazo no mayor a 24 hrs');
    }
    public function update(Request $request, SolicitudRetiro $solicitudRetiro)
    {

        $request->validate([
            'status' => 'required'
        ]);

        $this->authorize('pass', $solicitudRetiro);

        $solicitudRetiro->update($request->all());

        return redirect()
            ->route('solicitud-retiro.index')
            ->with('status', 'Solicitud actualizada!');
    }
    public function destroy(SolicitudRetiro $solicitudRetiro)
    {

        $this->authorize('pass', $solicitudRetiro);

        $solicitudRetiro->delete();

        return redirect()
            ->route('solicitud-retiro.index')
            ->with('status', 'Solicitud eliminada!');
    }
    public function show(SolicitudRetiro $solicitudRetiro)
    {

        $this->authorize('pass', $solicitudRetiro);

        return Inertia::render(
            "SolicitudesRetiro/Listado",
            [
                'solicitudes_retiro' => $solicitudRetiro
            ]
        );
    }
}
