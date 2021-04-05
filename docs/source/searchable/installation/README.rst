Installation
========================

Download and Install lasticSearch
---------------------------------------
https://www.elastic.co/downloads/elasticsearch?latest

Install package via composer :
--------------------------------------------------

    composer require burhancelebi/elasticsearch

Lumen
-----------------------
Add provider to your bootstrap/app.php

    $app->register(ElasticSearch\\ElasticSearchServiceProvider::class);
    
Laravel
-----------------------
Add provider namespace to your config/app.php providers array

    ElasticSearch\\ElasticSearchServiceProvider::class,

