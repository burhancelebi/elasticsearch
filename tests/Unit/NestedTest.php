<?php declare(strict_types=1);

use ElasticSearch\Tests\TestCase;

class NestedTest extends TestCase
{
    public function testCanCreateMappingAsNestedType()
    {
        $this->deleteIndex();

        $index = $this->elastic
                    ->index()
                    ->name($this->getIndexName())
                    ->mappings(function(){
                            return $this
                                    ->property('user', [
                                        'type' => 'nested'
                                    ])
                                    ->getMap();
                    })
                    ->create();

        $this->assertTrue($index['acknowledged']);
        $this->assertTrue($index['shards_acknowledged']);
        $this->assertSame($index['index'], $this->getIndexName());
    }

    public function testCanSaveNestedData()
    {
        $save = $this->elastic->document()
                ->index($this->getIndexName())
                ->body([
                    'group' => 'fans',
                    'user' => [
                        [
                            'first' => 'John',
                            'last'  => 'Smith'
                        ],
                        [
                            'first' => 'Alice',
                            'Last' => 'White'
                        ]
                    ]
                ])
                ->save();

        $this->assertSame($save['_index'], $this->getIndexName());
        $this->assertSame($save['_type'], '_doc');
        $this->assertSame($save['result'], 'created');
    }
    
    public function testCanSearchWithNestedType()
    {
        $nested = $this->elastic
                    ->nested()
                    ->index($this->getIndexName())
                    ->path('user')
                    ->params('size', 2)
                    ->addQuery('elastic.bool', function() {
                        return $this
                                ->must([
                                    [
                                        'match' => ['user.first' => 'Alice']
                                    ]
                                ])
                                ->getMap();
                    })
                    ->search();

        $this->assertIsArray($nested);
    }
}
