<?php

namespace Enid\WhatsApp;

class WhatsAppAPI
{
    private $url;
    private $headers;

    public function __construct($configWhatsApp)
    {
        $this->url = $configWhatsApp["url"];
        $this->headers = $configWhatsApp["headers"];
    }
    function sendMessageTest($template = 'hello_world', $to ='5552967027'){

        $data = array(
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'template',
            'template' => array(
                'name' => $template,
                'language' => array(
                    'code' => 'en_US'
                )
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;

        
    }

    public function sendMessage($to, $template = 'hello_world')
    {
        $data = array(
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'template',
            'template' => array(
                'name' => $template,
                'language' => array(
                    'code' => 'en_US'
                )
            )
        );
        $data_string = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
}
