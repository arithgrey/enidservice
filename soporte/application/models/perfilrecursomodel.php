<?php defined('BASEPATH') OR exit('No direct script access allowed');
class perfilrecursomodel extends CI_Model {
    function __construct()
    {
        parent::__construct();        
        $this->load->database();
    }
    /**/
    /*
    function displayrecursobyperfiles($perfiles){

        $b = 0;
        $data_info = array();
        $datacompleto = array();
        

        $idperfil = $perfiles[0]["idperfil"];
                        $query_get ="SELECT
                                        r.nombre , 
                                        r.urlpaginaweb , 
                                        r.iconorecurso, 
                                        r.descripcionrecurso , 
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
            
            $datacompleto = $data_info;
            foreach ($perfiles as $row){

                $id_perfil_actual = $row["idperfil"];
                
                       
                        for ($a=0; $a < count($datacompleto); $a++) { 
                            
                            $idrecursoactual= $datacompleto[$a]["idrecurso"];   
                            
                       
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

                            }
        
                        }                    
            }
            return $datacompleto;

        }
        */
    }