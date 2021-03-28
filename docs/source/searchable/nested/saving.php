<?php

$save = $this->elastic->document()
                ->index('my-index')
                ->body([
                    'group' => 'fans',
                    'user' => [
                        [
                            'first' => 'John',
                            'last'  => 'Smith'
                        ],
                        [
                            'first' => 'Alice',
                            'Last' => 'White'
                        ]
                    ]
                ])
                ->save();
