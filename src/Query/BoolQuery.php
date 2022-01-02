<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use ElasticSearch\Mappers\Mapper;
use ElasticSearch\Traits\ElasticQuery;
use Closure;

/**
 * A query that matches documents matching boolean combinations of other queries. 
 * The bool query maps to Lucene BooleanQuery. 
 * It is built using one or more boolean clauses, each clause with a typed occurrence. 
 */
class BoolQuery extends Model
{
    use ElasticQuery;
    
    private array $map = Mapper::BOOL_QUERY;

    /**
     * Search in index(s)
     *
     * @param string $index
     * @return BoolQuery
     */
    public function index(string $index) :BoolQuery
    {
        $this->map['index'] = $index;

        return $this;
    }
    
    /**
     * The clause (query) must appear in matching documents and will contribute to the score.
     *
     * @param  array $content
     * @return BoolQuery
     */
    public function must(array $content) :BoolQuery
    {
        $this->map['body']['query']['bool']['must'] = $content;

        return $this;
    }
    
    /**
     * The clause (query) must appear in matching documents. 
     * However unlike must the score of the query will be ignored. 
     * Filter clauses are executed in filter context, meaning that scoring is ignored 
     * and clauses are considered for caching.
     *
     * @param  array $filter
     * @return BoolQuery
     */
    public function filter(array $filter) :BoolQuery
    {
        $this->map['body']['query']['bool']['filter'] = $filter;

        return $this;
    }
    
    /**
     * The clause (query) must not appear in the matching documents. 
     * Clauses are executed in filter context meaning that scoring is ignored and clauses are considered for caching. 
     * Because scoring is ignored, a score of 0 for all documents is returned.
     *
     * @param  array $content
     * @return BoolQuery
     */
    public function mustNot(array $content) :BoolQuery
    {
        $this->map['body']['query']['bool']['must_not'] = $content;

        return $this;
    }
    
    /**
     * The clause (query) should appear in the matching document.
     *
     * @param  array $content
     * @return BoolQuery
     */
    public function should(array $content) :BoolQuery
    {
        $this->map['body']['query']['bool']['should'] = $content;

        return $this;
    }
    
    /**
     * You can use the minimum_should_match parameter to specify the number or percentage of should 
     * clauses returned documents must match.
     *
     * @param  int $minimum_should_match
     * @return BoolQuery
     */
    public function minimum_should_match(int $minimum_should_match) :BoolQuery
    {
        $this->map['body']['query']['bool']['minimum_should_match'] = $minimum_should_match;

        return $this;
    }
    
    /**
     * Individual fields can be boosted automatically — count more towards the relevance score — at query time,
     *
     * @param  int $boost
     * @return BoolQuery
     */
    public function boost(int $boost) :BoolQuery
    {
        $this->map['body']['query']['bool']['boost'] = $boost;

        return $this;
    }
    
    /**
     * Add geo filter to Boolean query
     *
     * @param  string $filter
     * @param  Closure $geoFilter
     * @return BoolQuery
     */
    public function addGeoFilter(string $filter, Closure $geoFilter) :BoolQuery
    {
        $filter = $geoFilter->call(app($filter))['body']['query'];
        
        if ( isset($this->map['body']['query']['bool']['filter']) ) {
            
            $this->map['body']['query']['bool']['filter'] += $filter;
        }else {
            
            $this->map['body']['query']['bool'] += ['filter' => $filter];
        }

        return $this;
    }
}