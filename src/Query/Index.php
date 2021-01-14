<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use ElasticSearch\Query\Mergeable\Mapping;
use ElasticSearch\Traits\ElasticQuery;
use Closure;

class Index extends Model
{
    use ElasticQuery;
    
    private array $map = [];
    
    /**
     * Set the index name
     *
     * @param  string $name
     * @return self
     */
    public function name(string $name) :self
    {
        $this->map['index'] = $name;

        return $this;
    }
    
    /**
     * Settings of index
     *
     * @param  array $settings
     * @return self
     */
    public function settings(array $settings) :self
    {
        $this->map['body']['settings'] = $settings;

        return $this;
    }
    
    /**
     * Mappings of index
     *
     * @param  Closure $mappings
     * @return void
     */
    public function mappings(Closure $mappings) :self
    {
        $mappings = $mappings->call(new Mapping);

        $this->map['body'] = $mappings['body'];
        
        return $this;
    }
    
    /**
     * Function will be created index
     *
     * @return Model createIndex
     */
    public function create() :array
    {
        return $this->createIndex($this->map);
    }
    
    /**
     * Deleting an index is very simple
     *
     * @return array
     */
    public function delete() :array
    {
        return $this->deleteIndex($this->map);
    }
    
    /**
     * Adds new fields to an existing data stream or index. 
     * You can also use the put mapping API to change the search settings of existing fields.
     *
     * @return array
     */
    public function updateMap() :array
    {
        $map['body'] = $this->map['body']['mappings'];
        $map['index'] = $this->map['index'];
        
        return $this->putMapping($map);
    }

    /**
     * The GET Mappings API returns the mapping details about your indices. 
     * Depending on the mappings that you wish to retrieve, you can specify one of more indices.
     *
     * @param  array $index
     * @return array
     */
    public function map(array $index) :array
    {
        return $this->getMapping($index);
    }
    
    /**
     * The GET Settings API shows you the currently configured settings for one or more indices.
     *
     * @param  array $index
     * @return array
     */
    public function getSettings(array $index) :array
    {
        return parent::getSettings($index);
    }
    
    /**
     * Checks if an index exists.
     *
     * @param  array $index
     * @return bool
     */
    public function exists(array $index) :bool
    {
        return parent::exists($index);
    }
}
