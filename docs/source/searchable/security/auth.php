<?php

use ElasticSearch\ElasticSearch;

class ExampleController extends Controller
{
    private $elastic;

    public function __construct()
    {
        $this->elastic = new ElasticSearch();

        $this->elastic->client()
                    ->basicAuth('user', 'password');
    }

    public function nested()
    {
        $nested = $this->elastic
                    ->nested()
                    ->index('my-index')
                    ->path('user')
                    ->params('size', 1)
                    ->addQuery('elastic.bool', function() {
                        return $this
                                ->must([
                                    [
                                        'match' => ['user.first' => 'Şero']
                                    ]
                                ])
                                ->getMap();
                    })
                    ->search();

        return $nested;
    }
}
