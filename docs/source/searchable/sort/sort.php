<?php

$sort = $elastic->sort()
                ->index('people')
                ->field('age')
                ->order('desc') // you can change to "asc"
                ->search();

return $sort;
