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
     * @return MultiMatch
     */
    public function index(string $index) :MultiMatch
    {
        $this->map['index'] = $index;

        return $this;
    }
    
    /**
     * Set the data limit
     *
     * @param  int $size
     * @return MultiMatch
     */
    public function size(int $size) :MultiMatch
    {
        $this->map['body']['size'] = $size;

        return $this;
    }
    
    /**
     * Maximum edit distance allowed for matching.
     *
     * @param  int $fuzziness
     * @return MultiMatch
     */
    public function fuzziness(int $fuzziness = 2) :MultiMatch
    {
        $this->map['body']['query']['multi_match']['fuzziness'] = $fuzziness;

        return $this;
    }
        
    /**
     * The query string.
     *
     * @param  string $text
     * @return MultiMatch
     */
    public function text(string $text) :MultiMatch
    {
        $this->map['body']['query']['multi_match']['query'] = $text;

        return $this;
    }
    
    /**
     * The fields to be queried.
     *
     * @param  array $fields
     * @return MultiMatch
     */
    public function fields(array $fields) :MultiMatch
    {
        $this->map['body']['query']['multi_match']['fields'] = $fields;

        return $this;
    }
    
    /**
     * The way the multi_match query is executed internally depends on the type parameter, which can be set to:
     * best_fields, most_fields, cross_fields, phrase, phrase_prefix, bool_prefix
     *
     * @param  string $type
     * @return MultiMatch
     */
    public function type(string $type) :MultiMatch
    {
        $this->map['body']['query']['multi_match']['type'] = $type;

        return $this;
    }
    
    /**
     * The analyzer parameter specifies the analyzer used for text analysis when indexing or searching a text field.
     *
     * @param  string $analyzer
     * @return MultiMatch
     */
    public function analyzer(string $analyzer) :MultiMatch
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
     * @return MultiMatch
     */
    public function tieBreaker($tie_breaker) :MultiMatch
    {
        $this->map['body']['query']['multi_match']['tie_breaker'] = $tie_breaker;

        return $this;
    }
    
    /**
     * The operator flag can be set to or or and to control the boolean clauses (defaults to or).
     *
     * @param  string $operator
     * @return MultiMatch
     */
    public function operator(string $operator) :MultiMatch
    {
        $this->map['body']['query']['multi_match']['operator'] = $operator;

        return $this;
    }
}