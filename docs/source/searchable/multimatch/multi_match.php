<?php

$search = $elastic->multiMatch()
                ->index('my-index')
                ->text('Şêro')
                ->fields(['name^3'])
                ->search();

// If you want to set limit :
$search = $elastic->multiMatch()
                ->index('my-index')
                ->size(10) // returns max 10 data
                ->text('Şêro')
                ->fields(['name^3'])
                ->search();

//  add fuzziness :
$search = $elastic->multiMatch()
                ->index('my-index')
                ->size(10)
                ->fuzziness(1) // Ideal value is 1 and 2
                ->text('Şêro')
                ->fields(['name^3'])
                ->search();

// Merge with sort query :
$search = $elastic->multiMatch()
                ->index('my-index')
                ->size(10)
                ->fuzziness(1)
                ->text('Şêro')
                ->fields(['name^3'])
                ->mergeWith('elastic.sort', function(){
                        return $this
                                ->field('age')
                                ->order('desc')
                                ->getMap();
                    })
                ->search();

// Merge with aggregations

$search = $elastic->multiMatch()
                ->index('my-index')
                ->text('Şêro')
                ->fuzziness(1)
                ->fields(['name^3'])
                ->mergeWith('elastic.aggs', function(){
                  return $this
                            ->name('my-aggs')
                            ->terms([
                                    'field' => 'age'
                            ])
                            ->subAggs(function(){
                                return $this
                                    ->name('sub-aggs')
                                    ->scope([
                                        'avg' => [
                                            'field' => 'age'
                                        ]
                                    ])
                                    ->getMap();
                            })
                            ->getMap();
                })
                ->search();

// Merge with highlight query :
$search = $elastic->multiMatch()
                ->index('my-index')
                ->size(10)
                ->fuzziness(1)
                ->text('Şêro')
                ->fields(['name^3'])
                ->mergeWith('elastic.sort', function(){
                        return $this
                                ->field('age')
                                ->order('desc')
                                ->getMap();
                })
                ->mergeWith('elastic.highlight', function(){
                            return $this
                                ->content('name', '<div>', '</div>')
                                ->getMap();
                })
                ->search();

// Other useful functions
$search = $elastic->multiMatch()
            ->index('my-index')
            ->size(10)
            ->fuzziness(1)
            ->text('Şêro')
            ->fields(['name^3'])
            ->analyzer('standard')
            ->tieBreaker(0.3)
            ->operator('and')
            ->type('most_fields')
            ->search();
