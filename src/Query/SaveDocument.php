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
     * @return SaveDocument
     */
    public function index(string $index) :SaveDocument
    {
        $this->map['index'] = $index;

        return $this;
    }
    
    /**
     *
     * @param  string $name
     * @param  mixed $value
     * @return SaveDocument
     */
    public function setParam(string $name, $value) :SaveDocument
    {
        $this->map[$name] = $value;

        return $this;
    }

    /**
     * Set the document id
     *
     * @param int|null $id
     * @return SaveDocument
     */
    public function id(int $id = null) :SaveDocument
    {
        $this->map['id'] = $id;

        return $this;
    }
    
    /**
     * Set the data to add an index.
     *
     * @param  array $body
     * @return SaveDocument
     */
    public function body(array $body): SaveDocument
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
