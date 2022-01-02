<?php declare(strict_types=1);

namespace ElasticSearch\Tests\Unit;

use ElasticSearch\Tests\TestCase;

final class GeoShapeTest extends TestCase
{
    public function testCanChangeMappingToGeoShape()
    {
        $this->deleteIndex();
        $this->createIndex();

        $mapping = $this->elastic
                        ->index()
                        ->name($this->getIndexName())
                        ->mappings(function(){
                                return $this
                                        ->body([
                                            'properties' => [
                                                'location' => [
                                                    'type' => 'geo_shape',
                                                ]
                                            ]
                                        ])
                                        ->getMap();
                        })
                        ->updateMap();
                    
        $this->assertIsArray($mapping);
        $this->assertTrue($mapping['acknowledged']);
    }
    
    public function testCanSearchByLocationAsTypeCircle()
    {
        $search = $this->elastic
                        ->geoShape()
                        ->index($this->getIndexName())
                        ->type('circle')
                        ->coordinates([30, 10])
                        ->radius('111km')
                        ->search();

        $this->assertIsArray($search);
    }
}