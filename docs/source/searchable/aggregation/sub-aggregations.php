<?php

$elastic = new ElasticSearch();

$aggs = $elastic->aggs()
        ->index('my-index')
        ->name('my-aggs')
        ->terms([
            'field' => 'age',
        ])
        ->subAggs(function(){
            return $this
                ->name('sub-aggs')
                ->scope([
                    'avg' => [
                        'field' => 'age'
                    ]
                ])
                ->getMap();
        })
        // you can add multiple sub-aggregations
        ->subAggs(function(){
            ...
        })
        ->search();

// Or you can use like that:

$aggs = $elastic->aggs()
                ->index('my-index')
                ->name('my-avg-aggs')
                ->terms([
                    'field' => 'age',
                ])
                ->addAggs(function(){
                    return $this
                        ->name('my-avg-aggs-2')
                        ->size(0)
                        ->terms([
                            'field' => 'age',
                        ])
                        ->subAggs(function(){
                            return $this
                                ->name('sub-aggs')
                                ->scope([
                                    'avg' => [
                                        'field' => 'age'
                                    ]
                                ])
                                ->getMap();
                        })
                        ->getMap();
                })
                ->getMap();

return $aggs;
