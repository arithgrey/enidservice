<?php
class Servicio {
    
    public $options;  

    /**/
    public function __construct($options=[]){    
    }
    /**/
    function set_option($key, $value){
        $this->options[$key] = $value;
    }
    /**/
    function get_option($key){
        return  $this->options[$key];
    }
    function get_precio_publico_text(){
        $data_servicio =   $this->get_option("precios");
        return $data_servicio["precio"];
    }
    function set_valores_servicio(){

        $info_servicio =  $this->get_option("info_servicio");  
        foreach($info_servicio as $row){
            $this->set_option("info_servicio" , $row);
        }
    }
    /**/
    function get_url_preview(){

        $id_servicio = $this->get_option("id_servicio");
        return "http://enidservice.com/inicio/imgs/index.php/enid/imagen_servicio/".$id_servicio."/";
    }
    
    
}


