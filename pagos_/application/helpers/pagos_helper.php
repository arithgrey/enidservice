<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  

  
  function crea_saldo_disponible($param , $porcentaje_comision){

    $total_disponible = 0;    
    
    foreach ($param as $row) {
  
    
      $saldo_cubierto = $row["saldo_cubierto"];

      $monto_a_pagar = $row["monto_a_pagar"];

      $saldo_cubierto_envio = $row["saldo_cubierto_envio"];
      $flag_envio_gratis  = $row["flag_envio_gratis"];
      $costo_envio_cliente = $row["costo_envio_cliente"];
      $num_ciclos_contratados = $row["num_ciclos_contratados"];
      $costo_envio_vendedor   = $row["costo_envio_vendedor"];

      $monto_total_a_pagar = ($monto_a_pagar)*($num_ciclos_contratados);
      if($saldo_cubierto>= $monto_total_a_pagar){        
        if($flag_envio_gratis ==  0){
          
          if($saldo_cubierto_envio >= $costo_envio_cliente ) {
            
            $monto_aplicando_comision=  
            aplica_comision($num_ciclos_contratados,$porcentaje_comision,$monto_a_pagar);
            $total_disponible = $total_disponible + $monto_aplicando_comision;      

          }          
        }else{
          
            $monto_aplicando_comision=  
            aplica_comision($num_ciclos_contratados,$porcentaje_comision,$monto_a_pagar);
            
            $monto_aplicando_comision_menos_envio
            = $monto_aplicando_comision - $costo_envio_vendedor;
            $total_disponible = 
            $total_disponible + $monto_aplicando_comision_menos_envio;      
        }          
      }        
    }
    return $total_disponible;
  }  
  
  
  
   
}