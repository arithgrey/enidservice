<?php

namespace App\Http\Controllers\ListaNegra;

use App\Http\Controllers\Controller;
use App\Models\ListaNegra;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListaNegraController extends Controller
{
    
    public function index(Request $request)
    {

        $q = $request->get('q');
        $lista_negra = ListaNegra::join('users', 'lista_negras.id_usuario', 'users.id')
            ->select('lista_negras.*')
            ->with('user', 'motivo')
            ->where('users.name', 'LIKE', "%$q%")
            ->orwhere('users.facebook', 'LIKE', "%$q%")
            ->orwhere('users.tel_contacto', 'LIKE', "%$q%")
            ->orwhere('users.email', 'LIKE', "%$q%")
            ->orwhere('users.url_lead', 'LIKE', "%$q%")
            ->paginate(15);

        return Inertia::render("ListaNegra/Listado", [

            'lista_negra' => $lista_negra
        ]);
    }
}
