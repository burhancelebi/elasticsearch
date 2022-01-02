<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use ElasticSearch\Mappers\Mapper;
use ElasticSearch\Traits\ElasticQuery;

class Range extends Model
{
    use ElasticQuery;
    
    private array $map = Mapper::RANGE;
    
    /**
     * Search in index(s)
     *
     * @param string $index
     * @return Range
     */
    public function index(string $index) :Range
    {
        $this->map['index'] = $index;

        return $this;
    }

    /**
     * @param array $content
     * @return $this
     */
    public function content(array $content) :Range
    {
        $this->map['body']['query']['range'] = $content;

        return $this;
    }
    
    /**
     * Set the data limit
     *
     * @param  mixed $size
     * @return Range
     */
    public function size(int $size) :Range
    {
        $this->map['body']['size'] = $size;

        return $this;
    }
}