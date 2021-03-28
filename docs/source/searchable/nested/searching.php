<?php

$nested = $this->elastic
                    ->nested()
                    ->index('my-index')
                    ->path('user')
                    ->params('size', 2)
                    ->addQuery('elastic.bool', function() {
                        return $this
                                ->must([
                                    [
                                        'match' => ['user.first' => 'Alice']
                                    ]
                                ])
                                ->getMap();
                    })
                    ->search();
