<?php

$elastic = new ElasticSearch();

// Search using must
$search = $elastic->bool()
                ->index('my_index')
                ->must([
                    ['term' => ['name.keyword' => 'Şêro']]
                ])
                ->search();

// add filter
$search = $elastic->bool()
                ->index('my_index')
                ->must([
                    ['term' => ['name.keyword' => 'Şêro']]
                ])
                ->filter([
                        ['term' => ['tags' => 'production']]
                ])
                ->minimum_should_match(1)
                ->boost(1)
                ->search();

// must not
                    ...
                    ->mustNot([
                        ['range' => ['gte' => 10, 'lte' => 20]]
                    ]);

// should
                ...
                ->should([
                        ['term' => ['tags' => 'env1']],
                        ['term' => ['tags' => 'deployed']]
                    ])

// Merge with SORT
                    ...
                    ->mergeWith('elastic.sort', function(){
                        return $this
                                ->field('age')
                                ->order('asc')
                                ->getMap();
                    });

// Merge with HIGHLIGHT
                        ...
                    ->mergeWith('elastic.highlight', function(){
                        return $this
                            ->content('name.keyword', '<div>', '</div>')
                            ->getMap();
                    });

// You can add GEO FILTER
            ...
            ->addGeoFilter('geo_shape', function(){
                            return $this
                                    ->index('location')
                                    ->type('circle')
                                    ->text('What is your name')
                                    ->coordinates([51.30, 20.34])
                                    ->radius('111km')
                                    ->getMap();
            });

return $search;
