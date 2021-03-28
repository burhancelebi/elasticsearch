<?php

$elastic = new ElasticSearch();

$match = $elastic->match()
                    ->index('my-index')
                    ->field([
                            'name' => [
                                'query' => 'Şêro',
                                'fuzziness' => 1
                            ]
                        ])
                    ->search();

// You can merge with other features:

    $match = $elastic->match()
                    ->index('my-index')
                    ->field([
                            'name' => [
                                'query' => 'Şêro',
                                'fuzziness' => 1
                            ]
                        ])
                    ->mergeWith('elastic.sort', function(){
                        return $this->field('age')
                                    ->order('desc')
                                    ->getMap();
                    })
                    ->mergeWith('elastic.highlight', function(){
                        return $this
                                ->content('name', '<div>', '</div>')
                                ->getMap();
                    })
                    ->search();

return $match;
