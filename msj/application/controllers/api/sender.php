<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Sender extends REST_Controller{
    function __construct(){
        parent::__construct();
        $this->load->library('email');
        $this->load->library(lib_def());
    }
    function index_GET(){

        $this->email->clear();
        $config['protocol'] = 'sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $this->email->from('compras@enidservice.com', 'compras@enidservice.com' );
        $this->email->set_mailtype("html");
        $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
        $this->email->set_header('Content-type', 'text/html');
        $this->email->set_header('From', "hola@enidservice.com");

        $para       = ['arithgrey@gmail.com'];
        $subject    = 'This is my subject';
        $message    = 'This is my message';


        $this->email->to($para);
        $this->email->subject($subject);
        $this->email->message($message);

        /*if ( ! $this->email->send())
        {
            debug("Error al enviar email");
        }
        */
        $debug =  $this->email->print_debugger($this->email->send());
        $this->response($debug);

    }

}