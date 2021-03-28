<?php


$index = $elastic
                ->index()
                ->name('my-index')
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
