<?php declare(strict_types=1);

namespace ElasticSearch\Tests\Unit;

use ElasticSearch\Tests\TestCase;

final class SaveDocumentTest extends TestCase
{
    private $indexName = null;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->getIndexName();
    }

    public function testCanSaveADocument()
    {
        $result = $this->elastic
                        ->document()
                        ->index($this->getIndexName())
                        ->body([
                            'name' => 'PHPUnit Test',
                            'age' => 20
                        ])
                        ->save();
                        
        $this->assertIsArray($result);
        $this->assertSame($result['result'], 'created');
    }

    public function testCanSaveADocumentWithSuggest()
    {
        $index = $this->getIndexName();
        
        $result = $this->elastic
                        ->document()
                        ->index($this->getIndexName())
                        ->body([
                            'name' => 'PHPUnit Test',
                            'age' => 20
                        ])
                        ->mergeWith('suggest', function() use ($index){
                            return $this
                                    ->index($index)
                                    ->input([
                                        [
                                            'input' => 'Test Time',
                                            'weight' => 20
                                        ]
                                    ])
                                    ->getMap();
                        })
                        ->save();

        $this->assertIsArray($result);
    }
}