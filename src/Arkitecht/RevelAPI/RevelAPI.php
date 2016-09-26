<?php
namespace Arkitecht\RevelAPI;

use Arkitecht\RevelAPI\Objects\Account;
use Arkitecht\RevelAPI\Objects\Device;
use GuzzleHttp;

class RevelAPI
{
    private $client;
    private $endpoint = 'http://api.reveldigital.com';
    private $api_key;
    private $last_response;


    public function __construct($api_key)
    {
        $this->api_key = $api_key;
        $this->client = new GuzzleHttp\Client([
            'base_uri' => $this->endpoint
        ]);
    }

    public function account()
    {
        return (new Account($this))->get();
    }

    public function devices($id = '')
    {
        return (new Device($this))->get($id);
    }

    public function devicesRequest()
    {
        return (new Device($this));
    }

    public function makeRequest($endpoint, $method = 'GET', $params = [], $headers = [], $json = [])
    {
        $default_headers = [
            'Content-Type' => 'application/json'
        ];

        $all_headers = array_merge($default_headers, $headers);

        $default_params = [
            //'format'  => 'json'
            'api_key' => $this->api_key
        ];

        $all_params = array_merge($default_params, $params);

        $param_key = ($method == 'GET' || $json) ? 'query' : 'form_params';


        $response = $this->client->request($method, $endpoint, [
            'headers'  => $all_headers,
            $param_key => $all_params,
            'json'     => $json
        ]);

        $this->last_response = $response;

        //HANDLE ERROR CODES

        if ($response->getStatusCode() != 200) {

        } else {
            return json_decode($response->getBody()->getContents());
        }

        return $response;
    }
}