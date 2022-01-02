<?php declare(strict_types=1);

namespace ElasticSearch\Tests\Unit;

use ElasticSearch\Tests\TestCase;

final class BoolQueryTest extends TestCase
{
    public function testCanSearchUsingMust()
    {
        $bool = $this->elastic->bool()
                        ->index($this->getIndexName())
                        ->must([
                            ['term' => ['name.keyword' => 'Şêro']],
                        ])
                        ->search();

        $this->assertIsArray($bool);
    }

    public function testCanMergeWithHiglight()
    {
        $bool = $this->elastic->bool()
                        ->index($this->getIndexName())
                        ->must([
                            ['term' => ['name.keyword' => 'Şêro']],
                        ])
                        ->mergeWith('elastic.highlight', function(){
                            return $this
                                    ->content('name.keyword', '<div>', '</div>')
                                    ->getMap();
                        })
                        ->search();

        $this->assertIsArray($bool);
    }
}