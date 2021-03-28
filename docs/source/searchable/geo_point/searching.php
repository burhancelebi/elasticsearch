<?php

$search = $elastic->geoPoint()
                    ->index('my-index')
                    ->topLeft(42, -72)
                    ->bottomRight(40, -74)
                    ->getMap();

return $search;
