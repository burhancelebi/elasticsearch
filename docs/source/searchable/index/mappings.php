<?php

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
