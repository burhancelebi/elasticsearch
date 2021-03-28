<?php

use ElasticSearch\ElasticSearch;

public function multiMatch()
{
    $elastic = new ElasticSearch();

    $search = $elastic->multiMatch()
                    ->index('test')
                    ->text('Şêro')
                    ->fuzziness(1)
                    ->fields(['text^3', 'name'])
                    ->search();

    return $search;
}
