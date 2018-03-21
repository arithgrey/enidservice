<?php defined('BASEPATH') OR exit('No direct script access allowed');
class empresamodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  }   
  /**/
  function insert_paginas_web($param){

      $email = $param["email"];
      $empresa = $param["empresa"];
      $rubro = $param["rubro"];
      $objetivos = $param["objetivos"];
      $sitio_similar = $param["sitio_similar"];            
      $presupuesto = $param["presupuesto"];
      $tel  =  $param["tel"];      
      $facebook  =  $param["facebook"];
      $twitter  =  $param["twitter"];
      $youtube  =  $param["youtube"];

      $query_insert =  "INSERT INTO cotizador(        
                        nombre_empresa        ,
                        email                 ,
                        rubro                 ,
                        objetivos             ,
                        sitio_similar         ,                
                        presupuesto           ,        
                        tipo                  ,
                        tel ,
                        facebook ,  
                        twitter ,  
                        youtube   
        )VALUES(
          '".$empresa."' , 
          '".$email."' , 
          '".$rubro."', 
          '".$objetivos."' ,
          '".$sitio_similar ."',                     
          '".$presupuesto."', 
          '1' , 
          '".$tel  ."',
          '".$facebook  ."',
          '".$twitter  ."',
          '".$youtube  ."'
        )";
      return  $this->db->query($query_insert);


    }
  /**/
  function insert_lead($param){

    $query_insert ="INSERT INTO contact(
                                  email   ,       
                                  id_empresa , 
                                  id_tipo_contacto
                            )VALUES(
                            '".$param["email"]."',                     
                            '1',
                            '".$param["tipo_prospecto"]."')";

    return $this->db->query($query_insert);

    /**/

  }
 
  /**/  
  function insert_contacto($param){

    $query_insert ="INSERT INTO contact(
                    nombre ,        
                    email   ,       
                    mensaje  ,        
                    id_empresa , 
                    id_tipo_contacto, 
                    telefono
                     )VALUES(
                      '".$param["nombre"]."', 
                      '".$param["email"]."', 
                      '".$param["mensaje"]."', 
                      '".$param["empresa"]."' , 
                      '".$param["tipo"]."',
                      '".$param["tel"]."'
                       ) ";

    return $this->db->query($query_insert);
    
  }
  
/*Termina modelo */
}