<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class enidmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function get_info_empresa($id_empresa){

        $query_get =  "SELECT *  FROM  empresa WHERE idempresa = $id_empresa LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0];
    }
    /**/
    function update_inicidencia($param){

      $id_incidencia = $param["id_incidencia"];
      $status = $param["status_incidencia"];
      $query_update =  "UPDATE incidencia SET status = '".$status."' WHERE id_incidencia = '".$id_incidencia."' LIMIT 1 "; 
      return  $this->db->query($query_update);

    }

    /**/
    function get_perfiles_disponibles($id_perfil){
        
        $where =""; 
        switch ($id_perfil){
          /*Usuario general */          
          case 4:
            $where =" WHERE usuario_prueba =  1"; 
            break;
          
          default:
                      
            break;
        }
        $query_get ="SELECT * FROM perfil " .$where .  " ORDER BY nombreperfil ASC";
        $result = $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function getperfildata($id_usuario){
        $query_get ="SELECT 
                    p.idperfil , 
                    p.nombreperfil , 
                    p.descripcion 
                    FROM perfil AS p , 
                    usuario_perfil AS up 
                    WHERE  
                    up.idperfil = p.idperfil 
                    AND up.idusuario = $id_usuario  
                    AND  up.status =  1 LIMIT 1";
                    
        $result_user = $this->db->query($query_get);       
        return $result_user ->result_array();      
    }
    /**/
    function getperfiluser($id_usuario ){
        $query_get ="SELECT idperfil FROM usuario_perfil  
                    WHERE 
                    idusuario='".$id_usuario."' AND status =  1 ";
        $result_user = $this->db->query($query_get);       
        return $result_user ->result_array();      
    }
    /**/
    function getidempresabyidusuario($id_user){
      $query_get   ="SELECT idempresa FROM usuario WHERE idusuario = $id_user limit 1"; 
      $result = $this->db->query($query_get); 
      $id_empresa = 0;
      foreach ($result ->result_array() as $row) {   
         $id_empresa =  $row["idempresa"];
      }
      return $id_empresa;
    }
    /**/
    function validauserrecord($mail , $secret){
        $query_select ="SELECT 
                          * 
                        FROM
                        usuario 
                        WHERE 
                        email='".$mail."' 
                        AND password ='".$secret."' limit 1";
        $result_user = $this->db->query($query_select);       
        return $result_user->result_array();      
    }
    /**/
    function get_empresa_permiso($id_empresa){
      $query_get =  "SELECT idpermiso FROM empresa_permiso WHERE  idempresa =  '".$id_empresa."' LIMIT 15 ";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    function get_empresa_recurso($id_empresa){
      $query_get =  "SELECT idrecurso FROM empresa_recurso WHERE  idempresa =  '".$id_empresa."' LIMIT 15 ";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    
  
    function registra_acceso_pagina_web($url , $ip , $dispositivo ,  $tipo  ){

      $query_insert =  "INSERT INTO pagina_web(
                        url,             
                        ip ,              
                        dispositivo , 
                        tipo )
                        VALUES( '".$url."'  , '".$ip."'  , '".$dispositivo."'  , '". $tipo ."' )"; 
      $this->db->query($query_insert);
    }
   
    
    /**/
    function reporta_error($param){

      $descripcion = $param["descripcion"];
      $query_insert =  "INSERT INTO 
                        incidencia(descripcion_incidencia , 
                          idtipo_incidencia , 
                          idcalificacion ,  
                          id_user ) 
                        VALUES('".$descripcion ."' , 4 ,  1 , 1)";
      return  $this->db->query($query_insert);                  
    }
    /**/

    /**/
    /**/
    function miemtros_cuenta($param){

      $query_get =  "
                    SELECT 
                      idusuario           , 
                      nombre              , 
                      email                     , 
                      fecha_registro                  , 
                      puesto              , 
                      status              , 
                      apellido_paterno    , 
                      apellido_materno    , 
                      email_alterno       , 
                      tel_contacto        , 
                      tel_contacto_alterno, 
                      edad                      , 
                      cargo               , 
                      url_fb              , 
                      url_tw              , 
                      url_www             , 
                      sexo                     
                    FROM usuario WHERE idempresa =  '".$param["id_empresa"]."'  LIMIT  5";  
                  $result =   $this->db->query($query_get);
                  return $result->result_array();
    }

    /**/
    function repo_prospectos_comparativa(){      
      /**/          
      $_num =  get_random();
      $this->create_tmp_2week($_num ,  0 );
        $r =  $this->create_tmp_block($_num ,  0 );        

        $query_get = "select  
                      sum(case when prospectos_semana  = 1 then 1 else 0 end )prospectos_semana ,  
                      sum(case when  prospectos_ayer =  1 then 1 else 0  end )prospectos_ayer , 
                      sum(case when  prospectos_dia =  1 then 1 else 0 end ) prospectos_dia 
                      from tmp_2week_info2_$_num"; 
                      $result = $this->db->query($query_get);
                      $data["info_prospectos"] =  $result->result_array();


                 $query_get2 ="     
                      select 
                      sum(case when eventos_dia =  1 then 1 else 0 end )eventos_dia ,
                      sum(case when eventos_ayer =  1 then 1 else 0 end )eventos_ayer ,
                      sum(case when eventos_semana =  1 then 1 else 0 end )eventos_semana 
                      from evento e 
                      inner join tmp_2week_info2_$_num b on e.idempresa =  b.idempresa";
                      $result2 = $this->db->query($query_get2);
                      $data["info_eventos"] =  $result2->result_array();

                      $this->create_tmp_2week($_num ,  1 );
         $this->create_tmp_block($_num ,  1);   
      return $data;

    }
    /**/
    
    /**/
    function set_pass($param){

        $mail =  trim($param["mail"]); 
        $new_pass =  RandomString(); 
        $query_update =  "UPDATE usuario SET password = '".sha1($new_pass)."' WHERE email = '".$mail."' LIMIT 1 ";
        
        $status_send= $this->db->query($query_update); 
        $data["new_pass"]= $new_pass;
        $data["status_send"] = $status_send; 
        $data["mail"] =  $param["mail"];
        return $data;
    }

    /**/
    function verifica_estatus_prospecto($param){

      $query_get =  "SELECT password_prospecto 
                            FROM usuario 
                            WHERE email =  '".$param["mail_user"]."' LIMIT 1";
      $result =  $this->db->query($query_get);
      $num_mail =  $result->result_array()[0]["password_prospecto"];
      $data["mail_prospecto"] =1; 
      if ($num_mail == 0 ){
          $data["mail_prospecto"] =0;
          $new_pass =  RandomString();
          $data["new_pass"] =  $new_pass;

          $query_update =  "UPDATE usuario SET password_prospecto = 1 ,  password = '".sha1($new_pass)."'  WHERE email =  '".$param["mail_user"]."' LIMIT 1   ";
          $data["estatus_pass"]=  $this->db->query($query_update);

      }
      return $data;
    }
    
    /**/
    function display_recursos_by_perfiles($perfiles){

        $b = 0;
        $data_info = array();
        $datacompleto = array();
        

        $idperfil = $perfiles[0]["idperfil"];
                        $query_get ="SELECT
                                        r.*,
                                        pr.idrecurso 
                                        FROM recurso  r INNER JOIN 
                                        perfil_recurso  pr
                                        ON  r.idrecurso  =  pr.idrecurso 
                                        WHERE 
                                        r.idrecurso = pr.idrecurso AND 
                                        pr.idperfil = $idperfil  
                                        ORDER BY order_negocio ASC"; 

            $result = $this->db->query($query_get);  
            $data  = $result ->result_array();
            
            for ($i=0; $i <  count($data); $i++) {                             
                if (!in_array( $data[$i], $data_info)){
                    $data_info[$b] = $data[$i];
                    $b++;                    
                }
            }
            
            /*Terminamos de de recorrer perfiles*/           
            /*Sub páginas*/
            $datacompleto = $data_info;
            foreach ($perfiles as $row){

                $id_perfil_actual = $row["idperfil"];
                
                        /******  ******/
                        for ($a=0; $a < count($datacompleto); $a++) { 
                            
                            $idrecursoactual= $datacompleto[$a]["idrecurso"];   
                            
                            /*Validamos que no este sin elementos el arreglo*/                        
                            if ($idrecursoactual != "") {
                                    

                                $sub_paginas_query = "SELECT  
                                                    p.nombrepermiso , 
                                                    p.urlpaginaweb ,
                                                    p.iconpermiso, 
                                                    p.descripcionpermiso 
                                                    FROM permiso AS p , perfil_permiso AS pp  
                                                    WHERE  pp.idpermiso = p.idpermiso AND 
                                                    pp.idperfil = $id_perfil_actual AND 
                                                    p.idrecurso = $idrecursoactual LIMIT 5";

                                $resultsubpaginas  = $this->db->query($sub_paginas_query);  
                                $datasubpaginas   = $resultsubpaginas ->result_array();
                                $datacompleto[$a]["subpaginas"] = $datasubpaginas; 

                            }/*Terminamos de validar que no este sin id el arreglo */
        
                        }                    
            }
            return $datacompleto;

        }
}