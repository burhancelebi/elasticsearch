<?php

namespace ElasticSearch\Query\Mergeable;

use Closure;
use ElasticSearch\Query\Model;
use ElasticSearch\Traits\ElasticQuery;

/**
 * Suggests similar looking terms based on a provided text by using a suggester. 
 * Parts of the suggest feature are still under development.
 */
class Suggest extends Model
{
    use ElasticQuery;
    
    private array $map = [];

    private string $name;
    
    /**
     * Set the id when adding a data
     *
     * @param  mixed $id
     * @return Suggest
     */
    public function id($id) :Suggest
    {
        $this->map['id'] = $id;

        return $this;
    }
    
    /**
     * Search in index(s)
     *
     * @param string $index
     * @return Suggest
     */
    public function index(string $index) :Suggest
    {
        $this->map['index'] = $index;

        return $this;
    }
    
    /**
     * Set the suggestion name
     *
     * @param  string $name
     * @return Suggest
     */
    public function name(string $name) :Suggest
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * Prefix used to search for suggestions
     *
     * @param  string $prefix
     * @return Suggest
     */
    public function prefix(string $prefix) :Suggest
    {
        $this->map['body']['suggest']['prefix'] = $prefix;

        return $this;
    }
    
    /**
     * The completion suggester provides auto-complete/search-as-you-type functionality. 
     * This is a navigational feature to guide users to relevant results as they are typing, 
     * improving search precision. 
     * It is not meant for spell correction or did-you-mean functionality like the term or phrase suggesters.
     *
     * @param  array $completion
     * @return Suggest
     */
    public function completion(array $completion) :Suggest
    {
        $this->map['body']['suggest'][$this->name]['completion'] = $completion;

        return $this;
    }
    
    /**
     * To achieve suggestion filtering and/or boosting, 
     * you can add context mappings while configuring a completion field. 
     * You can define multiple context mappings for a completion field.
     *
     * @param  array $contexts
     * @return Suggest
     */
    public function contexts(array $contexts) :Suggest
    {
        $this->map['body']['suggest']['contexts'] = $contexts;

        return $this;
    }
    
    /**
     * The completion suggester also supports regex queries meaning you can express a prefix as a regular expression.
     *
     * @param  string $regex
     * @return Suggest
     */
    public function regex(string $regex) :Suggest
    {
        $this->map['body']['suggest'][$this->name]['regex'] = $regex;

        return $this;
    }
    
    /**
     * An input is the expected text to be matched by a suggestion query
     *
     * @param  array $input
     * @return Suggest
     */
    public function input(array $input) :Suggest
    {
        $this->map['body']['suggest'] = $input;

        return $this;
    }
    
    /**
     * weight determines how the suggestions will be scored.
     *
     * @param  int $weight
     * @return Suggest
     */
    public function weight(int $weight) :Suggest
    {
        $this->map['body']['suggest']['weight'] = $weight;

        return $this;
    }
    
    /**
     * Enter the text to be searched.
     *
     * @param  string $text
     * @return Suggest
     */
    public function text(string $text) :Suggest
    {
        $this->map['body']['suggest'][$this->name]['text'] = $text;

        return $this;
    }
    
    /**
     * The suggest feature suggests similar looking terms based on a provided text by using a suggester.
     *
     * @param  array $term
     * @return Suggest
     */
    public function term(array $term) :Suggest
    {
        $this->map['body']['suggest'][$this->name]['term'] = $term;

        return $this;
    }
    
    /**
     * Add a new suggest. This function provides multiple suggestions to be used in a single query.
     *
     * @param  Closure $suggest
     * @return Suggest
     */
    public function addSuggest(Closure $suggest) :Suggest
    {
        $suggest = $suggest->call(new self)['body']['suggest'];
        
        $this->map['body']['suggest'] += $suggest;

        return $this;
    }
    
    /**
     * This function provides simple phrase to be used in suggestion.
     *
     * @param  Closure $phrase
     * @return Suggest
     */
    public function simplePhrase(Closure $phrase) :Suggest
    {
        $phrase = $phrase->call(new SimplePhrase)['body']['simple_phrase'];
        
        $this->map['body']['suggest']['simple_phrase'] = $phrase;

        return $this;
    }

    /**
     * Function will be saved suggestion data.
     *
     * @return array
     */
    public function save() :array
    {
        return $this->saveData($this->map);
    }
}
