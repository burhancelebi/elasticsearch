<?php declare(strict_types=1);

namespace ElasticSearch\Query\GeoLocation;

use ElasticSearch\Query\Model;
use ElasticSearch\Traits\ElasticQuery;

class GeoPoint extends Model
{
    use ElasticQuery;
    
    private array $map = [];

    private string $point_type = 'geo_bounding_box';
    
    /**
     * ElasticSearch geo location type
     *
     * @param string $point_type
     * @return self
     */
    public function pointType(string $point_type) :self
    {
        $this->point_type = $point_type;

        return $this;
    }
    
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
     * Determine the distance between two places
     *
     * @param string $distance
     * @return self
     */
    public function distance(string $distance) :self
    {
        $this->map['body']['query'][$this->point_type]['distance'] = $distance;

        return $this;
    }
    
    /**
     * You can use this method for custom location query
     *
     * @param array $location
     * @return self
     */
    public function location(array $location) :self
    {
        $this->map['body']['query'][$this->point_type] = $location;

        return $this;
    }
    
    /**
     * Enter latitude and longitude in the top left
     *
     * @param mixed $lat
     * @param mixed $lon
     * @return self
     */
    public function topLeft($lat, $lon) :self
    {
        $this->map['body']['query'][$this->point_type]['location']['top_left'] = [
            'lat' => $lat,
            'lon' => $lon
        ];

        return $this;
    }

    /**
     * Enter latitude and longitude in the bottom right
     *
     * @param mixed $lat
     * @param mixed $lon
     * @return self
     */
    public function bottomRight($lat, $lon) :self
    {
        $this->map['body']['query'][$this->point_type]['location']['bottom_right'] = [
            'lat' => $lat,
            'lon' => $lon
        ];

        return $this;
    }
}
