<?php

$settings = $elastic->index()
                        ->getSettings([
                            'index' => 'my-index'
                        ]);

return $settings;
