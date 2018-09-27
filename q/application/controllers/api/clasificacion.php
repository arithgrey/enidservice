<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Clasificacion extends REST_Controller{      
    function __construct(){
        parent::__construct();             
        $this->load->model("clasificacion_model");
        //$this->load->library('table');       
        $this->load->library(lib_def());  
    }
    function categorias_servicios_GET(){

        $param      =   $this->get();
        $response   =   [];

        if (if_ext($param , 'padre,modalidad,nivel') ) {

            
            $in     = 
                [   
                    "padre"         => $param["padre"],
                    "flag_servicio" => $param["modalidad"],
                    "nivel"         => $param["nivel"]
                ];
            $response   =  $this->clasificacion_model->get([] , $in , 100);    
        }
        $this->response($response);
    }
    function clasificaciones_por_servicio_GET(){
        
        $param          =  $this->get();
        $clasificacion  =  $this->clasificacion_model->get_clasificaciones_por_id($param);
        $this->response($clasificacion);        
    }
    /**/
    function primer_nivel_GET(){

        $param                  =  $this->get();
        $param["nivel"]         =  1;        
        $primer_nivel           =  $this->clasificacion_model->get_clasificaciones_por_nivel($param);
        $response["clasificaciones"] = $this->clasificacion_model->get_clasificaciones_segundo($primer_nivel);
        $this->load->view("clasificaciones/menu" , $response);
    }
    /**/
    function interes_usuario_GET($param){
        
        $param      =  $this->get();
        $response   =  $this->clasificacion_model->get_intereses_usuario($param);
        $this->response($response);
    }
    /**/
    function nombre_GET(){
        
        $param =  $this->get();
        $nombre_clasificacion =  
        $this->clasificacion_model->get_nombre_clasificacion_por_id_clasificacion($param);
        $this->response($nombre_clasificacion);
    }
    function id_GET(){

        $param      =   $this->get();        
        $response   =   $this->clasificacion_model->get_clasificaciones_por_id_clasificacion($param);
        $this->response($response);
    }
    /**/    
    function categorias_destacadas_GET(){
        
        $param                                  = $this->get();
        $param["nivel"]                         = 1; 
        $data_complete["clasificaciones"]       = $this->get_clasificaciones_destacadas($param);
        $data_complete["nombres_primer_nivel"]  = $this->clasificacion_model->get_clasificaciones_por_nivel($param);
        $this->response($data_complete);
    }    
    function clasificaciones_nivel_GET(){

        $param      =  $this->get();
        $response   = $this->clasificacion_model->get_clasificaciones_por_nivel($param);
        $this->response($response);

    }
    /**/
    function clasificacion_padre_nivel_GET(){

        $param          = $this->get();        
        $response       = [];    

        if (if_ext($param , 'padre' , 0)) {            
            $f          =     ["id_clasificacion" , "padre" , "nivel" ];
            $response   =     $this->clasificacion_model->get($f, $param["padre"] );    

        }
        $this->response($response);
    }
    /**/
    function tipo_talla_clasificacion_GET(){
        
        $param              =  $this->get();        
        $v                  =  $param["v"];
        $clasificaciones    =  
        $this->clasificacion_model->get_clasificacion_por_palabra_clave($param);                
        if ($v == 1) {
            $tags           =   create_tag($clasificaciones , 'tag-add tag ' ,  "id_clasificacion" , "nombre_clasificacion");

            $this->response($tags);
        }else{
            $this->response($clasificaciones);            
        }
    }  
    /**/
    function get_clasificaciones_destacadas($q){
        $api    = "servicio/clasificaciones_destacadas/format/json";
        return  $this->principal->api( $api , $q);
    }      
    function set_clasificacion_talla($q){
        $api    = "talla/clasificacion";
        return  $this->principal->api( $api , $q , "json" , "PUT");
    }
    /**/
    function tipo_talla_clasificacion_POST(){

        $param                      =  $this->post();
        $tipo_talla                 =  $this->get_tipo_talla($param);
        $clasificacion              =  $tipo_talla[0]["clasificacion"];
        $arr_clasificaciones        =  get_array_json($clasificacion);         
        
        $arr_clasificaciones        =  
        push_element_json($arr_clasificaciones ,  $param["id_clasificacion"]);
        $param["clasificaciones"]   =  get_json_array($arr_clasificaciones);

        $response["status"]             = $this->set_clasificacion_talla($param);
        $response["clasificaciones"]    = $arr_clasificaciones; 
        $this->response($response);
    }
    /*
    function tipo_tallas_GET(){

        $param          =   $this->get();
        $response       =   $this->get_tipo_tallas($param);
        $v              =   $param["v"];
        if ($v == 1){
            $table      =  $this->create_table_tallas($response);
            $this->response($table);
        }else{
            $this->response($response);    
        }
    }
    */
    /**/
    function tipo_talla_GET(){

        $param          =   $this->get();
        $response       =   $this->get_tipo_talla($param);        
        $v              =   $param["v"];
        if ($v == 1) {        
        
            $data["talla"]  =   $response;
            if (count($response)>0){

                $array_clasificiones                =  
                get_array_json($response[0]["clasificacion"]);                
                $clasificaciones_existentes         =  
                $this->get_clasificaciones_por_id($array_clasificiones);                
                $tags                               =   
                                                    create_tag($clasificaciones_existentes,
                                                    'a_enid_black_sm input-sm' ,  
                                                    "id_clasificacion" , 
                                                    "nombre_clasificacion");

                $data["clasificaciones_existentes"] =  $tags;
                $data["num_clasificaciones"]        =  count($clasificaciones_existentes);
            }
            $this->load->view("tallas/principal", $data);
           

        }else{
            $this->response($response);    
        }
        
    }
    /**/
    private function get_clasificaciones_por_id($array){

        $data_complete =  [];
        for ($a=0; $a <count($array) ; $a++) {             
            $param["fields"]  = [  "id_clasificacion" , "nombre_clasificacion" ];
            $param["id"]        = $array[$a];
            $data_complete[$a]  =  
            $this->clasificacion_model->get_clasificacion_por_id($param)[0];        
        }
        return $data_complete;
    }
    /**/
    function existencia_GET(){
        $param                    =  $this->get();
        $response["existencia"]   =  $this->clasificacion_model->num_servicio_nombre($param);
        $this->response($response);
    }
    /**/
    function nivel_POST(){

        $param      =  $this->post();
        $params = [
            "nombre_clasificacion"  =>  $param["clasificacion"],
            "flag_servicio"         =>  $param["tipo"],
            "padre"                 =>  $param["padre"],
            "nivel"                 =>  $param["nivel"]
        ];
        $response   =  $this->clasificacion_model->insert($param);
        $this->response($response);
    }
    /**/
    function nivel_GET(){

        $param      =  $this->get();
        $response   =  $this->clasificacion_model->get_servicio_nivel($param);
        
        if (array_key_exists('v', $param) && $param["v"] ==  1 ) {
            $this->response($response);
        }else{                
                
            $response  = 
                select_vertical($response , 
                    "id_clasificacion" , 
                    "nombre_clasificacion" , 
                    array(
                        'size'      => 20 , 
                        'class'     => 'sugerencia_clasificacion'
                    ) 
                );

            if ($param["nivel"] !== "1") {
                $mas_nivel =  "mas_".$param["nivel"];
                $seleccion =  "seleccion_".$param["nivel"];            
                $response .=    "<div class='".$mas_nivel."'>
                                    <button class='button-op ".$seleccion."'>
                                        AGREGAR A LA LISTA
                                    </button>                                
                                </div>";    
            }    
            
            $this->response($response);    
        }    
    }
    
    function tallas_servicio_GET(){
        

        $param              =   $this->get();        
        $tallas_servicio    =   $this->get_tallas_servicio($param);          
        $tallas_servicio_json   =   (count($tallas_servicio) > 0) ?  $tallas_servicio[0]["talla"]: "";
        $tallas_servicio        =   $this->quita_cero_clasificacacion($tallas_servicio);
        $v                      =   (array_key_exists("v", $param))?$param["v"]:0;
        $data_complete          =   [];
        $tipo_tallas            =   $this->get_tipo_talla();

        $id_tipo_talla         =0;    
        foreach ($tipo_tallas as $row) {            
            $id                     =   $row["id"];            

            $array_clasificaciones  =   get_array_json($row["clasificacion"]);
            for ($a=0; $a < count($array_clasificaciones); $a++) {
                $clasificacion =  $array_clasificaciones[$a]; 
                for ($z=0; $z < count($tallas_servicio); $z++) { 
                    if ($tallas_servicio[$z] == $clasificacion) {
                        $id_tipo_talla                      =   $id;
                        $data_complete["id_tipo_talla"]     =   $id_tipo_talla;
                        $param["id_tipo_talla"]             =   $id_tipo_talla;                        
                        break;            
                    }
                }
            }
        }
        
        
        if (array_key_exists("id_tipo_talla", $data_complete)) {
            
            $tallas_en_servicio                 =  $this->get_tallas_servicio($param);                
            $data_complete["tallas_servicio"]   =  
            $this->get_tallas_en_servicio($tallas_en_servicio, $tallas_servicio_json);                    
        }
        
        if ($v ==  1 && array_key_exists("tallas_servicio", $data_complete) ) {
            
            
            
            $config = 
                [
                'class_selected'    => 'talla_seleccionada talla_servicio',
                'class_disponible'  => 
                'talla_disponible talla_servicio',
                'text_button'       => 'talla' ,
                'campo_comparacion' => 'en_servicio',
                'valor_esperado'    => 1,
                'valor_id'          => 'id_talla'
            ];
            
            
            $easy_butons   = create_button_easy_select($data_complete["tallas_servicio"] , $config);
            $easy_butons   = add_element($easy_butons ,  "div" , ['class' => 'contenedor_tallas_disponibles']);
            $titulo        = add_element("TALLAS QUE TIENES DISPONIBLES","div",['class' => 'titulo_talla' ]);
            $easy_butons   = add_element( $titulo.$easy_butons , "div" , ['class'   => 'contenedor_tallas']);
            $data_complete["options"] =  $easy_butons;
        }
        $this->response($data_complete);            
    }    
    private function get_tallas_en_servicio($tallas_disponibles , $tallas_en_servicio_json){
        
        
        $array_tallas_en_servicio   =  get_array_json($tallas_en_servicio_json);        
        sort($array_tallas_en_servicio);

        $data_complete  = [];         
        $a =0;

        foreach ($array_tallas_en_servicio as $row){            

            $data_complete[$a]  =  $row;
            $talla              =  $row["talla"];  
            $id_talla           =  $row["id_talla"];                  
            $data_complete[$a]["en_servicio"] =  
            ( in_array( $id_talla , $array_tallas_en_servicio ) ) ? 1 : 0;                
            $a ++;
        }
        return $data_complete;
        
        
    }
    /**/
    private function quita_cero_clasificacacion($clasificaciones){

        $data_complete =  [];
        foreach ($clasificaciones as $row) {
            
            $x =  ($row["primer_nivel"] == 0)?"":array_push($data_complete, $row["primer_nivel"]);
            $x =  ($row["segundo_nivel"]== 0)?"":array_push($data_complete, $row["segundo_nivel"]);
            $x =  ($row["tercer_nivel"] == 0)?"":array_push($data_complete, $row["tercer_nivel"]);
            $x =  ($row["cuarto_nivel"] == 0)?"": array_push($data_complete, $row["cuarto_nivel"]);
            $x =  ($row["quinto_nivel"] == 0)?"": array_push($data_complete, $row["quinto_nivel"]);
                        
        }
        return $data_complete;    
    }
    /**/
    function  get_tallas_countries($q){            
        $api    =  "talla/tallas_countries/format/json/";
        return  $this->principal->api( $api, $q);     
    }  
    /**/
    function  get_tallas_servicio($q){            
        $api    =  "servicio/tallas/format/json/";
        return  $this->principal->api( $api, $q);     
    }  
    function get_tipo_talla(){

        $q["info"]  = 1;
        $api        =  "tipo_talla/index/format/json/";
        return      $this->principal->api( $api, $q);      
    }
    function coincidencia_servicio_GET(){        
        $param      =   $this->get();
        $response   =  $this->clasificacion_model->get_coincidencia($param);
        $this->response($response);
    }
}?>