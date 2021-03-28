<?php

$index = $elastic
        ->index()
        ->name('my_index')
        ->mappings(function(){
                return $this
                        ->body([
                            'properties' => [
                                'location' => [
                                    'type' => 'geo_point',
                                ]
                            ]
                        ])
                        ->getMap();
        })
        ->updateMap();
