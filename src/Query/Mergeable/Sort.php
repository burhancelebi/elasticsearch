<?php declare(strict_types=1);

namespace ElasticSearch\Query\Mergeable;

use ElasticSearch\Mappers\Mapper;
use ElasticSearch\Traits\ElasticQuery;
use ElasticSearch\Query\Model;

class Sort extends Model
{
    use ElasticQuery;
    
    private string $name;
    
    private array $map = Mapper::SORT;

    public function index(string $index)
    {
        $this->map['index'] = $index;

        return $this;
    }
    
    /**
     * Set the sort by field. Example: id, age
     *
     * @param  string $field
     * @return self
     */
    public function field(string $field) :self
    {
        $this->field = $field;
        
        $this->map['body']['sort'][$this->field] = [];

        return $this;
    }
    
    /**
     * Determine order. Example: dest, asc
     *
     * @param  string $order
     * @return self
     */
    public function order(string $order) :self
    {
        $this->map['body']['sort'][$this->field]['order'] = $order;

        return $this;
    }
}