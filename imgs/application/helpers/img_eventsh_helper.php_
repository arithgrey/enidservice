<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
    /**/
    function create_dinamic_dic($path){            
        
        /**/
        if(file_exists($path) == false ) {        
            
            mkdir( $path  , 0755, true);     
            
            
        }
        return file_exists($path);
    }
    /**/
    function get_img_by_event_in_directory($id_event){


        $ds = "/";  
        $storeFolder = 'uploads';           
        $directorio = dirname(dirname(__FILE__)). "/". $storeFolder."/".$storeFolder."/".$id_event."/";

        
        $result  = array();        
        $files = scandir($directorio);     

        foreach ( $files as $file ) {
            if ( '.'!=$file && '..'!=$file) {       //2
                $obj['name'] = $file;                
                $result[] = $obj;
            }
        }
  

        return $result;
    }
    /**/
    function comunidad_experiencia(){
        $l ="";
        return $l;                 
    }

/*****************+****************+****************+****************+****************+*/
}/*Termina el helper*/