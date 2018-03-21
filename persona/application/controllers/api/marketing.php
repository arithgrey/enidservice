<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Marketing extends REST_Controller{      

    function __construct(){
        parent::__construct();                          
        
        $this->load->library("mensajeria_mail_marketing");
        $this->load->library("blaster_mensajeria");
        $this->load->model("marketing_model");
    }
    /**/
    function envio_POST(){

        $param =  $this->post();
        $data_prospecto =  $this->marketing_model->get_contactos_disponibles($param);                
        $inf_mail_marketing =  $this->mensajeria_mail_marketing->envia_mail_marketing($param , $data_prospecto ); 
		

		$db_registro  = 0;        
        if ($inf_mail_marketing == 1 ){

        	$db_registro =  $this->marketing_model->registra_respaldo_mail_marketing($param , $data_prospecto); 
        }
        $this->response("Num correos enviados: " . $db_registro);
    }
    /**/

    function sendmailgmail_GET(){        
        
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.enidservice.com',
            'smtp_port' => 465,
            'smtp_user' => 'promociones@enidservice.com',
            'smtp_pass' => 'qwerty123.1Enid',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );    
        
        $this->load->library("email" ,  $configGmail);        
        $this->email->from('promociones@enidservice.com' , "Enid Service");
        $this->email->to("arithgrey@gmail.com");
        $this->email->subject('Hola Jonathan');
        $this->email->message('<p>Mi super test</p>');
        $this->email->send();        
        $mail_response = $this->email->print_debugger();
        $this->response($mail_response);
    }
    /**/
    function blaster_GET(){

        $param =  $this->get();
        $param["asunto"] = $this->blaster_mensajeria->get_asunto_sitios_web();
        $param["mensaje"] = $this->blaster_mensajeria->get_mensaje_blaster_sitios_web();        
        $param["tipo"] = 1;

        $data_prospecto =  $this->marketing_model->get_contactos_disponibles($param);                
        $data_email =  $this->mensajeria_mail_marketing->envia_mail_marketing($param , $data_prospecto );             
        $num_mail_enviados =  $this->marketing_model->registra_respaldo_mail_marketing($param , $data_prospecto); 
        

        $data["data_email"] = $data_email;
        $data["data_email_enviados"] =  $num_mail_enviados;
        $this->response($data);    

    }
    /**/
    function mensaje_leido_GET(){
        $param =  $this->get();
        $db_registro =  $this->marketing_model->update_mensaje_enviado($param);
        $this->response($db_registro);        
    }

     

}?>