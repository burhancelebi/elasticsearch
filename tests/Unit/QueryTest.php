<?php declare(strict_types=1);

namespace ElasticSearch\Tests\Unit;

use ElasticSearch\Tests\TestCase;

final class QueryTest extends TestCase
{
    private $index_name = 'php_unit_test_name';
    
    public function testCanSearchWithQueryFunction()
    {
        $query = $this->elastic
                        ->query([
                            'index' => $this->getIndexName(),
                            'body' => [
                                'query' => [
                                    'match' => [
                                        'name' => 'Şêro'
                                    ]
                                ]
                            ]
                        ])
                        ->search();

        $this->assertIsArray($query);
    }

    public function testCanCreateIndexWithQueryFunction()
    {
        $query = $this->elastic
                        ->query([
                            'index' => $this->index_name,
                        ])
                        ->createIndex();

        $this->assertIsArray($query);
    }

    public function testCanDeleteAnIndexWithQuery()
    {
        $query = $this->elastic
                        ->query([
                            'index' => $this->index_name,
                        ])
                        ->deleteIndex();

        $this->assertIsArray($query);
    }

    public function testCanUpdateIndexMappingToGeoPoint()
    {        
        $map = $this->elastic
                        ->index()
                        ->name($this->getIndexName())
                        ->mappings(function(){
                                return $this
                                        ->body([
                                            'properties' => [
                                                'location.keyword' => [
                                                    'type' => 'geo_point',
                                                ]
                                            ]
                                        ])
                                        ->getMap();
                        })
                        ->updateMap();

        $this->assertIsArray($map);
        $this->assertTrue($map['acknowledged']);
    }
    
    public function testCanSearchByLocationUsingSort()
    {
        $geo = $this->elastic->query([
                    'index' => $this->getIndexName(),
                    'body' => [
                        'sort' => [
                            [
                                '_geo_distance' => [
                                    "location.keyword" => [
                                        "lat" => 9.21,
                                        "lon" => 10.21
                                    ],
                                        "order" => "desc",
                                        "unit"  =>"km"
                                ]
                            ]
                        ]
                    ]
                ])
                ->search();

        $this->assertIsArray($geo);
    }

    public function testCanUseElasticSearchFunctions()
    {
        $query = $this->elastic
                        ->query()
                        ->cat()
                        ->aliases();

        $this->assertIsArray($query);
    }
}