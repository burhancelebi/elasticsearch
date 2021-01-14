<?php declare(strict_types=1);

namespace ElasticSearch\Query\Mergeable;

use ElasticSearch\Mappers\Mapper;
use ElasticSearch\Traits\ElasticQuery;
use ElasticSearch\Query\Model;

class Highlight extends Model
{
    use ElasticQuery;
    
    private string $name;
    
    private array $map = Mapper::HIGHLIGHT;
    
    /**
     * The maximum number of fragments to return. 
     * If the number of fragments is set to 0, no fragments are returned. 
     * Instead, the entire field contents are highlighted and returned
     *
     * @param  int $value
     * @return self
     */
    public function numberOfFragments(int $value) :self
    {
        $this->map['body']['highlight']['fields']['number_of_fragments'] = $value;

        return $this;
    }
    
    /**
     * The size of the highlighted fragment in characters. Defaults to 100.
     * You can set fragment_size to 0 to never split any sentence.
     *
     * @param  int $value
     * @return self
     */
    public function fragmentSize(int $value) :self
    {
        $this->map['body']['highlight']['fields']['fragment_size'] = $value;

        return $this;
    }
    
    /**
     * Set the fields of highlight
     *
     * @param  string $content
     * @param  string $pre_tags
     * @param  string $post_tags
     * @return self
     */
    public function content(string $content, string $pre_tags, string $post_tags) :self
    {
        $this->map['body']['highlight']['fields'][$content] = [
                                'pre_tags' => $pre_tags,
                                'post_tags' => $post_tags
                            ];

        return $this;
    }
}