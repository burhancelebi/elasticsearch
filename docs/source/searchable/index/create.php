<?php

    $elastic = new ElasticSearch();
    $index = $elastic->index()
                    ->name('my-index')
                    ->create();

    return $index;
