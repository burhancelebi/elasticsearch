<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use ElasticSearch\Mappers\Mapper;
use ElasticSearch\Traits\ElasticQuery;

class MultiMatch extends Model
{
    use ElasticQuery;
    
    private array $map = Mapper::MULTI_MATCH;

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
     * Set the data limit
     *
     * @param  int $size
     * @return self
     */
    public function size(int $size) :self
    {
        $this->map['body']['size'] = $size;

        return $this;
    }
    
    /**
     * Maximum edit distance allowed for matching.
     *
     * @param  int|nullable $fuzziness
     * @return self
     */
    public function fuzziness(int $fuzziness = 2) :self
    {
        $this->map['body']['query']['multi_match']['fuzziness'] = $fuzziness;

        return $this;
    }
        
    /**
     * The query string.
     *
     * @param  string $text
     * @return self
     */
    public function text(string $text) :self
    {
        $this->map['body']['query']['multi_match']['query'] = $text;

        return $this;
    }
    
    /**
     * The fields to be queried.
     *
     * @param  array $fields
     * @return self
     */
    public function fields(array $fields) :self
    {
        $this->map['body']['query']['multi_match']['fields'] = $fields;

        return $this;
    }
    
    /**
     * The way the multi_match query is executed internally depends on the type parameter, which can be set to:
     * best_fields, most_fields, cross_fields, phrase, phrase_prefix, bool_prefix
     *
     * @param  string $type
     * @return self
     */
    public function type(string $type) :self
    {
        $this->map['body']['query']['multi_match']['type'] = $type;

        return $this;
    }
    
    /**
     * The analyzer parameter specifies the analyzer used for text analysis when indexing or searching a text field.
     *
     * @param  string $analyzer
     * @return self
     */
    public function analyzer(string $analyzer) :self
    {
        $this->map['body']['query']['multi_match']['analyzer'] = $analyzer;

        return $this;
    }
    
    /**
     * By default, each per-term blended query will use the best score returned by any field in a group, 
     * then these scores are added together to give the final score. 
     * The tie_breaker parameter can change the default behaviour of the per-term blended queries. 
     * It accepts: 0.0, 1.0, 0.0 < n < 1.0
     *
     * @param  mixed $tie_breaker
     * @return self
     */
    public function tieBreaker($tie_breaker) :self
    {
        $this->map['body']['query']['multi_match']['tie_breaker'] = $tie_breaker;

        return $this;
    }
    
    /**
     * The operator flag can be set to or or and to control the boolean clauses (defaults to or).
     *
     * @param  string $operator
     * @return self
     */
    public function operator(string $operator) :self
    {
        $this->map['body']['query']['multi_match']['operator'] = $operator;

        return $this;
    }
}