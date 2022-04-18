<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UsuarioResource;
use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ppfp(Request $request)
    {

        $q = $request->get('q');
        $ppfp = User::Join(
            "proyecto_persona_forma_pagos",
            "users.id",
            "proyecto_persona_forma_pagos.id_usuario"
        )->join(
            "producto_orden_compras",
            "proyecto_persona_forma_pagos.id_proyecto_persona_forma_pago",
            "producto_orden_compras.id_proyecto_persona_forma_pago"
        )

            ->select(
                'proyecto_persona_forma_pagos.*',
                'users.name',
                'users.facebook',
                'users.tel_contacto',
                'producto_orden_compras.id_orden_compra'

            )
            ->where('tel_contacto', $q)
            ->orwhere('facebook', $q)
            ->paginate(20);


        return UsuarioResource::collection($ppfp);
    }
}
