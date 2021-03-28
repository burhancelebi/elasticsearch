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
            ->search();

return $aggs;
