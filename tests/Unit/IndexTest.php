<?php declare(strict_types=1);

use ElasticSearch\Tests\TestCase;

final class IndexTest extends TestCase
{
    private $indexName = null;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->getIndexName();
    }
    
    public function testChecksIfAnIndexExists()
    {
        $exists = $this->checkIndex();

        $this->assertIsBool($exists);
    }
    
    public function testCanBeCreatedAnIndex()
    {
        $exists = $this->checkIndex();

        if ( $exists === true ) {

            $this->deleteIndex();
        }
        
        $index = $this->createIndex();

        $this->assertTrue($index['acknowledged']);
    }

    public function testCanReturnElasticMap()
    {
        $index = $this->elastic->index()
                                ->name($this->getIndexName())
                                ->getMap();

        $this->assertIsArray($index);
    }

    public function testCanGetIndexSettings()
    {
        $index = $this->elastic
                        ->index()
                        ->getSettings([
                            'index' => $this->getIndexName()
                        ]);

        $this->assertIsArray($index);
        $this->assertArrayHasKey($this->getIndexName(), $index);
    }

    public function testCanGetIndexMapping()
    {
        $index = $this->elastic
                        ->index()
                        ->map([
                            'index' => $this->getIndexName()
                        ]);

        $this->assertIsArray($index);
        $this->assertArrayHasKey($this->getIndexName(), $index);
    }

    public function testCanAddSuggestToIndex()
    {
        $exists = $this->checkIndex();

        if ( $exists === true ) {
            
            $this->deleteIndex();
        }
        
        $index = $this->elastic
                        ->index()
                        ->name($this->getIndexName())
                        ->mappings(function(){
                            return $this
                                    ->suggest([
                                        'type' => 'completion',
                                    ])
                                    ->property('title', [
                                        'type' => 'text'
                                    ])
                                    ->getMap();
                        })
                        ->create();

            $this->assertTrue($index['acknowledged']);
    }

    public function testCanGetIndicesInformation()
    {
        $index = $this->elastic
                        ->query()
                        ->getIndices();

        $this->assertIsArray($index);
    }

    public function testCanGetSpecificIndicesInformation()
    {
        $index = $this->elastic
                        ->query(['pointsort'])
                        ->getIndices();

        $this->assertIsArray($index);
        $this->assertSame(count($index), 1);
    }

    public function testCanDeleteAnIndexIfIndexExists()
    {
        $exists = $this->checkIndex();

        if ( $exists === true ) {

            $index = $this->deleteIndex();

            $this->assertTrue($index['acknowledged']);
        }else {
            $this->assertFalse($exists);
        }
    }
}