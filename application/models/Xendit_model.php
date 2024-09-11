<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Xendit_model extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }

    function GetQRCodebyQRID($data = [])
    {
        $id             = $data['id'];
        $url                 = $data['url'];
        $link1               = $data['link'];

        $mainUrl            = $url . $link1.'/'.$id;

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
        CURLOPT_HTTPHEADER => array(
            'api-version: 2022-07-31',
            'Authorization: Basic eG5kX2RldmVsb3BtZW50X09vbUFmT1V0aCtHb3dzWTZMZUpPSHpMQ1p0U2o4NEo5a1hEbitSeGovbUhXK2J5aERRVnhoZz09Og==',
            'Cookie: __cf_bm=KK8GAkHpIRgidlx0q5MPKizVyHHjdqunY8AMYPQ0fM4-1723817285-1.0.1.1-a2XcT.iBfGKQJqwsETp6VTNr8UkXh_H_Jc2aYR9fEqWVDiX9phVHKiwYrYKh22850EsR7D6d6qsHvp4t_q3ONw'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    function GetListofQRPaymentsbyQRID($data = [])
    {
        $id             = $data['id'];
        $url                 = $data['url'];
        $link1               = $data['link'];

        $mainUrl            = $url . $link1.'/'.$id.'/payments';
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
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic eG5kX2RldmVsb3BtZW50X09vbUFmT1V0aCtHb3dzWTZMZUpPSHpMQ1p0U2o4NEo5a1hEbitSeGovbUhXK2J5aERRVnhoZz09Og==',
            'Cookie: __cf_bm=l48ej.sTUoj4Y0a3BFNO7WF2ky7wWV0HRmIy3hFQsro-1723818308-1.0.1.1-WZd_LLT3jImZquNVIVEUJD50xXGPDisqNtxbIZD3Qs75nqxTOcfmUcHrsRLcgIb41Fn4ryUiHSDWCfz0wJn4Gw'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }
    function CreateQRCode($data = [])
    {
        $url                 = $data['url'];
        $link1               = $data['link'];
        $reference_id               = $data['reference_id'];
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
        CURLOPT_POSTFIELDS =>'{
        "reference_id": "order-id-1723854809",
        "type": "DYNAMIC",
        "currency": "IDR",
        "amount": 10000,
        "expires_at": "2024-10-23T09:56:43.60445Z"
        }
        ',
        CURLOPT_HTTPHEADER => array(
            'api-version: 2022-07-31',
            'Content-Type: application/json',
            'Authorization: Basic eG5kX2RldmVsb3BtZW50X09vbUFmT1V0aCtHb3dzWTZMZUpPSHpMQ1p0U2o4NEo5a1hEbitSeGovbUhXK2J5aERRVnhoZz09Og==',
            'Cookie: __cf_bm=KCu0gvCuGbmBIw2WXn7T93.aJAQBnAGqaNZ1__11ZKY-1723854684-1.0.1.1-4N5OIZ0PbOiyxO8HeqLfnsV0nxHhR6bWGcW.kNA_k3lGDJiDi4s3vWLbnHglJvZIxDnWpl.1Vljbhn43CYY..w'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
    function CreateInvoice() {
    

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.xendit.co/v2/invoices',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "external_id": "invoice-1725976794",
            "amount": 1800000,
            "payer_email": "customer@domain.com",
            "description": "Invoice Demo #123"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic eG5kX2RldmVsb3BtZW50X09vbUFmT1V0aCtHb3dzWTZMZUpPSHpMQ1p0U2o4NEo5a1hEbitSeGovbUhXK2J5aERRVnhoZz09Og==',
            'Cookie: __cf_bm=CbXHDYTJ5nNwSMR22Yh_3hQl2TXOhh1tI1nM4N4GcM0-1725976060-1.0.1.1-J9JqTTQbh1k3f9ztpsbh_BeuDlgsyXRe.pwI94eYglgRuQCYwFiJWwCy8TzmJeMqPG3hV_F9KF33hvfk_9eYXw'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        die();

    }
}