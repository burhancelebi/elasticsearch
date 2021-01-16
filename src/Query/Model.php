<?php declare(strict_types=1);

namespace ElasticSearch\Query;

use ElasticSearch\Connection;

class Model extends Connection
{    
    /**
     * Function return search result
     *
     * @param  array $data
     * @return array
     */
    protected function getSearch(array $data) :array
    {
        return $this->client()->search($data);
    }
    
    /**
     * Function provides to index a document
     *
     * @param  array $data
     * @return array
     */
    protected function saveData(array $data) :array
    {
        return $this->client()->index($data);
    }
    
    /**
     * Function provide to create an index
     *
     * @param  array $data
     * @return array
     */
    protected function createIndex(array $data) :array
    {
        return $this->client()->indices()->create($data);
    }
    
    /**
     * The PUT Mappings API allows you to modify or add to an existing index’s mapping.
     *
     * @param  array $data
     * @return array
     */
    protected function putMapping(array $data) :array
    {
        return $this->client()->indices()->putMapping($data);
    }
    
    /**
     * Get mappings in index.
     *
     * @param  array $data
     * @return array
     */
    protected function getMapping(array $data) :array
    {
        return $this->client()->indices()->getMapping($data);
    }
    
    /**
     * Get settings of Index(s)
     *
     * @param  array $data
     * @return array
     */
    protected function getSettings(array $data) :array
    {
        return $this->client()->indices()->getSettings($data);
    }
    
    /**
     * Find a document with ID and Index
     *
     * @param  array $data
     * @return array
     */
    protected function getDocument(array $data) :array
    {
        return $this->client()->get($data);
    }
    
    /**
     * Delete a document with ID and Index 
     *
     * @param  array $data
     * @return array
     */
    protected function deleteDocument(array $data) :array
    {
        return $this->client()->delete($data);
    }
    
    /**
     * Update a document with ID and Index 
     *
     * @param  array $data
     * @return array
     */
    protected function updateDocument(array $data) :array
    {
        return $this->client()->update($data);
    }
    
    /**
     * Deleting an index is very simple:
     *
     * @param  array $data
     * @return array
     */
    protected function deleteIndex(array $data) :array
    {
        return $this->client()->indices()->delete($data);
    }
    
    /**
     * Checks if index exists.
     *
     * @param  array $index
     * @return bool
     */
    protected function exists(array $data) :bool
    {
        return $this->client()->indices()->exists($data);
    }
    
    /**
     * Get all indices or specific index
     *
     * @param  mixed $indices
     * @return array
     */
    protected function getIndices($indices = '*') :array
    {
        return $this->client()->cat()->indices(['index' => $indices]);
    }
}
