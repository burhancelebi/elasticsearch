<?php

$index = $elastic->document()
                ->index('my-index')
                ->body([
                    'text' => 'Şêro',
                    'location' => [
                        'type' => 'point',
                        'coordinates' => [-77.30, 38.34],
                    ]
                ])
                ->save();
