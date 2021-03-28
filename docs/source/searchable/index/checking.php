<?php

$exists = $elastic->index()
                    ->exists([
                        'index' => 'my-index'
                    ]);

    return $exists;
