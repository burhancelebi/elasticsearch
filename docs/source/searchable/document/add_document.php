<?php

$elastic = new ElasticSearch();

$index = $elastic->document()
                ->index('my-index')
                ->body([
                    'text' => 'What is your name',
                    'location' => [
                        'type' => 'point',
                        'coordinates' => [50.30, 20.34],
                    ]
                ])
                ->save();

// You can merge with suggest
$index = $elastic->document()
                ->index('my-index')
                ->body([
                    'text' => 'My name is Şêro',
                    'location' => [
                        'type' => 'point',
                        'coordinates' => [50.30, 20.34],
                    ]
                ])
                ->mergeWith('suggest', function(){
                        return $this
                                ->input([
                                    [
                                        'input' => 'Music Time',
                                        'weight' => 20
                                    ]
                                ])
                                ->getMap();
                    })
                ->save();
