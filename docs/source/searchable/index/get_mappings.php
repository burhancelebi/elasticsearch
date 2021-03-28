<?php 

$map = $elastic->index()
               ->map([
                      'index' => 'my-index'
                 ]);

return $map;
