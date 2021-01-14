<?php declare(strict_types=1);

use ElasticSearch\Tests\TestCase;

final class MatchTest extends TestCase
{
    public function testCanSearchUsingMatch()
    {
        $match = $this->elastic
                        ->match()
                        ->index($this->getIndexName())
                        ->field([
                            'name' => [
                                'query' => 'Şêro',
                                'fuzziness' => 1
                            ]
                        ])
                        ->search();

        $this->assertIsArray($match);
    }

    public function testCanSearchUsingMatchWithHighlight()
    {
        $match = $this->elastic
                        ->match()
                        ->index($this->getIndexName())
                        ->field([
                            'name' => [
                                'query' => 'Şêro',
                                'fuzziness' => 1
                            ]
                        ])
                        ->mergeWith('elastic.highlight', function(){
                            return $this
                                    ->content('name', '<div>', '</div>')
                                    ->getMap();
                        })
                        ->search(['hits']);

        $this->assertIsArray($match);
    }

    public function testCanSearchUsingMatchWithSort()
    {
        $match = $this->elastic
                        ->match()
                        ->index($this->getIndexName())
                        ->field([
                            'name' => [
                                'query' => 'Şêro',
                                'fuzziness' => 1
                            ]
                        ])
                        ->mergeWith('elastic.sort', function(){
                                return $this->field('age')
                                            ->order('desc')
                                            ->getMap();
                        })
                        ->search(['hits']);

        $this->assertIsArray($match);
    }
}