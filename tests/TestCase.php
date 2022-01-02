<?php

namespace ElasticSearch\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use ElasticSearch\ElasticSearchServiceProvider;
use ElasticSearch\ElasticSearch;

abstract class TestCase extends OrchestraTestCase
{
    protected $elastic;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->elastic = new ElasticSearch();

        if ( $this->checkIndex() === false ) {
            $this->createIndex();
            $this->fetchData();
        }
    }

    protected function getPackageProviders($app)
    {
        return [
            ElasticSearchServiceProvider::class,
        ];
    }

    public function getIndexName()
    {
        return 'iskquaoyewymqoeawxsdornfdhaqwt';
    }

    public function checkIndex(): bool
    {
        $index = $this->elastic
                    ->index()
                    ->exists([
                        'index' => $this->getIndexName()
                    ]);

        return $index;
    }

    public function deleteIndex()
    {
        $index = $this->elastic
                    ->index()
                    ->name($this->getIndexName())
                    ->delete();

        return $index;
    }

    public function createIndex()
    {
        $index = $this->elastic
                        ->index()
                        ->name($this->getIndexName())
                        ->create();

        return $index;
    }

    public function fetchData()
    {
        $data = [
            [
                'name' => 'Şêro',
                'age' => 25,
                'location' => [
                    'lat' => 20.50,
                    'lon' => 25.63
                ]
            ],
            [
                'name' => 'Rojda',
                'age' => 32,
                'location' => [
                    'lat' => 10.50,
                    'lon' => 15.63
                ]
            ],
            [
                'name' => 'Egit',
                'age' => 24,
                'location' => [
                    'lat' => 30.50,
                    'lon' => 35.63
                ]
            ],
            [
                'name' => 'Botan',
                'age' => 26,
                'location' => [
                    'lat' => 40.50,
                    'lon' => 45.63
                ]
            ],
        ];

        foreach ($data as $key => $value) {
            $index = $this->elastic
                        ->document()
                        ->index($this->getIndexName())
                        ->body($value)
                        ->save(); 
        }
    }

    public function __destruct()
    {
        if ( $this->checkIndex() === true ) {
            $this->deleteIndex();
        }
    }
}
