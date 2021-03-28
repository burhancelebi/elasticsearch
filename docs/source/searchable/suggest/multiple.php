<?php

$suggest = $elastic->suggest()
            ->index('my-index')
            ->name('my-index-suggest')
            ->text('My name is ') // it returns "My name is Şêro"
            ->completion([
                'field' => 'suggest',
                'skip_duplicates' => true
            ])
            ->addSuggest(function(){
                return $this->index('my-index')
                        ->name('my-index-suggest-2')
                        ->text('Music')
                        ->completion([
                            'field' => 'suggest',
                            'skip_duplicates' => true,
                            'fuzzy' => [
                                'fuzziness' => 1
                            ]
                        ])
                        ->getMap();
            })
            ->addSuggest(function(){
                return $this->index('my-index')
                            ->name('my-index-suggest-3')
                            ->text('Music')
                            ->completion([
                                'field' => 'suggest',
                                'skip_duplicates' => true
                            ])
                            ->getMap();
                })
            ->search();

return $suggest;
