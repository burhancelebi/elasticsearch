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
     * @return MatchSearch
     */
    public function index(string $index) :MatchSearch
    {
        $this->map['index'] = $index;

        return $this;
    }
    
    /**
     * field
     *
     * @param  mixed $data
     * @return MatchSearch
     */
    public function field(array $data) :MatchSearch
    {        
        $this->map['body']['query']['match'] = $data;

        return $this;
    }
}