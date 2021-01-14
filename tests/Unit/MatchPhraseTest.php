<?php declare(strict_types=1);

use ElasticSearch\Tests\TestCase;

final class MatchPhraseTest extends TestCase
{
    public function testCanUseMatchPhraseWithoutSlop()
    {
        $search = $this->elastic
                        ->matchPhrase()
                        ->index($this->getIndexName())
                        ->field('name')
                        ->text('I use Elastic Search')
                        ->search(['hits']);

        $this->assertIsArray($search);
    }

    public function testCanUseMatchPhraseWithSlop()
    {
        $search = $this->elastic
                        ->matchPhrase()
                        ->index($this->getIndexName())
                        ->field('name')
                        ->text('Elastic really fast') // It returns "Elastic Search is really fast"
                        ->addition([
                            'slop' => 2
                        ])
                        ->search(['hits']);

        $this->assertIsArray($search);
    }
}