<?php

$suggest = $elastic->suggest()
                ->index('my-index')
                ->name('product-suggestion')
                ->text('tring out Elasticsearch')
                ->term(['name' => 'message'])
                ->input([ "Nevermind", "Nirvana" ])
                ->weight(34)
                ->prefix('nir')
                ->regex('regex')
                ->completion([
                    'field' => 'suggest',
                    'size'  => 10,
                    'contexts' => [
                        'place_type' => [
                            [
                                'context' => 'cafe'
                            ],
                            [
                                'context'   => 'restaurants',
                                'boost'     => 2
                            ]
                        ]
                    ]
                ])
                ->contexts([
                    [
                        "name" => "place_type",
                        "type" => "category"
                    ],
                    [
                        "name" => "location",
                        "type" => "geo",
                        "precision" => 4
                    ],
                ])
                ->simplePhrase(function(){
                    return $this
                            ->field('name')
                            ->directGenerator([
                                [
                                    'field' => 'name',
                                    'suggest_mode'  => 'always'
                                ],
                                [
                                    "field" => "title.reverse",
                                    "suggest_mode" => "always",
                                    "pre_filter" => "reverse",
                                    "post_filter" => "reverse"
                                ]
                            ])
                            ->highlight([
                                'pre_tag' => "<em>",
                                'post_tag' => "</em>"
                            ])
                            ->collate([
                                'source' => [
                                    'match' => [
                                        "{{field_name}}" => "{{suggestion}}"
                                    ]
                                ]
                            ])
                            ->smoothing([
                                'laplace' => [
                                    'alpha' => 0.7
                                ]
                            ])
                            ->size(2)
                            ->getMap();
                })
                ->getMap();
