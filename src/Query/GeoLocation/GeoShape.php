<?php declare(strict_types=1);

namespace ElasticSearch\Query\GeoLocation;

use ElasticSearch\Query\Model;
use ElasticSearch\Traits\ElasticQuery;

class GeoShape extends Model
{
    use ElasticQuery;
    
    private array $map = [];

    private string $shape = 'shape';
    
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
     * ElasticSearch geo shape field
     *
     * @param string|nullable $shape
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/shape.html#shape
     * @return self
     */
    public function shape(string $shape = null) :self
    {
        if ( is_null($shape) ) {
            
            $this->map[$this->shape]['location'] = [];
        }else {
            $this->shape = $shape;
        }

        return $this;
    }
    
    /**
     * Search for a text
     *
     * @param  mixed $text
     * @return self
     */
    public function text(string $text) :self
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['text'] = $text;

        return $this;
    }
    
    /**
     * Set the geo location type
     *
     * @param  mixed $type
     * @return self
     */
    public function type(string $type) :self
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['type'] = $type;

        return $this;
    }
        
    /**
     * Set the coordinates
     *
     * @param  array $coordinates
     * @return self
     */
    public function coordinates(array $coordinates) :self
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['coordinates'] = $coordinates;

        return $this;
    }
    
    /**
     * Set the geometries to use geometrycollection type
     *
     * @param  array $geometries
     * @return self
     */
    public function geometries(array $geometries) :self
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['geometries'] = $geometries;

        return $this;
    }
    
    /**
     * Radius default value is METERS.
     *
     * @param  string $radius
     * @return self
     */
    public function radius(string $radius) :self
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['radius'] = $radius;

        return $this;
    }
    
    /**
     * Optional. Vertex order for the shape’s coordinates list.
     *
     * @param  string $orientation
     * @return self
     */
    public function orientation(string $orientation) :self
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['orientation'] = $orientation;

        return $this;
    }
    
    /**
     * The geo_shape strategy mapping parameter determines which spatial relation operators may be used at search time.
     *
     * @param  string $relation
     * @return self
     */
    public function relation(string $relation) :self
    {
        $this->map['body']['query']['geo_shape']['relation'] = $relation;

        return $this;
    }
}
