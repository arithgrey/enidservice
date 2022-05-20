<?php

namespace App\Http\Controllers\IndicadoresUbicaciones;

use App\Http\Controllers\Controller;
use App\Models\Delegacion;
use App\Models\Ubicacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class IndicadoresUbicacionesController extends Controller
{

    public function index(Request $request)
    {

        $solicitudes = $this->alcaldias_solicitudes($request);
        $indicadores  = [];
        if (is_array($solicitudes) && count($solicitudes) > 0) {

            $alcaldias = $this->alcaldias($solicitudes);
            $indicadores = $this->indicadores($alcaldias, $solicitudes);
        }

        return Inertia::render("IndicadoresUbicaciones/List", [

            'indicadores' => $indicadores
        ]);
    }
    private function indicadores($alcaldias, $solicitudes)
    {
        $response = [];
        $a = 0;
        foreach ($alcaldias as $row) {

            $id_delegacion =  $row["id_delegacion"];
            $response[$a] = $row;
            $response[$a]["total"] = $this->search_bi_array($solicitudes, "id_alcaldia", $id_delegacion, "total");
            $a++;
        }
        return $response;
    }
    function search_bi_array($array, $columna, $busqueda, $get = FALSE, $si_false = "")
    {

        $arr_col = array_column($array, $columna);
        $index = array_search($busqueda, $arr_col);
        $response = $index;

        if ($get !== FALSE) {

            $response = ($index !== FALSE) ? $array[$index][$get] : $si_false;
        }

        return $response;
    }
    private function alcaldias($solicitudes)
    {

        $ids =  array_column($solicitudes, 'id_alcaldia');
        return Delegacion::select("delegacion", "id_delegacion")->whereIn('id_delegacion', $ids)->get();
    }
    private function alcaldias_solicitudes(Request $request)
    {
        $fecha_inicio = $request->get('fecha_inicio');
        $fecha_termino = $request->get('fecha_termino');

        $select_count =  DB::raw('count(*) as total, id_alcaldia');
        $dates = [$fecha_inicio, $fecha_termino];
        $indicadores = Ubicacion::select($select_count)
            ->whereBetween('fecha_registro', $dates)
            ->groupBy('id_alcaldia')
            ->get();

        return $indicadores->toArray();
    }
}
