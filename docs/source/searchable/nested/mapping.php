<?php

$index = $this->elastic
                    ->index()
                    ->name('my-index')
                    ->mappings(function(){
                            return $this
                                    ->property('user', [
                                        'type' => 'nested'
                                    ])
                                    ->getMap();
                    })
                    ->create();
