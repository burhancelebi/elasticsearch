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
     * @return GeoShape
     */
    public function index(string $index) :GeoShape
    {
        $this->map['index'] = $index;

        return $this;
    }
    
    /**
     * ElasticSearch geo shape field
     *
     * @param string|null $shape
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/shape.html#shape
     * @return GeoShape
     */
    public function shape(?string $shape = null) :GeoShape
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
     * @return GeoShape
     */
    public function text(string $text) :GeoShape
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['text'] = $text;

        return $this;
    }
    
    /**
     * Set the geo location type
     *
     * @param  mixed $type
     * @return GeoShape
     */
    public function type(string $type) :GeoShape
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['type'] = $type;

        return $this;
    }
        
    /**
     * Set the coordinates
     *
     * @param  array $coordinates
     * @return GeoShape
     */
    public function coordinates(array $coordinates) :GeoShape
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['coordinates'] = $coordinates;

        return $this;
    }
    
    /**
     * Set the geometries to use geometrycollection type
     *
     * @param  array $geometries
     * @return GeoShape
     */
    public function geometries(array $geometries) :GeoShape
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['geometries'] = $geometries;

        return $this;
    }
    
    /**
     * Radius default value is METERS.
     *
     * @param  string $radius
     * @return GeoShape
     */
    public function radius(string $radius) :GeoShape
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['radius'] = $radius;

        return $this;
    }
    
    /**
     * Optional. Vertex order for the shape’s coordinates list.
     *
     * @param  string $orientation
     * @return GeoShape
     */
    public function orientation(string $orientation) :GeoShape
    {
        $this->map['body']['query']['geo_shape']['location'][$this->shape]['orientation'] = $orientation;

        return $this;
    }
    
    /**
     * The geo_shape strategy mapping parameter determines which spatial relation operators may be used at search time.
     *
     * @param  string $relation
     * @return GeoShape
     */
    public function relation(string $relation) :GeoShape
    {
        $this->map['body']['query']['geo_shape']['relation'] = $relation;

        return $this;
    }
}
