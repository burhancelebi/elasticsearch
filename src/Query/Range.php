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
     * @return self
     */
    public function index(string $index) :self
    {
        $this->map['index'] = $index;

        return $this;
    }

    public function content(array $content) :self
    {
        $this->map['body']['query']['range'] = $content;

        return $this;
    }
    
    /**
     * Set the data limit
     *
     * @param  mixed $size
     * @return self
     */
    public function size(int $size) :self
    {
        $this->map['body']['size'] = $size;

        return $this;
    }
}