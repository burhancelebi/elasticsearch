<?php declare(strict_types=1);

namespace ElasticSearch\Query\Mergeable;

use ElasticSearch\Traits\ElasticQuery;
use ElasticSearch\Query\Model;

class SimplePhrase extends Model
{    
    use ElasticQuery;
    
    private array $map = [];
    
    /**
     * Set the field of phrase
     *
     * @param  string $field
     * @return self
     */
    public function field(string $field) :self
    {
        $this->map['body']['simple_phrase']['phrase']['field'] = $field;

        return $this;
    }
    
    /**
     * Set the data limit
     *
     * @param  int $size
     * @return self
     */
    public function size(int $size) :self
    {
        $this->map['body']['simple_phrase']['phrase']['size'] = $size;

        return $this;
    }
    
    /**
     * Currently only one type of candidate generator is supported, the direct_generator. 
     * The Phrase suggest API accepts a list of generators under the key direct_generator; 
     * each of the generators in the list is called per term in the original text.
     * 
     * The direct generators support the following parameters:
     * field, size, suggest_mode, max_edits, prefix_length, min_word_length,
     * max_term_freq, pre_filter, post_filter, max_inspections, min_doc_freq,
     *
     * @param  mixed $direct_generator
     * @return self
     */
    public function directGenerator(array $direct_generator) :self
    {
        $this->map['body']['simple_phrase']['phrase']['direct_generator'] = $direct_generator;

        return $this;
    }
    
    /**
     * Checks each suggestion against the specified query to prune suggestions 
     * for which no matching docs exist in the index. 
     *
     * @param  array $collate
     * @return self
     */
    public function collate(array $collate) :self
    {
        $this->map['body']['simple_phrase']['phrase']['collate'] = $collate;
        
        return $this;
    }
    
    /**
     * The phrase suggester supports multiple smoothing models to balance 
     * weight between infrequent grams (grams (shingles) are not existing in the index) and frequent grams 
     * (appear at least once in the index). 
     * The smoothing model can be selected by setting the smoothing parameter to one of the following options. 
     * Each smoothing model supports specific properties that can be configured.
     *
     * @param  array $smoothing
     * @return self
     */
    public function smoothing(array $smoothing) :self
    {
        $this->map['body']['simple_phrase']['phrase']['smoothing'] = $smoothing;
        
        return $this;
    }
    
    /**
     * Sets up suggestion highlighting. 
     * If not provided then no highlighted field is returned. 
     * If provided must contain exactly pre_tag and post_tag.
     *
     * @param  array $highlight
     * @return self
     */
    public function highlight(array $highlight) :self
    {
        $this->map['body']['simple_phrase']['highlight'] = $highlight;

        return $this;
    }
}
