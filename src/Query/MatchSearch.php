<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use ElasticSearch\Mappers\Mapper;
use ElasticSearch\Traits\ElasticQuery;

class MatchSearch extends Model
{
    use ElasticQuery;
    
    private array $map = Mapper::MATCH;

    /**
     * Search in index(s)
     *
     * @param string $index
     * @return self
     */
    public function index(string $index) :self
    {
        $this->map['index'] = $index;

        return $this;
    }
    
    /**
     * field
     *
     * @param  mixed $data
     * @return self
     */
    public function field(array $data) :self
    {        
        $this->map['body']['query']['match'] = $data;

        return $this;
    }
}