<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

  
  
  
  /*  

  
  
  function get_dominio($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
  }  
  
  function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
  } 
  
  function crea_array_unico($data , $columna ){      
       return unique_multidim_array($data, $columna);
  }  
  
  function valida_seccion_pago_visible($param){

      $extra_estilos =" style='display:none;' ";
      if(get_valor_variable($param , "externo") == 0 ) {
        
        $extra_estilos ="";
      }
      return $extra_estilos;
  }
  
  
  function get_random(){
    return  mt_rand();       
  }
  
  function evalua_accion_ticket($status){
    
    $btn  ="";

    if ($status == 0){

      $btn  ="    <button  
                    class='btn btn_mod_ticket input-sm'
                    style='background:black!important;'       
                    style='background:#E71E06!important;' 
                    id='1' >
                    Cerrar Ticket
                  </button>

                  <button  
                    class='btn btn_mod_ticket input-sm'  
                    style='background:#0656F9!important;' 
                    id='2' >
                    Dejar en visto
                  </button>
                  "; 
  
    }else{
      $btn  ="    <button  
                    class='btn btn_mod_ticket input-sm'                      
                    style='background:blue!important;' id='0' >
                    Abrir Ticket
                  </button>
                  <button  
                    class='btn btn_mod_ticket input-sm'  
                    style='background:#0656F9!important;' 
                    id='2' >
                    Dejar en visto
                  </button>
                  ";
    }



    
    return $btn;
  }
  
  function evalua_status_ticket($valor_actual , $valor_real){

    if ($valor_real ==  $valor_actual) {
      return "selected";
    }
  }
  
  function get_nombre_ciclo_facturacion($cliclo){

    $cliclos = ["", "Anual" , "Mensual" , "Semanal" , "No aplica" , "Anual a 3 meses" , "Anual a 4 meses" , "Anual a 6 meses"];
    return $cliclos[$cliclo];
  }
  
  

  function get_nombre_estados_pago($estado){

    $estados = ["Pendiente" , "Liquidado" , "Suspendido" , "Lista negra" , "En desarrollo" ];
    return $estados[$estado];
  }
  
  function get_nombre_estados_proyecto($estado,  $dias_restantes  ,  $ciclo_facturacion){


    $estados = ["Inactivo" , 
                "Activo" , 
                "Suspendido" , 
                "Lista negra" , 
                "En desarrollo" , 
                "Próximo a expirar" ,  
                "Pendiente por liquidar"];
                $nuevo_estado =  $estados[$estado];

    if( $dias_restantes == 0){      
      $nuevo_estado =  $estados[2];
    }if($ciclo_facturacion == "1" && $dias_restantes < 45  &&  $dias_restantes > 0 ){
      $nuevo_estado =  $estados[5];
    }if($ciclo_facturacion == "2" && $dias_restantes < 7  &&  $dias_restantes > 0 ){
      $nuevo_estado =  $estados[5];
    }if($dias_restantes < 0 ){      
      $nuevo_estado =  $estados[2];
    }if($dias_restantes < 0 && abs($dias_restantes) > 15 ){      
      $nuevo_estado =  $estados[0];
    }
    
    return $nuevo_estado;
  }
  
  function titulo_enid($titulo){

    $n_titulo =  n_row_12() 
                 ."<h1 class='titulo_enid_service'>
                    ". $titulo ."
                    </h1>".
                 end_row();

    return $n_titulo;             
  }
  function titulo_enid_w($titulo){

    $n_titulo =  n_row_12() 
                 ."<h1 class='titulo_enid_service_w'>
                    ". $titulo ."
                    </h1>".
                 end_row();

    return $n_titulo;             
  }
  
  function get_td($val , $extra = '' ){
    return "<td ". $extra ." NOWRAP >". $val ."</td>";
  }

  function get_td_val($val , $extra){
    if ($val!="" ) {
      return "<td style='font-size:.71em !important;' ". $extra .">". $val ."</td>";  
    }else{
      return "<td style='font-size:.71em !important;' ". $extra .">0</td>";
    }    
  }
    
  
  
  function valida_uso($val){
      

      if($val ==   0 ){
          return  "hoy";
      }else{
          return $val;
      }
  }
  
  
  */
  
}