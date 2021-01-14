<?php declare(strict_types=1);

use ElasticSearch\Tests\TestCase;

final class SuggestTest extends TestCase
{    
    public function testCanSaveASuggest()
    {        
        $suggest = $this->elastic
                            ->suggest()
                            ->index($this->getIndexName())
                            ->id(2)
                            ->input([
                                [
                                    'input' => 'What is your name ?',
                                    'weight' => 20
                                ]
                            ])
                            ->save();
                            
        $this->assertIsArray($suggest);

        $this->assertThat($suggest['result'], $this->logicalOr(
            $this->equalTo('created'),
            $this->equalTo('updated'),
        ));
    }

    public function testCanPutSuggestMapping()
    {
        $exists = $this->checkIndex();

        if ( $exists === true ) {

            $this->deleteIndex();
            $this->createIndex();
        }
        
        $index = $this->elastic
                        ->index()
                        ->name($this->getIndexName())
                        ->mappings(function(){
                                return $this
                                        ->suggest([
                                            'type' => 'completion',
                                        ])
                                        ->property('name', [
                                            'type' => 'keyword'
                                        ])
                                        ->getMap();
                        })
                        ->updateMap();

        $this->assertIsArray($index);
        $this->assertIsBool($index['acknowledged']);
    }

    public function testCanUseSuggest()
    {
        $suggest = $this->elastic
                        ->suggest()
                        ->index($this->getIndexName())
                        ->name('blog-suggest')
                        ->text('what is ')
                        ->completion([
                            'field' => 'suggest',
                            'skip_duplicates' => true,
                            'fuzzy' => [
                                'fuzziness' => 1
                            ]
                        ])
                        ->search();

        $this->assertIsArray($suggest);
    }
}