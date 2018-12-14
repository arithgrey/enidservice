<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
	
	function formatAgregar($param){
        $mas_nivel =  "mas_".$param["nivel"];
        $seleccion =  "seleccion_".$param["nivel"];
        $response =    "<div class='".$mas_nivel."'>
                                    <button class='button-op ".$seleccion."'>
                                        AGREGAR A LA LISTA
                                    </button>                                
                                </div>";
        return $response;
    }
}
