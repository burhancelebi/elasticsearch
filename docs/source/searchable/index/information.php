<?php

$elastic = new ElasticSearch();

$result = $elastic->query()->getIndices(); // It returns all indices information

// You can get specific index information.

$result = $elastic->query(['pointsort,location'])->getIndices();

return $result;
