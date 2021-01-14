<?php declare(strict_types=1);

use ElasticSearch\Tests\TestCase;

class MultiMatchTest extends TestCase
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createIndexAndFetchData()
    {
        $exists = $this->checkIndex();

        if ( $exists === false ) {
            
            $this->createIndex();
        }

        $this->fetchData();
    }

    public function testCanBeSearchedSimple()
    {
        $this->createIndexAndFetchData();
        sleep(3);

        $search = $this->elastic
                    ->multiMatch()
                    ->index($this->getIndexName())
                    ->text('Şêro')
                    ->fields(['name'])
                    ->search();

        $this->assertIsArray($search);
    }

    public function testCanLimitOfData()
    {
        $search = $this->elastic
                    ->multiMatch()
                    ->index($this->getIndexName())
                    ->size(1)
                    ->text('Rojda')
                    ->fields(['name'])
                    ->search(['hits']);

        $this->assertIsArray($search);
        $this->assertSame(count($search['hits']['hits']), 1);
    }

    public function testMaximumEditDistanceAllowedForMatching()
    {
        $search = $this->elastic
                    ->multiMatch()
                    ->index($this->getIndexName())
                    ->size(1)
                    ->fuzziness(1)
                    ->text('Şêr')
                    ->fields(['name'])
                    ->search(['hits']);

        $this->assertIsArray($search);
        $this->assertSame(count($search['hits']['hits']), 1);
    }

    public function testCanMerge()
    {
        $search = $this->elastic
                        ->multiMatch()
                        ->size(1)
                        ->index($this->getIndexName())
                        ->text('Şêro')
                        ->fuzziness(1)
                        ->fields(['name'])
                        ->mergeWith('elastic.sort', function(){
                            return $this
                                    ->field('age')
                                    ->order('desc')
                                    ->getMap();
                        })
                        ->mergeWith('elastic.highlight', function(){
                            return $this
                                    ->content('name', '<div>', '</div>')
                                    ->getMap();
                        })
                        ->getMap();

        $this->assertArrayHasKey('highlight', $search['body']);
        $this->assertArrayHasKey('sort', $search['body']);
    }

    public function testCanSearchWithMergeFunction()
    {
        $search = $this->elastic
                        ->multiMatch()
                        ->size(1)
                        ->index($this->getIndexName())
                        ->text('Şêr')
                        ->fuzziness(1)
                        ->fields(['name'])
                        ->mergeWith('elastic.sort', function(){
                            return $this
                                    ->field('age')
                                    ->order('desc')
                                    ->getMap();
                        })
                        ->mergeWith('elastic.highlight', function(){
                            return $this
                                    ->content('name', '<div>', '</div>')
                                    ->getMap();
                        })
                        ->search();

        $this->assertIsArray($search);
    }
}
