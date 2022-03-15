<?php

namespace App\Http\Controllers\SolicitudRetiro;

use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitudRetiroRequest;
use App\Models\Banco;
use App\Models\SolicitudRetiro;
use Illuminate\Http\Request;


class SolicitudRetiroController extends Controller
{


    public function index(Request $request)
    {

        $status = $request->get('status');
        $q = $request->get('q');

        $solicitudes_retiro =
            SolicitudRetiro::join('users', 'solicitud_retiros.user_id', 'users.id')
            ->select('solicitud_retiros.*')
            ->with('user', 'cuenta_banco')
            ->where('users.name', 'LIKE', "%$q%")
            ->jstatus($status)
            ->paginate(5);


        return Inertia::render("SolicitudesRetiro/Listado", [

            'solicitudes_retiro' => $solicitudes_retiro,
            'bancos' => Banco::all(),

        ]);
    }

    public function store(SolicitudRetiroRequest $request)
    {

        SolicitudRetiro::create($request->all());

        return redirect()
            ->route('solicitud-retiro.index')
            ->with('status', 'Recibimos tu solicitud tu dinero está en camino,
            llegará en un plazo no mayor a 24 hrs');
    }
    public function update(Request $request, SolicitudRetiro $solicitudRetiro)
    {

        $request->validate([
            'status' => 'required',

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
}
