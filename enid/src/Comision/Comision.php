<?php 

namespace Enid\Comision;

class Comision{

	function saldo_disponible($comisiones_por_cobrar = [] , $recompensas = [])
    {    

        $response = 0;
        $adicionales = 0; 
        if (es_data($comisiones_por_cobrar)) {
            
            $total_descuento = array_sum(array_column($recompensas, "descuento"));        
            $utilidad = 0;
            $id_orden_actual = 0; 
            foreach($comisiones_por_cobrar as $row){                        
                
                $id_orden_compra = $row["id_orden_compra"];
                $precio = ($row["precio"] * $row["num_ciclos_contratados"]);

                if ($id_orden_actual != $id_orden_compra) {
                    
                    $total_por_orden_compra = $this->cobro_por_orden_compra($comisiones_por_cobrar, $id_orden_compra);
                    $monto_cobro_extra = $this->cobro_secundario_ordenes_compra($comisiones_por_cobrar, $id_orden_compra);
                    
                    if ($monto_cobro_extra > $total_por_orden_compra) {
                        
                        $diferencia = ($monto_cobro_extra - $total_por_orden_compra);
                        $adicionales = $adicionales + $diferencia;
                    }
                    
                    $id_orden_actual = $id_orden_compra;
                }

                $utilidad = $utilidad + $precio;

            }
            
            $utilidad_descuento = $utilidad - $total_descuento;
            $response = (comision_porcentaje($utilidad_descuento,10) + $adicionales);
        }
        return $response;
    }
    function cobro_por_orden_compra($comisiones_por_cobrar, $id_orden_compra)
    {
   
        $monto = 0;
        foreach($comisiones_por_cobrar as $row){
            
            $cobro_secundario = $row["cobro_secundario"];
            if ($id_orden_compra == $row["id_orden_compra"] ) {

                $precio = ($row["precio"] * $row["num_ciclos_contratados"]);
                $monto = $monto + $precio;
            }
            
        }

        return $monto;
    }
    function cobro_secundario_ordenes_compra($comisiones_por_cobrar, $id_orden_compra)
    {
   
        $monto = 0;
        foreach($comisiones_por_cobrar as $row){
            
            $cobro_secundario = $row["cobro_secundario"];
            if ($id_orden_compra == $row["id_orden_compra"] && $cobro_secundario > 0  ) {

                $monto = $cobro_secundario;
                break;
            }
            
        }

        return $monto;
    }
    
}