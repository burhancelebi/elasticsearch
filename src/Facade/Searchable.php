<?php declare(strict_types=1);

namespace ElasticSearch\Facade;

use ElasticSearch\Query\SaveDocument;
use ElasticSearch\Query\MultiMatch;
use ElasticSearch\Query\MatchSearch;
use ElasticSearch\Query\FindDocument;
use ElasticSearch\Query\BoolQuery;
use ElasticSearch\Query\Query;
use ElasticSearch\Query\Mergeable\Sort;
use ElasticSearch\Query\Range;
use ElasticSearch\Query\Index;
use ElasticSearch\Query\MatchPhrase;
use ElasticSearch\Query\Aggregation;
use ElasticSearch\Query\Mergeable\Suggest;
use ElasticSearch\Query\GeoLocation\GeoShape;
use ElasticSearch\Query\GeoLocation\GeoPoint;
use ElasticSearch\Authentication\Connection;
use ElasticSearch\Query\Relations\Nested;

class Searchable
{
    public function client() :Connection
    {
        return new Connection();
    }
    
    /**
     * The nested type is a specialised version of the object data type that allows arrays of objects to be 
     * indexed in a way that they can be queried independently of each other.
     *
     * @return Nested
     */
    public function nested() :Nested
    {
        return new Nested();
    }

    /**
     * Allows you to add one or more sorts on specific fields. 
     * Each sort can be reversed as well. The sort is defined on a per field level, 
     * with special field name for _score to sort by score, and _doc to sort by index order.
     *
     * @return Sort
     */
    public function sort() :Sort
    {
        return new Sort();
    }

    /**
     * You can write all queries to this function
     *
     * @param  array $query
     * @return Query
     */
    public function query(array $query) :Query
    {
        return new Query($query);
    }
    
    /**
     * An aggregation summarizes your data as metrics, statistics, or other analytics.
     *
     * @return Aggregation
     */
    public function aggs() :Aggregation
    {
        return new Aggregation();
    }
    
    /**
     * The geo_shape data type facilitates the indexing of and searching 
     * with arbitrary geo shapes such as rectangles and polygons. 
     * It should be used when either the data being indexed or the queries being executed
     * contain shapes other than just points.
     *
     * @return GeoShape
     */
    public function geoShape() :GeoShape
    {
        return new GeoShape();
    }
    
    /**
     * Geohashes are base32 encoded strings of the bits of the latitude and longitude interleaved.
     * Each character in a geohash adds additional 5 bits to the precision. 
     * So the longer the hash, the more precise it is.
     *
     * @return GeoPoint
     */
    public function geoPoint() :GeoPoint
    {
        return new GeoPoint();
    }
    
    /**
     * The multi_match query builds on the match query to allow multi-field queries:
     *
     * @return MultiMatch
     */
    public function multiMatch() :MultiMatch
    {
        return new MultiMatch();
    }
    
    /**
     * A query that matches documents matching boolean combinations of other queries. 
     * The bool query maps to Lucene BooleanQuery. 
     * It is built using one or more boolean clauses, each clause with a typed occurrence.
     *
     * @return BoolQuery
     */
    public function bool() :BoolQuery
    {
        return new BoolQuery();
    }
        
    /**
     * Returns documents that contain terms within a provided range.
     *
     * @return Range
     */
    public function range() :Range
    {
        return new Range();
    }
    
    /**
     * Elasticsearch provides realtime GETs of documents. 
     * This means that as soon as the document is indexed and your client receives an acknowledgement, 
     * you can immediately retrieve the document from any shard. 
     * Get operations are performed by requesting a document by its full index/type/id path:
     *
     * @param  mixed $arg
     * @return FindDocument
     */
    public function find($arg) :FindDocument
    {
        return new FindDocument($arg);
    }
    
    /**
     * When indexing a document, you can either provide an ID or let Elasticsearch generate one for you.
     *
     * @return SaveDocument
     */
    public function document() :SaveDocument
    {
        return new SaveDocument();
    }
    
    /**
     * Adds a JSON document to the specified data stream or index and makes it searchable. 
     * If the target is an index and the document already exists, 
     * the request updates the document and increments its version.
     *
     * @return Index
     */
    public function index() :Index
    {
        return new Index();
    }
    
    /**
     * The match query is the standard query for performing a full-text search, including options for fuzzy matching.
     *
     * @return MatchSearch
     */
    public function match() :MatchSearch
    {
        return new MatchSearch();
    }
    
    /**
     * The match_phrase query analyzes the text and creates a phrase query out of the analyzed text.
     *
     * @return MatchPhrase
     */
    public function matchPhrase() :MatchPhrase
    {
        return new MatchPhrase();
    }
    
    /**
     * Suggests similar looking terms based on a provided text by using a suggester.
     *
     * @return Suggest
     */
    public function suggest() :Suggest
    {
        return new Suggest();
    }
}