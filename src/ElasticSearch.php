<?php declare(strict_types=1);

namespace ElasticSearch;

use ElasticSearch\Facade\Searchable;

class ElasticSearch
{
    private $elastic = Searchable::class;

    public function __construct(object $elastic = null)
    {
        if ( !is_null($elastic) ) {
            
            $this->elastic = $elastic;
        }
    }

    public function __call($function, $arg): object
    {
        return (new $this->elastic)->$function($arg);
    }
}