<?php

Index
===============

Adds a JSON document to the specified data stream or index and makes it searchable.

Add this namespace to your class.

    use ElasticSearch\ElasticSearch;

**Index Information**

    $elastic = new ElasticSearch();

    $result = $elastic->query()->getIndices(); // It returns all indices information

    // You can get specific index information.

    $result = $elastic->query(['pointsort,location'])->getIndices();

    return $result;


**Create Index**

    $elastic = new ElasticSearch();
    $index = $elastic->index()
                    ->name('my-index')
                    ->create();

    return $index;

**Delete an index**

	$index = $elastic->index()
			->name('my-index')
			->delete();

You can use settings or mappings function when creating a index

**Settings**

    $index = $elastic->index()
                ->name('my-index')
                ->settings([
                    'number_of_shards' => 3,
                    'number_of_replicas' => 2
                ])
                ->create();

**Mappings**

    $index = $elastic->index()
                ->name('my-index')
                ->mappings(function(){ // Closure $mappings
                    return $this->suggest([
                                'type' => 'completion',
                            ])
                            ->property('title', [
                                'type' => 'text'
                            ])
                            ->getMap();
                })
                ->create();

    return $index;

**Check if an index exists**

    $exists = $elastic->index()
                    ->exists([
                        'index' => 'my-index'
                    ]);

    return $exists;

**Get index settings**

    $settings = $elastic->index()
                        ->getSettings([
                            'index' => 'my-index'
                        ]);

    return $settings;

**Get index mappings**

    $map = $elastic->index()
                    ->map([
                        'index' => 'my-index'
                    ]);

    return $map;

**Update index mappings**

    $index = $elastic->index()
                    ->name('my-index')
                    ->mappings(function(){
                            return $this
                                    ->body([
                                        'properties' => [
                                            'location.keyword' => [
                                                'type' => 'geo_shape',
                                            ]
                                        ]
                                    ])
                                    ->getMap();
                    })
                    ->updateMap();

    return $index;
