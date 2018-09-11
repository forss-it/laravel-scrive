<?php
use Dialect\Scrive\Scrive;
class ScriveTest extends \Dialect\Scrive\TestCase
{
    /** @test */
    public function it_can_get_an_empty_document_model(){
        $this->assertEquals(get_class(Scrive::document()), 'Dialect\Scrive\Model\Document');
    }

    /** @test */
    public function it_can_get_an_empty_document_model_with_id(){
        $document = Scrive::document(100);

        $this->assertEquals($document->id, 100);
    }


}
