<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class MisDatosControlador extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model("misdatosmodel");            
        $this->load->library('sessionclass');       
    } 
    /**/
    function usuario_PUT()
    {
        $this->validate_user_sesssion();        
        $id_usuario= $this->sessionclass->getidusuario();
        $db_response = $this->misdatosmodel->update_data_user($this->put() , $id_usuario );        
        $this->response($db_response);
        
    }

    /**/
    function actualizarNombre_post(){

        $this->validate_user_sesssion();
        $nuevoNombre = $this->post('name');
        $id_usuario= $this->sessionclass->getidusuario();
        $respuestaDB = $this->misdatosmodel->actualizarNombre($nuevoNombre,$id_usuario);
        $this->response($respuestaDB);

    }
    /**/
    function mostrarNombre_get(){
        $this->validate_user_sesssion();
        $id_usuario= $this->sessionclass->getidusuario();
        $respuestaDB = $this->misdatosmodel->mostrarNombre($id_usuario);
        $this->response($respuestaDB);

    }
    /**/
    function actualizarPuesto_post(){

        $this->validate_user_sesssion();
        $nuevoPuesto = $this->post('puesto');
        $id_usuario= $this->sessionclass->getidusuario();
        $respuestaDB1 = $this->misdatosmodel->actualizarPuesto($nuevoPuesto,$id_usuario);
        $this->response($respuestaDB1);     

    }
    /**/
    function mostrarPuesto_get(){

        $this->validate_user_sesssion();
        $id_usuario= $this->sessionclass->getidusuario();
        $respuestaDB = $this->misdatosmodel->mostrarPuesto($id_usuario);
        $this->response($respuestaDB);
    }
    /**/
    function actualizarDescripcion_post(){

        $this->validate_user_sesssion();
        $nuevoDescripcion = $this->post('descripcion');
        $id_usuario= $this->sessionclass->getidusuario();
        $respuestaDB2 = $this->misdatosmodel->actualizarDescripcion($nuevoDescripcion,$id_usuario);
        $this->response($respuestaDB2);
    }
    /**/
    function mostrarDescripcion_get(){

        $this->validate_user_sesssion();
        $id_usuario= $this->sessionclass->getidusuario();
        $respuestaDB = $this->misdatosmodel->mostrarDescripcion($id_usuario);
        $this->response($respuestaDB);            
    }
    /*************************************************************************************************************/
    function validate_user_sesssion(){
        if( $this->sessionclass->is_logged_in() == 1) {                        

            }else{
                    /*Terminamos la session*/
            $this->sessionclass->logout();
        }   
    }/*termina validar session */
    /*Termina rest*/
}