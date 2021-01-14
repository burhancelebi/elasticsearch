<?php

namespace ElasticSearch;

use Elasticsearch\ClientBuilder;

abstract class Connection
{
    private $client;
    
    protected function client() :\Elasticsearch\Client
    {
        $this->client = ClientBuilder::create()->build();

        return $this->client;
    }
}