<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use ElasticSearch\Traits\ElasticQuery;

/**
 * Index a document to ElasticSearch
 */
class SaveDocument extends Model
{
    use ElasticQuery;
    
    private array $map = [
        'body'  => [],
    ];

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
     *
     * @param  string $name
     * @param  mixed $value
     * @return self
     */
    public function setParam(string $name, $value) :self
    {
        $this->map[$name] = $value;

        return $this;
    }
    
    /**
     * Set the document id
     *
     * @param  int $id
     * @return self
     */
    public function id(int $id = null) :self
    {
        $this->map['id'] = $id;

        return $this;
    }
    
    /**
     * Set the data to add an index.
     *
     * @param  array $body
     * @return self
     */
    public function body(array $body): self
    {
        $this->map['body'] = $body;
        
        return $this;
    }
    
    /**
     * Save the data
     *
     * @return array
     */
    public function save() :array
    {
        return $this->saveData($this->map);
    }
}
