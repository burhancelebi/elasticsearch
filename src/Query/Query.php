<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use ElasticSearch\Traits\ElasticQuery;

class Query extends Model
{
    use ElasticQuery;
    
    private array $map = [];

    public function __construct(array $map)
    {
        $this->map = array_shift($map) ?: [];
    }

    public function __call($function, $arg)
    {
        if (method_exists(get_parent_class(), $function) ) {
            return $this->$function($this->map);
        }

        return parent::__call($function, $arg);
    }
}
