<?php

$suggest = $elastic->suggest()
            ->index('my-index')
            ->name('my-index-suggest')
            ->text('My name is ') // it returns "My name is Şêro"
            ->completion([
                'field' => 'suggest',
                'skip_duplicates' => true
            ])
            ->search();

return $suggest;
