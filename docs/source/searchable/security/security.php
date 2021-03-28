<?php

use ElasticSearch\ElasticSearch;

class ExampleController extends Controller
{
    private $elastic;

    public function __construct()
    {
        $this->elastic = new ElasticSearch();

        $hosts = [
            'http://localhost:9200'
        ];

        $this->elastic->client()
                    ->basicAuth('user', 'password')
                    ->hosts($hosts)
                    ->cloudId('cloud-id')
		    ->apiKey('enter-your-api-key')
	    	    ->sslVerification('path/to/cacert.pem');
    }

    public function multiMatch()
    {

        $search = $this->elastic->multiMatch()
                        ->index('my-index')
                        ->text('Şêro')
                        ->fuzziness(1)
                        ->fields(['text^3', 'name'])
                        ->search();

        return $search;
    }
}
