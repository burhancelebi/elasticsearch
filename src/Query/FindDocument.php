<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use Elasticsearch\Common\Exceptions\Missing404Exception;
use ElasticSearch\Exceptions\DocumentNotFound;

class FindDocument extends Model
{
    private array $map = [];
    
    public function __construct($arg)
    {
        $this->map['index'] = $arg[0];
        $this->map['id'] = $arg[1];
    }

    /**
     * Return document from ElasticSearch
     *
     * @return array getDocument
     * @throws DocumentNotFound
     */
    public function get() :array
    {
        try {
            return $this->getDocument($this->map);
        } catch (Missing404Exception $e) {
            throw new DocumentNotFound("Document Not Found \n" . $e->getMessage());
        }
    }

    /**
     * Function can delete and update document that searched data
     *
     * @param callable $function
     * @param mixed $arg
     * @return array ($function);
     */
    public function __call($function, $arg) :array
    {
        $data = array_merge(array_shift($arg) ?: [], $this->map);
        
        return app($function, $data);
    }
}
