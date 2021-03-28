<?php

$elastic = new ElasticSearch();

$suggest = $elastic->suggest()
                ->index('my-index')
                ->id(1)
                ->input([
                    [
                        'input' => 'My name is Şêro',
                        'weight' => 25
                    ]
                ])
                ->save();
