<?php

$index = $elastic->index()
              ->name('my-index')
              ->settings([
                  'number_of_shards' => 3,
                  'number_of_replicas' => 2
              ])
              ->create();
