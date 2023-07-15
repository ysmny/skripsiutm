<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiController extends Controller
{
    public function postapi()
    {
        $data = [
            'api_key' => 'psZqb3rwqBNUNqHvR2MkGfzOF7oBDW',
            'sender' => '6287787518398',
            'number' => '6282301261900',
            'message' => 'Your message test'
        ];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://wa.srv3.waboxs.com/send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}
