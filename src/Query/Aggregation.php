<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use ElasticSearch\Traits\ElasticQuery;
use Closure;

/**
 * 
 * An aggregation summarizes your data as metrics, statistics, or other analytics. 
 * Aggregations help you answer questions like:
 * 
 * What’s the average load time for my website?
 * Who are my most valuable customers based on transaction volume?
 * What would be considered a large file on my network?
 * How many products are in each product category?
 */
class Aggregation extends Model
{
    use ElasticQuery;

    private array $map = [];

    private string $aggs_name;
    
    /**
     * Set index to search in
     *
     * @param  mixed $index
     * @return Aggregation
     */
    public function index(string $index) :Aggregation
    {
        $this->map['index'] = $index;

        return $this;
    }    
    
    /**
     * Set a name to get results for the name aggregation that you set.
     *
     * @param  string $aggs_name
     * @return Aggregation
     */
    public function name(string $aggs_name) :Aggregation
    {
        $this->aggs_name = $aggs_name;

        return $this;
    }
    
    /**
     * Returns documents that contain an exact term in a provided field.
     *
     * @param  array $terms
     * @return Aggregation
     */
    public function terms(array $terms) :Aggregation
    {
        $this->map['body']['aggs'][$this->aggs_name]['terms'] = $terms;

        return $this;
    }
    
    /**
     * Set an aggregate query, just use this function
     *
     * @param  array $body
     * @return Aggregation
     */
    public function body(array $body) :Aggregation
    {
        $this->map['body']['aggs'] = $body;

        return $this;
    }
    
    /**
     * Use the meta object to associate custom metadata with an aggregation.
     *
     * @param  array $meta
     * @return Aggregation
     */
    public function meta(array $meta) :Aggregation
    {
        $this->map['body']['aggs'][$this->aggs_name]['meta'] = $meta;

        return $this;
    }
    
    /**
     * Set aggregation scope to calculate data or what you want 
     *
     * @param  array $scope
     * @return Aggregation
     */
    public function scope(array $scope) :Aggregation
    {
        $this->map['body']['aggs'][$this->aggs_name] = $scope;

        return $this;
    }
    
    /**
     * Bucket aggregations support bucket or metric sub-aggregations. 
     * For example, 
     * a terms aggregation with an avg sub-aggregation calculates an average value for each bucket of documents. 
     * There is no level or depth limit for nesting sub-aggregations.
     *
     * @param  Closure $sub_aggs
     * @return Aggregation
     */
    public function subAggs(Closure $sub_aggs) :Aggregation
    {
        $sub_aggs = $sub_aggs->call(new self);
        
        $this->map['body']['aggs'][$this->aggs_name] += $sub_aggs['body'];

        return $this;
    }
    
    /**
     * By default, searches containing an aggregation return both search hits and aggregation results.
     * To return only aggregation results, set size to 0
     *
     * @param  int $size
     * @return Aggregation
     */
    public function size(int $size) :Aggregation
    {
        $this->map['size'] = $size;

        return $this;
    }
    
    /**
     * Run multiple aggregations by adding new aggregation
     *
     * @param  Closure $aggs
     * @return Aggregation
     */
    public function addAggs(Closure $aggs) :Aggregation
    {
        $aggs = $aggs->call(new self)['body']['aggs'];
        
        $this->map['body']['aggs'] += $aggs;

        return $this;
    }
}