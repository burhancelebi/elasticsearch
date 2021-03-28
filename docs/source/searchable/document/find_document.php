<?php

$elastic = new ElasticSearch();

$find = $elastic->find('my-index', 'enter-id')->get();

return $find;
