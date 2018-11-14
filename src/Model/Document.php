<?php
namespace Dialect\Scrive\Model;

use Illuminate\Support\Facades\File;
use phpDocumentor\Reflection\DocBlock;

class Document extends Model {



    public function __construct($id = null, $data = null)
    {
        parent::__construct($id, $data);
    }

    public function create($filePath = null, $saved = false) {
      $data = [];

      $data[] = [
          'name' => 'saved',
          'contents' => $saved ? 'true' : 'false'
      ];

      if($filePath) {
          $data[] = [
              'name' => 'file',
              'contents' => fopen($filePath, 'r'),
              'filename' => basename($filePath),
          ];
      }

      $this->data = $this->callApi('POST', 'documents/new', $data);
      $this->id = $this->data->id;
      return $this;
    }

    public function addParty($name, $email, $company = ""){
        if(!$this->data) {
            $this->get();
        }

        $data[] = [
            'name' => 'document_id',
            'contents' => $this->id
        ];

        $party =  [
            "is_signatory" => true ,
            "fields" => [
                ["type" => "name", "order" => 1, "value" => $name],
                ["type" => "email", "value" => $email],
                ["type" => "company", "value" => $company]
            ],
            "sign_order" => 1,
            "delivery_method" => "email",
            "authentication_method_to_view" => "standard",
            "authentication_method_to_sign" => "standard",
            "confirmation_delivery_method" => "email"
        ];

        $parties = $this->data->parties;
        $parties[0]->is_signatory = false;
        $parties[] = $party;

        $data[] = [
            'name' => 'document',
            'contents' => json_encode(['parties' => $parties])
        ];


        $this->data = $this->callApi('POST','documents/'.$this->id.'/update', $data);
    }
    
    public function get() {
        $this->data = $this->callApi('GET', 'documents/'.$this->id.'/get');
        return $this;
    }

    public function list($offset = 0, $max = null, $filter = [], $sorting = []) {

        $query = '?offset='.$offset;
        if($max) $query .= '&max='.$max;
        if($filter) $query .= '&filter=' .json_encode($filter);
        if($sorting) $query .= '&sorting='.json_encode($sorting);

        $data = $this->callApi('GET', 'documents/list'.$query);
        $documents = collect();
        foreach($data->documents as $rawDoc){
            $documents->push(new Document($rawDoc->id, $rawDoc));
        }
        return $documents;

    }

    public function delete() {
        if(!$this->id) {
            throw new \Exception('Invalid id '.$this->id);
        }
        $this->data = $this->callApi('POST', 'documents/'.$this->id.'/trash');
        $this->data = $this->callApi('POST', 'documents/'.$this->id.'/delete');
        return $this;

    }

    public function file($id = 'main', $name = null) {
        if(!$this->id) {
            throw new \Exception('Invalid id '.$this->id);
        }
        return $this->callApi('GET', 'documents/'.$this->id.'/files/'.$id.'/'.$name, null, true);
    }

    public function start() {
        if(!$this->id) {
            throw new \Exception('Invalid id '.$this->id);
        }
        $this->data = $this->callApi('POST', 'documents/'.$this->id.'/start');
        return $this;
    }

    public function remind() {
        if(!$this->id) {
            throw new \Exception('Invalid id '.$this->id);
        }
        $this->data = $this->callApi('POST', 'documents/'.$this->id.'/remind');
        return $this;

    }

}
