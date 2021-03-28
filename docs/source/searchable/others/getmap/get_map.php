<?php

$map = $elastic->index()
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
                ->getMap(); // it returns map

return $map;

// You will get something like that:
/* {"index":"my-index","body":{"mappings":{"properties":{"location.keyword":{"ty pe":"geo_shape"}}}}} */
