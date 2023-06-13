<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
    }

    function index()
    {

        $param = $this->input->get();
        $id = intval(prm_def($param, "xn", 1));
        setcookie('xn', prm_def($param, "xn", 1), strtotime('2038-01-01'), "/");

        switch ($id) {
            case 1:

                header("location:../search/?q2=0&q=kitsmasvendidos&order=2");
                break;

            case 2:

                header("location:../search/?q=panel&order=2");
                break;

            case 3:

                header("location:../search/?q=tenisg5&order=2");
                break;

            case 4:

                header("location:../search/?q=tapetes-mazda&order=2");
                break;

            case 5:

                header("location:../search/?q=pasteles-dulceros&order=2");
                break;

            default:
                break;
        }
    }
}
