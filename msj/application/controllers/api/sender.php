<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Sender extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->load->library('email');
        $this->load->library(lib_def());
    }
    function index_POST(){

        $param      =  $this->post();
        $response   = false;
        $test       =  $param["test"];
        if(if_ext($param , "para,asunto,cuerpo") ){
            $response = 2;
            if(filter_var($param["para"], FILTER_VALIDATE_EMAIL)){
                $response = 0;
                $this->email->clear();

                $sender_email = $this->config->item('senderEmail');
                $this->email->initialize($sender_email);
                $this->email->from('hola@enidservice.com', 'Enid Service' , 'arithgrey@gmail.com');

                $para       =   $param["para"];
                $subject    =   $param["asunto"];
                $message    =   $param["cuerpo"];


                $this->email->to($para);
                $this->email->subject($subject);
                $this->email->message($message);


                if(es_local() > 0){
                    if($test    >   0){
                        $response   =  $this->email->print_debugger($this->email->send());
                    }else{
                        debug("Se imprimiría aquí!" ,1);

                    }

                }else{
                    $response   =  $this->email->print_debugger($this->email->send());
                }
            }
        }
        $this->response($response);

    }

}