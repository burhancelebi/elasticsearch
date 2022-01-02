<?php declare(strict_types=1);

namespace ElasticSearch\Query;

class Delete extends Model
{
    private array $map = [];

    /**
     * Function provides to delete a document from ElasticSearch
     *
     * @param array $document
     * @return array
     */
    public function delete(array $document) :array
    {
        $this->map['index'] = $document['index'];
        $this->map['id'] = $document['id'];

        return $this->deleteDocument($this->map);
    }
}
