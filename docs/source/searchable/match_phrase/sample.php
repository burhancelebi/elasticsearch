<?php

$elastic = new ElasticSearch();

$phrase = $elastic->matchPhrase()
                ->index('my-index')
                ->field('name')
                ->text('I use Elastic Search')
                ->addition(['slop' => 1])
                ->search();

return $phrase;
