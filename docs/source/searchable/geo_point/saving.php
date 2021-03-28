<?php

$data = $elastic->document()
                ->index('my-index')
                ->body([
                    'text' => 'Şêro',
                    'location' => [
                        "lat" => 41.12,
                        "lon" => -71.34
                    ]
                ])
                ->save();
