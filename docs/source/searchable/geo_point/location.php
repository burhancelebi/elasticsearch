<?php

$geo = $elastic->geoPoint()
                ->index('my-index')
                ->pointType('geo_distance')
                ->location([
                    'location' => [
                        "top_left" => [
                            "lat" => 42,
                            "lon" => -72
                        ],
                        "bottom_right" => [
                            "lat" => 40,
                            "lon" => -74
                        ]
                    ]
                ])
                ->search();

// you don't need to use pointType(), it will return geo_bounding_box by default

return $geo;
