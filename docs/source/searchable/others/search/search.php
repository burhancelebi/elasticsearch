<?php

$sort = $elastic->sort()
            ->index('people')
            ->field('age')
            ->order('desc') // you can change to "asc"
            ->search(['hits', 'took']); // spesific parameters

// You will get hits and took fields

return $sort;
