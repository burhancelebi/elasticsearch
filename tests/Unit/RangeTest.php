<?php declare(strict_types=1);

namespace ElasticSearch\Tests\Unit;

use ElasticSearch\Tests\TestCase;

final class RangeTest extends TestCase
{
    public function testCanDetermineRangeInSearch()
    {
        $range = $this->elastic->range()
                        ->index($this->getIndexName())
                        ->content([
                            'age' => [
                                'gte' => 21,
                                'lte' => 25
                            ]
                        ])
                        ->search();
                        
        $this->assertIsArray($range);
    }
}