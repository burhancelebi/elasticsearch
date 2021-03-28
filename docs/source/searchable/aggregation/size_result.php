<?php

$elastic = new ElasticSearch();

$aggs = $elastic->aggs()
            ->index('my-index')
            ->name('my-avg-aggs')
            ->size(0) // default 1
            ->scope([
                'avg' => [
                    'field' => 'age'
                ]
            ])
            ->search();
