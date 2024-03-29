<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Models\ListaNegra;
use App\Models\OrdenComentario;
use App\Models\OrdenCompra;
use App\Models\ProductoOrdenCompra;
use App\Models\ProyectoPersonaFormaPago;

use App\Models\User;
use Inertia\Inertia;

class LeadController extends Controller
{

    public function store(LeadRequest $request)
    {
        $params = $request->all();
        $user = User::factory()->create();
        $user->update($params);

        $ppfp = $this->ppfp_cancelado($user, $request);
        $orden_compra = $this->orden_compra_cancelada();


        if ($ppfp->id > 0 && $orden_compra->id > 0) {

            $this->producto_orden_compra_cancelado($ppfp, $orden_compra);
            $this->lista_negra($user, $request);
            $this->comentario_orden_compra($orden_compra, $request);

            return response()->json(['message' => 'Success'], 200);
        }
    }

    private function comentario_orden_compra(OrdenCompra $orden_compra, LeadRequest $request)
    {

        OrdenComentario::create([
            "comentario" => $request->comentario,
            "id_orden_compra" => $orden_compra->id

        ]);
    }

    private function lista_negra($user, LeadRequest $request)
    {
        if ($request->tipo) {

            ListaNegra::create([
                'id_usuario' => $user->id,
                'id_motivo' => 5, /*Person conflictiva */
            ]);
        }
    }

    private function producto_orden_compra_cancelado($ppfp, $orden_compra)
    {
        return ProductoOrdenCompra::create([
            'id_proyecto_persona_forma_pago' => $ppfp->id,
            'id_orden_compra' => $orden_compra->id
        ]);
    }

    private function orden_compra_cancelada()
    {
        return OrdenCompra::create([
            'status' => 0,
            'cobro_secundario' => 0,
        ]);
    }
    private function ppfp_cancelado($user, LeadRequest $request)
    {

        return ProyectoPersonaFormaPago::create([
            'id_forma_pago' => 7,
            'id_usuario_referencia' => $user->id,
            'id_usuario' => $user->id,
            'id_usuario_venta' => $user->id,
            'status' => 10,
            'num_ciclos_contratados' => 1,
            'id_servicio' => 1110,
            'se_cancela' => 1,
            'saldo_cubierto' => 0,
            'monto_a_pagar' => 1,
            'nota' => $request->comentario,
            'resumen_pedido' => 'Pedido - nota previa - cuidado',
        ]);
    }
}
