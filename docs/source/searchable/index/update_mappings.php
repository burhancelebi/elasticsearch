<?php

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
