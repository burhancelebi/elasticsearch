<?php

namespace ElasticSearch\Query\Relations;

use ElasticSearch\Query\Model;
use ElasticSearch\Traits\ElasticQuery;
use Closure;

class Nested extends Model
{
    use ElasticQuery;

    private array $map = [];

    /**
     * @param string $name
     * @return Nested
     */
    public function index(string $name): Nested
    {
        $this->map['index'] = $name;

        return $this;
    }

    /**
     * @param string $path
     * @return Nested
     */
    public function path(string $path) :Nested
    {
        $this->map['body']['query']['nested']['path'] = $path;

        return $this;
    }

    /**
     * @param string $class
     * @param Closure $callback
     * @return Nested
     */
    public function addQuery(string $class, Closure $callback) :Nested
    {
        $result = $callback->call(app($class));

        $this->map['body']['query']['nested'] += $result['body'];
    
        return $this;
    }

    /**
     * @param string $name
     * @param $value
     * @return Nested
     */
    public function params(string $name, $value) :Nested
    {
        $this->map['body'][$name] = $value;

        return $this;
    }
}
