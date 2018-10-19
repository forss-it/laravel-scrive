<?php
namespace Dialect\Scrive\Model;

use GuzzleHttp\Client;

class Model {
    public $id;
    public $data;
    private $clientIdentifier;
    private $tokenIdentifier;
    private $clientSecret;
    private $tokenSecret;
    public function __construct($id = null, $data = null)
    {
        $this->id = $id;
        $this->data = $data;
        $this->setCredentials(config('scrive.secret_client_identifier'), config('scrive.secret_token_identifier'), config('scrive.secret_client_secret'), config('scrive.secret_token_secret'));

    }

    public function setCredentials($clientIdentifier, $tokenIdentifier, $clientSecret, $tokenSecret) {
        $this->clientIdentifier = $clientIdentifier;
        $this->tokenIdentifier = $tokenIdentifier;
        $this->clientSecret = $clientSecret;
        $this->tokenSecret = $tokenSecret;

        return $this;
    }
    
    protected function getHeaders() {
        $authString = 'oauth_signature_method="PLAINTEXT"';
        $authString .= ', oauth_consumer_key="'. $this->clientIdentifier.'"';
        $authString .= ', oauth_token="'.$this->tokenIdentifier.'"';
        $authString .= ', oauth_signature="'.$this->clientSecret.'&'.$this->tokenSecret.'"';

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