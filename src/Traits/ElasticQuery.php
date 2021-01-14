<?php

namespace ElasticSearch\Traits;

use Closure;

trait ElasticQuery
{    
    /**
     * Return the created map
     *
     * @return array
     */
    public function getMap() :array
    {
        return $this->map;
    }
    
    /**
     * Search in ElasticSearch
     *
     * @param  array|nullable $keys
     * @return array
     */
    public function search(array $keys = []) :array
    {
        $search = $this->getSearch($this->map);

        if ( $keys ) {
            $result = [];
            foreach ($keys as $key => $value) {
                $result[$value] = $search[$value];
            }

            $search = $result;
        }

        return $search;
    }
    
    /**
     * Merge query with a query in another class
     *
     * @param  mixed $class
     * @param  Closure $callback
     * @return self
     */
    public function mergeWith(string $class, Closure $callback) :self
    {
        $result = $callback->call(app($class));

        $this->map['body'] += $result['body'];
    
        return $this;
    }
}
