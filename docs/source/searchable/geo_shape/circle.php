<?php

$geo = $elastic->geoShape()
                ->index('my-index')
                ->type('circle')
                ->text('Şêro')
                ->coordinates([-77.30, 38.34])
                ->radius('111km')
                ->search();

return $geo;
