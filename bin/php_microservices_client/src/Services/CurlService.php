<?php
namespace ApiApp\Services;

use Symfony\Component\HttpClient\CurlHttpClient;

class CurlService
{
    private string $api_host;
    

    public function __construct(string $api_host)
    {
        $this->api_host = $api_host;
    }

    
    public function apiResponse(string $api_url, array $data, $method){
        $ch = curl_init($this->api_host.$api_url);
        
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            //CURLOPT_POST => true,
            CURLOPT_CUSTOMREQUEST =>  $method,
            CURLOPT_POSTFIELDS => http_build_query($data) 
        ));
            $response = curl_exec($ch);
            print_r($response);
            if (curl_errno($ch)) {
                $response = curl_error($ch);
            }
            curl_close($ch);
            return $response;
    }
    /*
    public function newApi(){
        $client = new CurlHttpClient();

        $client->request('GET', $this->api_url, [
            
            'headers' => [
                'Content-Type' => 'application/json',
                "Accept: application/json",
            ],
            'body' =>  ['name' => 'some_user_name', 'password' => 'some_password'],
            'extra' => [
                'curl' => [
                    CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V6,
                ],
            ],
        ]);
    }
    */
}