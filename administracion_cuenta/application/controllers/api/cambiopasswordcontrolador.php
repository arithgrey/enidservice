<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class CambioPasswordControlador extends REST_Controller{
    function __construct(){
            parent::__construct();
            $this->load->model("passwordmodel");            
            $this->load->library('sessionclass');    
    }        
    /**/
    function actualizarPassword_post(){
       
        $this->validate_user_sesssion();
        $anterior = $this->post('anterior');
        $nuevo = $this->post('nuevo');
        $confirmaPassword = $this->post('confirma');

        if($nuevo == $confirmaPassword){
            $idUsuario= $this->sessionclass->getidusuario();
            $respuestaDB = $this->passwordmodel->actualizarPassword($anterior,$nuevo,$idUsuario);
            $this->response($respuestaDB);
        }else{
            $this->response("Contraseñas distintas");
        }              
    }
    /**/
    function validate_user_sesssion(){
        if( $this->sessionclass->is_logged_in() == 1) {}else{
            /*Terminamos la session*/
            $this->sessionclass->logout();
        }   
    }/*termina validar session */
}/*Termina rest*/