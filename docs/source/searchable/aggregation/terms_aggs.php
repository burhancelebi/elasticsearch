<?php

$elastic = new ElasticSearch();

$aggs = $elastic->aggs()
            ->index('my-index')
            ->name('my-aggs')
            ->terms([
                'field' => 'age',
            ])
            ->getMap();

return $aggs;
