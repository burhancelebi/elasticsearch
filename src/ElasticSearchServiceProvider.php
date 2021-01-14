<?php

namespace ElasticSearch;

use Illuminate\Support\ServiceProvider;
use ElasticSearch\Query\Update;
use ElasticSearch\Query\Delete;
use ElasticSearch\Query\Mergeable\Suggest;
use ElasticSearch\Query\Mergeable\Sort;
use ElasticSearch\Query\Mergeable\Highlight;
use ElasticSearch\Query\GeoLocation\GeoShape;
use ElasticSearch\Query\GeoLocation\GeoPoint;
use ElasticSearch\Query\Aggregation;

class ElasticSearchServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('update', function ($app, $data){
            return (new Update())->update($data);
        });

        $this->app->singleton('delete', function ($app, $data){
            return (new Delete())->delete($data);
        });

        $this->app->singleton('suggest', function ($app){
            return new Suggest();
        });

        $this->app->singleton('elastic.sort', function ($app){
            return new Sort();
        });

        $this->app->singleton('elastic.highlight', function ($app){
            return new Highlight();
        });

        $this->app->singleton('elastic.aggs', function ($app){
            return new Aggregation();
        });

        $this->app->singleton('geo_shape', function ($app){
            return new GeoShape();
        });

        $this->app->singleton('geo_point', function ($app){
            return new GeoPoint();
        });
    }
}
