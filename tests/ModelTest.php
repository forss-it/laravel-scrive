<?php
use Dialect\Scrive\Scrive;
use \Dialect\Scrive\Model\Document;
class ModelTest extends \Dialect\Scrive\TestCase
{
    /** @test */
    public function it_can_generate_headers(){
        $document = new Document();
        $headers = $this->callMethod($document, 'getHeaders', []);
        $this->assertArrayHasKey('Authorization', $headers);
    }

    /** @test */
    public function it_can_get_different_api_urls_if_is_developer_or_not(){
        $document = new Document();
        $devUrl = $this->callMethod($document, 'getApiUrl', []);
        config()->set('scrive.developer_mode', false);
        $url = $this->callMethod($document, 'getApiUrl', []);
        $this->assertNotEquals($devUrl, $url);
    }


}
