<?php declare(strict_types=1);

namespace ElasticSearch\Tests\Unit;

use ElasticSearch\Tests\TestCase;

final class AggregationTest extends TestCase
{
    public function testCanSearchUsingAggregation()
    {
        $aggs = $this->elastic
                        ->aggs()
                        ->index($this->getIndexName())
                        ->name('my-avg-aggs')
                        ->scope([
                            'avg' => [
                                'field' => 'age'
                            ]
                        ])
                        ->search();

        $this->assertIsArray($aggs);
    }

    public function testIfSizeIsUsedAsZeroHitsDoesntHaveValue()
    {
        $aggs = $this->elastic
                        ->aggs()
                        ->size(0)
                        ->index($this->getIndexName())
                        ->name('my-avg-aggs')
                        ->scope([
                            'avg' => [
                                'field' => 'age'
                            ]
                        ])
                        ->search(['hits']);

        $this->assertIsArray($aggs);
        $this->assertSame(0, count($aggs['hits']['hits']));
    }

    public function testCanBeUsedMultipleAggregation()
    {
        $aggs = $this->elastic
                        ->aggs()
                        ->size(0)
                        ->index($this->getIndexName())
                        ->name('my-avg-aggs')
                        ->scope([
                            'avg' => [
                                'field' => 'age'
                            ]
                        ])
                        ->addAggs(function(){
                            return $this
                                ->name('avg-aggs-2')
                                ->size(0)
                                ->terms([
                                    'field' => 'age',
                                ])->getMap();
                        })
                        ->addAggs(function(){
                            return $this
                                ->name('avg-aggs-3')
                                ->size(0)
                                ->terms([
                                    'field' => 'age',
                                ])->getMap();
                        })
                        ->getMap();

        $this->assertIsArray($aggs);
        $this->assertArrayHasKey('avg-aggs-2', $aggs['body']['aggs']);
        $this->assertArrayHasKey('avg-aggs-3', $aggs['body']['aggs']);
    }

    public function testCanAddSubAggregation()
    {
        $aggs = $this->elastic
                        ->aggs()
                        ->size(0)
                        ->index($this->getIndexName())
                        ->name('my-avg-aggs')
                        ->terms([
                            'field' => 'age',
                        ])
                        ->subAggs(function(){
                            return $this
                                    ->name('sub-aggs')
                                    ->scope([
                                        'avg' => [
                                            'field' => 'age'
                                        ]
                                    ])->getMap();
                        })
                        ->getMap();

        $this->assertIsArray($aggs);
        $this->assertArrayHasKey('sub-aggs', $aggs['body']['aggs']['my-avg-aggs']['aggs']);
    }

    public function testCanSearchUsingTermsINAggregation()
    {
        $aggs = $this->elastic
                        ->aggs()
                        ->index($this->getIndexName())
                        ->name('my-avg-aggs')
                        ->terms([
                            'field' => 'age',
                        ])
                        ->scope([
                            'avg' => [
                                'field' => 'age'
                            ]
                        ])
                        ->search();

        $this->assertIsArray($aggs);
    }
}