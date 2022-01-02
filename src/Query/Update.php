<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use ElasticSearch\Mappers\Mapper;

class Update extends Model
{
    private array $map = Mapper::UPDATE;

    /**
     * @param array $document
     * @return array
     */
    public function update(array $document) :array
    {
        $this->map['index'] = $document['index'];
        $this->map['id'] = $document['id'];
        unset($document['index'], $document['id']);
        
        $this->map['body']['doc'] = $document;

        return $this->updateDocument($this->map);
    }
}
