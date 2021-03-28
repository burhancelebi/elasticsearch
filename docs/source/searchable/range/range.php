<?php

$elastic = new ElasticSearch();

$search = $elastic->range()
                ->index('my-index')
                ->content([
                    'age' => [
                        'gte' => 21,
                        'lte' => 26
                    ]
                ])
                ->search();

return $search;
