<?php
namespace Dialect\Scrive\Model;

use GuzzleHttp\Client;

class Model {
    public $id;
    public $data;
    public function __construct($id = null, $data = null)
    {
        $this->id = $id;
        $this->data = $data;
    }
    
    protected function getHeaders() {
        $authString = 'oauth_signature_method="PLAINTEXT"';
        $authString .= ', oauth_consumer_key="'.config('scrive.secret_client_identifier').'"';
        $authString .= ', oauth_token="'.config('scrive.secret_token_identifier').'"';
        $authString .= ', oauth_signature="'.config('scrive.secret_client_secret').'&'.config('scrive.secret_token_secret').'"';

        return [
            'Authorization' => $authString
        ];
    }

    protected function getApiUrl() {
        if(config('scrive.developer_mode')) {
            return 'https://api-testbed.scrive.com/api/v2/';
        }

        return 'https://scrive.com/api/v2/';
    }

    protected function callApi($method, $endPoint, $data = null, $file = false) {
        $client = new Client();
        $requestData = [
            'headers' => $this->getHeaders(),
        ];
        if($data) {
            $requestData['multipart'] = $data;
        }

        $response = $client->request($method, $this->getApiUrl().$endPoint, $requestData);
        if($file) {
            return $response->getBody();
        }
        return json_decode($response->getBody()->getContents());
    }
}