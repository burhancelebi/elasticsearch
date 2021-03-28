<?php

$elastic = new ElasticSearch();

$aggs = $elastic->aggs()
        ->index('my-index')
        ->name('my-aggs')
        ->scope([
            'avg' => [
                'field' => 'age'
            ]
        ])
        ->addAggs(function(){
            return $this
                ->name('my-aggs-2')
                ->size(0)
                ->scope([
                    'avg' => [
                        'field' => 'age'
                    ]
                ])->getMap();
        })
        ->addAggs(function(){
            ...
        })
        ->search();

return $aggs;
