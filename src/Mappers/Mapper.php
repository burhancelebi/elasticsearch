<?php

namespace ElasticSearch\Mappers;

class Mapper
{
    const MULTI_MATCH = [
        'body' => [
            'query' => [

            ]
        ]
    ];

    const BOOL_QUERY = [
        'body' => [
            'query' => [
                'bool' => [

                ]
            ]
        ]
    ];

    const SORT = [
        'body' => [
            'sort' => []
        ]
    ];

    const RANGE = [
        'body' => [
            'query' => [
                'range' => [

                ]
            ]
        ]
    ];

    const UPDATE = [
        'body' => [
            'doc' => [
                
            ]
        ]
    ];

    const MATCH = [
        'body'  => [
            'query' => [
                'match' => [
                ]
            ]
        ]
    ];

    const MATCH_PHRASE = [
        'body'  => [
            'query' => [
                'match_phrase'  => []
            ]
        ]
    ];

    const HIGHLIGHT = [
        'body'  => [
            'highlight' => [
                'fields' => []
            ]
        ]
    ];

    const NESTED = [
        'body'  => [
            'nested' => []
        ]
    ];
}