<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use ElasticSearch\Mappers\Mapper;
use ElasticSearch\Traits\ElasticQuery;

class MatchPhrase extends Model
{
    use ElasticQuery;
    
    private array $map = Mapper::MATCH_PHRASE;

    private string $field;
    
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
     * Determine which field will be searched
     *
     * @param  string $field
     * @return self
     */
    public function field(string $field) :self
    {
        $this->field = $field;

        return $this;
    }
    
    /**
     * Search a text in your query
     *
     * @param  string $text
     * @return self
     */
    public function text(string $text) :self
    {
        $this->map['body']['query']['match_phrase'][$this->field]['query'] = $text;

        return $this;
    }
    
    /**
     * Set the some features in your query.
     *
     * @param  mixed $addition
     * @return self
     */
    public function addition(array $addition) :self
    {
        $this->map['body']['query']['match_phrase'][$this->field] += $addition;

        return $this;
    }
}
