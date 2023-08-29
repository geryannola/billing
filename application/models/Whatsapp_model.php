<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Whatsapp_model extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }

    function whatsapp($data = [])
    {
        $message             = $data['message'];
        $phonenumber         = $data['phonenumber'];
        $url                 = $data['url'];
        $link1               = $data['link'];

        $mainUrl            = $url . $link1;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $mainUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "phonenumber": ' . $phonenumber . ',
            "message" : "' . $message . '"
        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    function whatsapp_status($data = [])
    {

        $url                 = $data['url'];
        $link1               = $data['link'];

        $mainUrl            = $url . $link1;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $mainUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
