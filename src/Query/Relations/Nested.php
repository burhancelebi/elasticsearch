<?php

namespace ElasticSearch\Query\Relations;

use ElasticSearch\Query\Model;
use ElasticSearch\Mappers\Mapper;
use ElasticSearch\Traits\ElasticQuery;
use Closure;

class Nested extends Model
{
    use ElasticQuery;

    private array $map = [];

    public function index(string $name) 
    {
        $this->map['index'] = $name;

        return $this;
    }

    public function path(string $path) :self
    {
        $this->map['body']['query']['nested']['path'] = $path;

        return $this;
    }

    public function addQuery(string $class, Closure $callback) :self
    {
        $result = $callback->call(app($class));

        $this->map['body']['query']['nested'] += $result['body'];
    
        return $this;
    }

    public function params(string $name, $value) :self
    {
        $this->map['body'][$name] = $value;

        return $this;
    }
}
