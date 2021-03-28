<?php

$elastic = new ElasticSearch();

$result = $elastic->query([
    'index' => 'my-index',
    'body' => [
        'query' => [
            'match' => [
                'name' => [
                    'query' => 'Şêro',
                    'fuzziness' => 1
                ]
            ]
        ]
    ]
])->search();

return $result;
