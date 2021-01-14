<?php declare(strict_types=1);

namespace ElasticSearch\Query\Mergeable;

use ElasticSearch\Traits\ElasticQuery;

class Mapping
{
    use ElasticQuery;
    
    private array $map = [];
    
    /**
     * Set suggest mapping to use in index
     *
     * @param  array $suggest
     * @return self
     */
    public function suggest(array $suggest) :self
    {
        $this->map['body']['mappings']['properties']['suggest'] = $suggest;

        return $this;
    }

    public function body(array $body) :self
    {
        $this->map['body']['mappings'] = $body;

        return $this;
    }
    
    /**
     * Set the property of mapping
     *
     * @param  string $name
     * @param  array $features
     * @return void
     */
    public function property(string $name, array $features) :self
    {
        $this->map['body']['mappings']['properties'][$name] = $features;

        return $this;
    }
}
