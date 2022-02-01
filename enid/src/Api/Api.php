<?php 
namespace Enid\Api;
use Enid\Api\Restclient;

class Api{

    private $restclient;
    function __construct()
    {                
        $this->restclient = new Restclient();               
    }
  
    function api($api, $q = [], $format = 'json', $type = 'GET', $debug = 0, $externo = 0, $b = "")
    {
        
        foreach ($q as $clave => $row) {

            if (is_null($q[$clave])) {
                $q[$clave] = "";
            }
        }

        if (count($q) < 1) {
            $q["x"] = 1;
        }


        if ($externo == 0) {
            $url = "q/index.php/api/";
        } else {
            $url = _text($b , "/index.php/api/");
        }

        $url_request = get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', $format);
        $result = "";
        switch ($type) {
            case 'GET':
                $result = $this->restclient->get(_text( $api, '/format/json/'), $q);
                break;
            case 'PUT':
                $result = $this->restclient->put($api, $q);
                break;
            case 'POST':
                $result = $this->restclient->post($api, $q);
                break;
            case 'DELETE':
                $result = $this->restclient->delete($api, $q);
                break;
            default:
                break;
        }


        if ($debug == 1 && es_local() > 0) {

            print_r($result->response);
            debug($result->response, 1);
        }
        if ($format == "json") {

            return $this->json_decode_nice($result->response, true);

        }

        return $result->response;
        
    }
    function json_decode_nice($json, $assoc = false)
    {

        $json = $this->Utf8_ansi($json);
        $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);
        $json = str_replace(array("\n", "\r"), "", $json);

        $json = preg_replace('/(,)\s*}$/', '}', $json);
        $json = preg_replace('/,\s*([\]}])/m', '$1', $json);

        return json_decode($json, $assoc);

    }
    public function Utf8_ansi($valor = '')
    {

        $utf8_ansi2 = array(
            "\u00c0" => "À",
            "\u00c1" => "Á",
            "\u00c2" => "Â",
            "\u00c3" => "Ã",
            "\u00c4" => "Ä",
            "\u00c5" => "Å",
            "\u00c6" => "Æ",
            "\u00c7" => "Ç",
            "\u00c8" => "È",
            "\u00c9" => "É",
            "\u00ca" => "Ê",
            "\u00cb" => "Ë",
            "\u00cc" => "Ì",
            "\u00cd" => "Í",
            "\u00ce" => "Î",
            "\u00cf" => "Ï",
            "\u00d1" => "Ñ",
            "\u00d2" => "Ò",
            "\u00d3" => "Ó",
            "\u00d4" => "Ô",
            "\u00d5" => "Õ",
            "\u00d6" => "Ö",
            "\u00d8" => "Ø",
            "\u00d9" => "Ù",
            "\u00da" => "Ú",
            "\u00db" => "Û",
            "\u00dc" => "Ü",
            "\u00dd" => "Ý",
            "\u00df" => "ß",
            "\u00e0" => "à",
            "\u00e1" => "á",
            "\u00e2" => "â",
            "\u00e3" => "ã",
            "\u00e4" => "ä",
            "\u00e5" => "å",
            "\u00e6" => "æ",
            "\u00e7" => "ç",
            "\u00e8" => "è",
            "\u00e9" => "é",
            "\u00ea" => "ê",
            "\u00eb" => "ë",
            "\u00ec" => "ì",
            "\u00ed" => "í",
            "\u00ee" => "î",
            "\u00ef" => "ï",
            "\u00f0" => "ð",
            "\u00f1" => "ñ",
            "\u00f2" => "ò",
            "\u00f3" => "ó",
            "\u00f4" => "ô",
            "\u00f5" => "õ",
            "\u00f6" => "ö",
            "\u00f8" => "ø",
            "\u00f9" => "ù",
            "\u00fa" => "ú",
            "\u00fb" => "û",
            "\u00fc" => "ü",
            "\u00fd" => "ý",
            "\u00ff" => "ÿ");

        return strtr($valor, $utf8_ansi2);

    }
}