<?php declare(strict_types=1);

namespace ElasticSearch\Query\Mergeable;

use ElasticSearch\Mappers\Mapper;
use ElasticSearch\Traits\ElasticQuery;
use ElasticSearch\Query\Model;

class Sort extends Model
{
    use ElasticQuery;
    
    private string $name;

    private string $field;

    private array $map = Mapper::SORT;

    public function index(string $index): Sort
    {
        $this->map['index'] = $index;

        return $this;
    }
    
    /**
     * Set the sort by field. Example: id, age
     *
     * @param  string $field
     * @return Sort
     */
    public function field(string $field) :Sort
    {
        $this->field = $field;
        
        $this->map['body']['sort'][$this->field] = [];

        return $this;
    }
    
    /**
     * Determine order. Example: dest, asc
     *
     * @param  string $order
     * @return Sort
     */
    public function order(string $order) :Sort
    {
        $this->map['body']['sort'][$this->field]['order'] = $order;

        return $this;
    }
}