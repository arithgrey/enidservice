<?php defined('BASEPATH') OR exit('No direct script access allowed');
class perfilmodel extends CI_Model {
    function __construct(){
        
        parent::__construct();        
        $this->load->database();
    }
    /**/
    
    /* Los perfiles que tiene el usuario */    
    /*Asigna el perfil del usuario */
    function recordusuarioperfilstandar($id_usuario){

        /*Verificamos que el perfil ya se encuentre registrado*/
            $query_get ="SELECT * FROM usuario_perfil 
                        WHERE 
                        idusuario='".$id_usuario."'  
                        AND  idperfil = '1'  AND ststus =  1 ";
            $result_select  = $this->db->query($query_get);       
            $exist = $result_select->num_rows();
            
            /*Si ya existe no lo registramos*/    
            if ($exist == 1) {
                return true;
            }else{
                /*Registramos*/
                $query_get ="INSERT INTO usuario_perfil  VALUES ('".$id_usuario."' , '1')"; 
                $result = $this->db->query($query_get);       
                return $result;        
            }

    }



    /*Listamos los perfiles y sus permisos */
    function listperfilesrecursospermisos(){

        $query_get = "SELECT  perfil_recurso.idperfil, perfil_recurso.idrecurso , recurso.nombre AS recurso,  perfil.nombreperfil FROM perfil_recurso, recurso , perfil WHERE perfil_recurso.idrecurso = recurso.idrecurso  AND perfil_recurso.idperfil = perfil.idperfil";
        $result = $this->db->query($query_get);  
        return $result ->result_array();      
    }
    /*Listamos todos los perfiles del sistema */
    function listallperfiles(){

        $query_get ="SELECT * FROM perfil";
        $result = $this->db->query($query_get);  
        return $result ->result_array();      
    }
  /*Actualiza los datos del perfil */
   function updateperfil($id_perfil , $descripcion){

        $query_update ="UPDATE perfil SET descripcion = '".$descripcion."' WHERE idperfil = '".$id_perfil."' limit 1 ";
        $result = $this->db->query($query_update);  
        return $result;  
   } 
   /*Termina actualiza los datos del perfil */
   /***********************************************Insertar perfil****************************************************/
   function insertperfil( $nombre  , $descripcion_perfil ){
        
        if ( strlen($nombre) > 0  ) {            
                /*Verifica qsi existe o no el recursos en la base de datos*/    
                if ( $this->existperfilbyname($nombre) > 0 ){
                    /*Informe de existencia */
                    return "El recurso existe actualmente, intente con otro nombre";
                }else{
                    /*Insertamos en la base de datos*/
                    $query_insert ="INSERT INTO  perfil (nombreperfil ,  descripcion ) values ('".$nombre."' ,  '".$descripcion_perfil."'  )";
                    $result = $this->db->query($query_insert);
                    return $result;            
                }        
        }else{
            return "Complete los campos";
        }       
   }
   /*******************************************************************************/
    function existperfilbyname($nombre){

        $query_exist ="SELECT * FROM perfil  WHERE nombreperfil = '". $nombre . "' ";
        $result = $this->db->query($query_exist);  
        /*Bandera */
        $b=0;
        foreach ($result ->result_array() as $row){
            $b++;
        }   
        return $b;      
    }
    /*Elimina perfil */
    function removeperfilbyid($id_perfil){
        /*Eliminamos el perfil a los usuarios*/
        $query_delete ="DELETE  FROM usuario_perfil WHERE idperfil = '". $id_perfil . "' ";         
        $result = $this->db->query($query_delete);  

        if ($result == true){
            
                $query_delete ="DELETE  FROM perfil_recurso WHERE idperfil = '". $id_perfil . "' ";         
                $result = $this->db->query($query_delete);  

                if ($result == true) {
                    
                    $query_delete ="DELETE  FROM perfil WHERE idperfil = '". $id_perfil . "' ";    
                    $result_perfil = $this->db->query($query_delete);  
                    return $result_perfil;

                }else{
                    return "Algo falló al eliminar el elemento";
                }    

        }else{
                    return "Algo falló al eliminar el elemento";
        }            
    }/*Termina la función */
/***************************************Permisos, perfil recurso *****************************************/

/*Eliminar permisos */
function deleteperfilrecurso($id_perfil , $id_recurso ){

    $query_delete ="DELETE  FROM perfil_recurso WHERE idperfil = '". $id_perfil . "' AND idrecurso='".$id_recurso."' ";         
    $result = $this->db->query($query_delete);  
    return $result;
}/*Termina eliminar perfil*/

/***************************************Actualizar los permisos************************************/
function updateperfilpermisopermisodb($id_perfil , $id_recurso ){
    
        $query_get = "SELECT * FROM perfil_recurso WHERE idrecurso = '".$id_recurso."'  AND idperfil = '".$id_perfil."'  ";
        $result = $this->db->query($query_get);  
        
        $flag = 0;   
        foreach ($result ->result_array() as $row){
                 $flag++;                 
        }/*Termina el ciclo*/           
        if ($flag == 0 ) {
            /*Ponemos uno al permiso */          
            $dinamic_query  ="INSERT INTO perfil_recurso (idperfil , idrecurso) values ( $id_perfil , $id_recurso  ) ";
        }else{
            /*ponemos un cero al permiso*/
            $dinamic_query  ="DELETE FROM perfil_recurso WHERE idperfil = $id_perfil AND  idrecurso = $id_recurso  ";
        }    
        $result_update = $this->db->query($dinamic_query);  
        return $result_update;

    }/*Termina la función*/
/*******************************************************************************/ 
function list_perfiles_modulo_permisos_general($id_recurso){    
    /*Los perfiles disponibles */
    $query_get = "SELECT DISTINCT(idperfil) FROM perfil_recurso WHERE idrecurso = $id_recurso"; 
    $result  = $this->db->query($query_get);  
    $b = 0;
    foreach ($result ->result_array() as $row){    
        $idperfildisponible = $row["idperfil"];        
        /*inicia */
        $query_get ="SELECT * FROM perfil WHERE idperfil = $idperfildisponible and status!='No Disponible'";
        $result = $this->db->query($query_get);  
                foreach ($result ->result_array() as $row){
                    /**/
                           $dataconfig["perfil"][$b] = array(

                                'idperfil' => $row["idperfil"],
                                'nombreperfil' => $row["nombreperfil"], 
                                'fecha_registro' => $row["fecha_registro"], 
                                'descripcion'=> $row["descripcion"]                                                                
                            );                                    
                    $b++;
                }            
    }/*Termina ciclo */    
/*************************************************************************/         
        $query_list_permiso ="SELECT * FROM permiso WHERE idrecurso = '".$id_recurso."' ";
        $result_permiso = $this->db->query($query_list_permiso);          
            $x = 0;
                foreach ($result_permiso ->result_array() as $row){
                    /**/
                           $dataconfig["permiso"][$x] = array(

                                'idpermiso' => $row["idpermiso"],
                                'nombrepermiso' => $row["nombrepermiso"],                                 
                                'descripcionpermiso'=> $row["descripcionpermiso"],

                            );                                    
                    $x++;
                }    
/******************************Perfil Permiso *************************************************/    
        $query_perfil_permiso ="SELECT * FROM perfil_permiso";
        $result_pp = $this->db->query($query_perfil_permiso);  
        $t = 0;
                foreach ($result_pp ->result_array() as $row){
                    /**/
                           $dataconfig["perfil_permiso"][$t] = array(

                                'idpermiso' => $row["idpermiso"],
                                'idperfil' => $row["idperfil"],
                                
                            );                                    
                    $t++;
                }    
        return $dataconfig;      
}
/**/
function listperfilesmodulopermisos($idrecurso){
    /*Los perfiles disponibles */
    $query_get = "SELECT DISTINCT idperfil  FROM perfil_recurso WHERE idrecurso = $idrecurso "; 
    $result  = $this->db->query($query_get);  
     $b = 0;
    foreach ($result ->result_array() as $row){    
        $idperfildisponible = $row["idperfil"];        
    /*inicia */
        $query_list ="SELECT * FROM perfil WHERE idperfil = $idperfildisponible";
        $result = $this->db->query($query_list);            

                foreach ($result ->result_array() as $row){
                    /**/
                           $dataconfig["perfil"][$b] = array(

                                'idperfil' => $row["idperfil"],
                                'nombreperfil' => $row["nombreperfil"], 
                                'fecha_registro' => $row["fecha_registro"], 
                                'descripcion'=> $row["descripcion"]                                                                    
                            );                                    
                    $b++;
                }    
    /*Termina  */                
    }/*Termina ciclo */    
    /*************************************************************************/         
        $query_list_permiso ="SELECT * FROM permiso WHERE idrecurso = '".$idrecurso."' ";
        $result_permiso = $this->db->query($query_list_permiso);            
        $x = 0;
        foreach ($result_permiso ->result_array() as $row){
                    /**/
                           $dataconfig["permiso"][$x] = array(

                                'idpermiso' => $row["idpermiso"],
                                'nombrepermiso' => $row["nombrepermiso"],                                 
                                'descripcionpermiso'=> $row["descripcionpermiso"],

                            );                                    
                    $x++;
                }    

/******************************Perfil Permiso *************************************************/
        

        $query_perfil_permiso ="SELECT * FROM perfil_permiso";
        $result_pp = $this->db->query($query_perfil_permiso);  
          

            $t = 0;

                foreach ($result_pp ->result_array() as $row){
                    /**/
                           $dataconfig["perfil_permiso"][$t] = array(

                                'idpermiso' => $row["idpermiso"],
                                'idperfil' => $row["idperfil"],
                                

                            );                                    
                    $t++;
                }    


        return $dataconfig;      


}
/**/
/*Termina modelo */
}