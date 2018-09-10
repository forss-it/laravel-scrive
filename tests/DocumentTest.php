<?php
use Dialect\Scrive\Scrive;
use \Dialect\Scrive\Model\Document;
class DocumentTest extends \Dialect\Scrive\TestCase
{
    /** @test */
    public function it_can_create_new_document(){
        $document = Scrive::document()->create()->data;
        $this->assertNotNull($document);
    }

    /** @test */
    public function it_can_create_new_document_with_file(){
        $document = Scrive::document()->create(__DIR__.'/testfiles/pdf-sample.pdf')->data;
        $this->assertNotNull($document);
        $this->assertNotNull($document->file);
        $this->assertEquals($document->file->name, 'pdf-sample.pdf');
        $this->assertFalse($document->is_saved);
    }

    /** @test */
    public function it_can_get_existing_document(){
        $document = Scrive::document()->create(null, true);

        $existingDocument = Scrive::document($document->id)->get();
        $this->assertNotNull($existingDocument);
        $this->assertEquals($document->data->id, $existingDocument->data->id);
    }

    /** @test */
    public function it_can_list_all_existing_documents(){
        $document = Scrive::document()->create(null, true);
        $documents = Scrive::document()->list(0,1);
        $this->assertNotEmpty($documents);

    }

    /** @test */
    public function it_can_start_the_signing_proccess(){
        $document = Scrive::document()->create(__DIR__.'/testfiles/pdf-sample.pdf', true);
        $document->start();
        $this->assertEquals($document->data->status, 'pending');


    }

}
