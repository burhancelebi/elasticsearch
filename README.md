Installation
-----------------
[Download ElasticSearch](https://www.elastic.co/downloads/elasticsearch?latest)

Install package via composer : 

    composer require burhancelebi/elasticsearch

Lumen
============
Add provider to your bootstrap/app.php

    $app->register(ElasticSearch\ElasticSearchServiceProvider::class);
    
Laravel
===========
Add to your config/app.php providers array

    ElasticSearch\ElasticSearchServiceProvider::class,
    
Queries
-----------------------
* [Index](#index)
* [Sort](#sort)
* [Multi Match](#multi-match)
* [Document](#document)
* [Aggregation](#aggregation)
* [Boolean Query](#boolean-query)
* [Geo Shape](#geo-shape)
* [Geo Point](#geo-point)
* [Match](#match)
* [Range](#range)
* [Match Phrase](#match-phrase)
* [Suggest](#suggest)
* [Query](#query)

Index
===============

Adds a JSON document to the specified data stream or index and makes it searchable.

Add this namespace to your class.

    use ElasticSearch\ElasticSearch;

**Index Information**

    $elastic = new ElasticSearch();

    $result = $elastic->query()->getIndices(); // It returns all indices information
    
    // You can get specific index information.
    
    $result = $elastic->query(['pointsort,location'])->getIndices();
    
    return $result;
    

**Create Index**
    
    $elastic = new ElasticSearch();
    $index = $elastic->index()
                    ->name('my-index')
                    ->create();

    return $index;
    
You can use settings or mappings function when creating a index

**Settings**

    $index = $elastic->index()
                ->name('my-index')
                ->settings([
                    'number_of_shards' => 3, 
                    'number_of_replicas' => 2
                ])
                ->create();
                        
**Mappings**

    $index = $elastic->index()
                ->name('my-index')
                ->mappings(function(){ // Closure $mappings
                    return $this->suggest([
                                'type' => 'completion',
                            ])
                            ->property('title', [
                                'type' => 'text'
                            ])
                            ->getMap();
                })
                ->create();

    return $index;
    
**Check if an index exists**

    $exists = $elastic->index()
                    ->exists([
                        'index' => 'my-index'
                    ]);

    return $exists;
    
**Get index settings**

    $settings = $elastic->index()
                        ->getSettings([
                            'index' => 'my-index'
                        ]);

    return $settings;
    
**Get index mappings**

    $map = $elastic->index()
                    ->map([
                        'index' => 'my-index'
                    ]);

    return $map;
    
**Update index mappings**

    $index = $elastic->index()
                    ->name('my-index')
                    ->mappings(function(){
                            return $this
                                    ->body([
                                        'properties' => [
                                            'location.keyword' => [
                                                'type' => 'geo_shape',
                                            ]
                                        ]
                                    ])
                                    ->getMap();
                    })
                    ->updateMap();
                    
    return $index;
    
:information_source: getMap() function
-----
> Before using the creating, searching, updating etc. functions, you can display the ElasticSearch map.

For example:

    $map = $elastic->index()
                    ->name('my-index')
                    ->mappings(function(){
                            return $this
                                    ->body([
                                        'properties' => [
                                            'location.keyword' => [
                                                'type' => 'geo_shape',
                                            ]
                                        ]
                                    ])
                                    ->getMap();
                    })
                    ->getMap(); // it returns map
                    
    return $map;
    
    // You will get something like that:
    /* {"index":"my-index","body":{"mappings":{"properties":{"location.keyword":{"ty pe":"geo_shape"}}}}} */
    
Sort
==============

Sort people by age

    $sort = $elastic->sort()
                    ->index('people')
                    ->field('age')
                    ->order('desc') // you can change to "asc"
                    ->search();

    return $sort;
    
:information_source: search() function
-----
> This function will trigger ElasticSearch search function, if you add a parameter as array, you will get just those fields

For example:

    ...
    $sort = $elastic->sort()
                ->index('people')
                ->field('age')
                ->order('desc') // you can change to "asc"
                ->search(['hits', 'took']);
                    
    // You will get hits and took fields

    return $sort;
    
Multi Match
=======

The multi_match query builds on the match query to allow multi-field queries:

    $search = $elastic->multiMatch()
                    ->index('my-index')
                    ->text('Şêro')
                    ->fields(['name^3'])
                    ->search();
                    
    // If you want to set limit : 
    $search = $elastic->multiMatch()
                    ->index('my-index')
                    ->size(10) // returns max 10 data
                    ->text('Şêro')
                    ->fields(['name^3'])
                    ->search();
                    
    //  add fuzziness : 
    $search = $elastic->multiMatch()
                    ->index('my-index')
                    ->size(10)
                    ->fuzziness(1) // Ideal value is 1 and 2
                    ->text('Şêro')
                    ->fields(['name^3'])
                    ->search();
                    
    // Merge with sort query :
    $search = $elastic->multiMatch()
                    ->index('my-index')
                    ->size(10)
                    ->fuzziness(1)
                    ->text('Şêro')
                    ->fields(['name^3'])
                    ->mergeWith('elastic.sort', function(){
                            return $this
                                    ->field('age')
                                    ->order('desc')
                                    ->getMap();
                        })
                    ->search();
                    
    // Merge with aggregations
            
    $search = $elastic->multiMatch()
                    ->index('my-index')
                    ->text('Şêro')
                    ->fuzziness(1)
                    ->fields(['name^3'])
                    ->mergeWith('elastic.aggs', function(){
                      return $this
                                ->name('my-aggs')
                                ->terms([
                                        'field' => 'age'
                                ])
                                ->subAggs(function(){
                                    return $this
                                        ->name('sub-aggs')
                                        ->scope([
                                            'avg' => [
                                                'field' => 'age'
                                            ]
                                        ])
                                        ->getMap();
                                })
                                ->getMap();  
                    })
                    ->search();
                    
    // Merge with highlight query :
    $search = $elastic->multiMatch()
                    ->index('my-index')
                    ->size(10)
                    ->fuzziness(1)
                    ->text('Şêro')
                    ->fields(['name^3'])
                    ->mergeWith('elastic.sort', function(){
                            return $this
                                    ->field('age')
                                    ->order('desc')
                                    ->getMap();
                    })
                    ->mergeWith('elastic.highlight', function(){
                                return $this
                                    ->content('name', '<div>', '</div>')
                                    ->getMap();
                    })
                    ->search();
                    
    // Other useful functions
    $search = $elastic->multiMatch()
                ->index('my-index')
                ->size(10)
                ->fuzziness(1)
                ->text('Şêro')
                ->fields(['name^3'])
                ->analyzer('standard')
                ->tieBreaker(0.3)
                ->operator('and')
                ->type('most_fields')
                ->search();
                
Document
==============

**Add a document to ElasticSearch**

    $elastic = new ElasticSearch();

    $index = $elastic->document()
                    ->index('my-index')
                    ->body([
                        'text' => 'What is your name',
                        'location' => [
                            'type' => 'point',
                            'coordinates' => [50.30, 20.34],
                        ]
                    ])
                    ->save();

    // You can merge with suggest
    $index = $elastic->document()
                    ->index('my-index')
                    ->body([
                        'text' => 'My name is Şêro',
                        'location' => [
                            'type' => 'point',
                            'coordinates' => [50.30, 20.34],
                        ]
                    ])
                    ->mergeWith('suggest', function(){
                            return $this
                                    ->input([
                                        [
                                            'input' => 'Music Time',
                                            'weight' => 20
                                        ]
                                    ])
                                    ->getMap();
                        })
                    ->save();

**Find a Document**

        $elastic = new ElasticSearch();

        $find = $elastic->find('my-index', 'enter-id')->get();

        return $find;
        
**Update a Document**

    $elastic = new ElasticSearch();

    $update = $elastic->find('my-index', 'Lpkpd53YBR6XiqYGx3M98')->update([
        'name' => 'Şêro'
    ]);

    return $update;
    
**Delete a Document**

    $elastic = new ElasticSearch();

    $delete = $elastic->find('my-index', 'Lpkpd53YBR6XiqYGx3M98')->delete();

    return $delete;
    
Aggregation
==========

>An aggregation summarizes your data as metrics, statistics, or other analytics. Aggregations help you answer questions like:

- What’s the average load time for my website?
- Who are my most valuable customers based on transaction volume?
- What would be considered a large file on my network?
- How many products are in each product category?

A sample search

    $elastic = new ElasticSearch();

    $aggs = $elastic->aggs()
                ->index('my-index')
                ->name('my-aggs')
                ->scope([
                    'avg' => [
                        'field' => 'age'
                    ]
                ])
                ->search();
                
    return $aggs;

**Terms Aggregation**

    $elastic = new ElasticSearch();

    $aggs = $elastic->aggs()
                ->index('my-index')
                ->name('my-aggs')
                ->terms([
                    'field' => 'age',
                ])
                ->getMap();

    return $aggs;
    
**Add custom metadata**

    $elastic = new ElasticSearch();

    $aggs = $elastic->aggs()
                ->index('my-index')
                ->name('my-aggs')
                ->terms([
                    'field' => 'age',
                ])
                ->meta([
                    "my-metadata-field" => "foo"
                ])
                ->search();

    return $aggs;
    
**Return only aggregation results**

By default, searches containing an aggregation return both search hits and aggregation results. To return only aggregation results, set size to 0.
    
    $elastic = new ElasticSearch();
    
    $aggs = $elastic->aggs()
                ->index('my-index')
                ->name('my-avg-aggs')
                ->size(0) // default 1
                ->scope([
                    'avg' => [
                        'field' => 'age'
                    ]
                ])
                ->search();
                
**Run multiple aggregations**

You can use multiple aggregations in the same request.

    $elastic = new ElasticSearch();

    $aggs = $elastic->aggs()
            ->index('my-index')
            ->name('my-aggs')
            ->scope([
                'avg' => [
                    'field' => 'age'
                ]
            ])
            ->addAggs(function(){
                return $this
                    ->name('my-aggs-2')
                    ->size(0)
                    ->scope([
                        'avg' => [
                            'field' => 'age'
                        ]
                    ])->getMap();
            })
            ->addAggs(function(){
                ...
            })
            ->search();

    return $aggs;
    
**Run sub-aggregations**

Bucket aggregations support bucket or metric sub-aggregations. There is no level or depth limit for nesting sub-aggregations.

    $elastic = new ElasticSearch();

    $aggs = $elastic->aggs()
            ->index('my-index')
            ->name('my-aggs')
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
                    ])
                    ->getMap();
            })
            // you can add multiple sub-aggregations
            ->subAggs(function(){
                ...
            })
            ->search();
            
    // Or you can use like that: 
    
    $aggs = $elastic->aggs()
                    ->index('my-index')
                    ->name('my-avg-aggs')
                    ->terms([
                        'field' => 'age',
                    ])
                    ->addAggs(function(){
                        return $this
                            ->name('my-avg-aggs-2')
                            ->size(0)
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
                                    ])
                                    ->getMap();
                            })
                            ->getMap();
                    })
                    ->getMap();

    return $aggs;
    
If you can't find what you want you can use **body** function

    $aggs = $elastic->aggs()
                ->index('my-index')
                ->body([
                    'my-aggs' => [
                        'avg' => [
                            'field' => 'age'
                        ]
                    ]
                ])
                ->search();
        
    return $aggs;
    
Boolean Query
==============

>A query that matches documents matching boolean combinations of other queries. The bool query maps to Lucene BooleanQuery. It is built using one or more boolean clauses, each clause with a typed occurrence. 

    $elastic = new ElasticSearch();
    
    // Search using must
    $search = $elastic->bool()
                    ->index('my_index')
                    ->must([
                        ['term' => ['name.keyword' => 'Şêro']]
                    ])
                    ->search();
                        
    // add filter
    $search = $elastic->bool()
                    ->index('my_index')
                    ->must([
                        ['term' => ['name.keyword' => 'Şêro']]
                    ])
                    ->filter([
                            ['term' => ['tags' => 'production']]
                    ])
                    ->minimum_should_match(1)
                    ->boost(1)
                    ->search();
                    
    // must not
                        ...
                        ->mustNot([
                            ['range' => ['gte' => 10, 'lte' => 20]]
                        ]);
                        
    // should
                    ...
                    ->should([
                            ['term' => ['tags' => 'env1']],
                            ['term' => ['tags' => 'deployed']]
                        ])
                        
    // Merge with SORT
                        ...
                        ->mergeWith('elastic.sort', function(){
                            return $this
                                    ->field('age')
                                    ->order('asc')
                                    ->getMap();
                        });
                        
    // Merge with HIGHLIGHT
                            ...
                        ->mergeWith('elastic.highlight', function(){
                            return $this
                                ->content('name.keyword', '<div>', '</div>')
                                ->getMap();
                        });
                        
    // You can add GEO FILTER
                ...
                ->addGeoFilter('geo_shape', function(){
                                return $this
                                        ->index('location')
                                        ->type('circle')
                                        ->text('What is your name')
                                        ->coordinates([51.30, 20.34])
                                        ->radius('111km')
                                        ->getMap();
                });
                
    return $search;
    
Geo Shape
============
>The geo_shape data type facilitates the indexing of and searching with arbitrary geo shapes such as rectangles and polygons. It should be used when either the data being indexed or the queries being executed contain shapes other than just points.

Firstly you have to set index mappings for geo_shape if you haven't set:

    $index = $elastic
                    ->index()
                    ->name('my-index')
                    ->mappings(function(){
                            return $this
                                    ->body([
                                        'properties' => [
                                            'location' => [
                                                'type' => 'geo_shape',
                                            ]
                                        ]
                                    ])
                                    ->getMap();
                    })
                    ->updateMap();
                    
Save a document to search it
    
    $index = $elastic->document()
                    ->index('my-index')
                    ->body([
                        'text' => 'Şêro',
                        'location' => [
                            'type' => 'point',
                            'coordinates' => [-77.30, 38.34],
                        ]
                    ])
                    ->save();

Lets do a CIRCLE example:

    $geo = $elastic->geoShape()
                    ->index('my-index')
                    ->type('circle')
                    ->text('Şêro')
                    ->coordinates([-77.30, 38.34])
                    ->radius('111km')
                    ->search();
                        
    return $geo;
    
For more information:  https://www.elastic.co/guide/en/elasticsearch/reference/current/geo-shape.html

Geo Point
=====================
>Fields of type geo_point accept latitude-longitude pairs

Set the index mappings 

    $index = $elastic
            ->index()
            ->name('my_index')
            ->mappings(function(){
                    return $this
                            ->body([
                                'properties' => [
                                    'location' => [
                                        'type' => 'geo_point',
                                    ]
                                ]
                            ])
                            ->getMap();
            })
            ->updateMap();
            
Let's add an example data:

    $data = $elastic->document()
                    ->index('my-index')
                    ->body([
                        'text' => 'Şêro',
                        'location' => [
                            "lat" => 41.12,
                            "lon" => -71.34
                        ]
                    ])
                    ->save();
Searching...

    $search = $elastic->geoPoint()
                        ->index('my-index')
                        ->topLeft(42, -72)
                        ->bottomRight(40, -74)
                        ->getMap();

    return $search;
    
You can search with **location** function

    $geo = $elastic->geoPoint()
                    ->index('my-index')
                    ->pointType('geo_distance')
                    ->location([
                        'location' => [
                            "top_left" => [
                                "lat" => 42,
                                "lon" => -72
                            ],
                            "bottom_right" => [
                                "lat" => 40,
                                "lon" => -74
                            ]
                        ]
                    ])
                    ->search();

    // you don't need to use pointType(), it will return geo_bounding_box by default

    return $geo;

Match
=================
>Returns documents that match a provided text, number, date or boolean value. The provided text is analyzed before matching.

>The match query is the standard query for performing a full-text search, including options for fuzzy matching.

A sample search with Match

    $elastic = new ElasticSearch();

    $match = $elastic->match()
                        ->index('my-index')
                        ->field([
                                'name' => [
                                    'query' => 'Şêro',
                                    'fuzziness' => 1
                                ]
                            ])
                        ->search();
                        
    // You can merge with other features:
    
        $match = $elastic->match()
                        ->index('my-index')
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
                        ->mergeWith('elastic.highlight', function(){
                            return $this
                                    ->content('name', '<div>', '</div>')
                                    ->getMap();
                        })
                        ->search();

    return $match;


Range
=================

>Returns documents that contain terms within a provided range.

    $elastic = new ElasticSearch();
            
    $search = $elastic->range()
                    ->index('my-index')
                    ->content([
                        'age' => [
                            'gte' => 21,
                            'lte' => 26
                        ]
                    ])
                    ->search();
                    
    return $search;

Match Phrase
============

>The match_phrase query analyzes the text and creates a phrase query out of the analyzed text.

A sample search

    $elastic = new ElasticSearch();

    $phrase = $elastic->matchPhrase()
                    ->index('my-index')
                    ->field('name')
                    ->text('I use Elastic Search')
                    ->addition(['slop' => 1])
                    ->search();

    return $phrase;
    
Suggest
============
>Suggests similar looking terms based on a provided text by using a suggester. Parts of the suggest feature are still under development.

Save a suggestion to index

    $elastic = new ElasticSearch();

    $suggest = $elastic->suggest()
                    ->index('my-index')
                    ->id(1)
                    ->input([
                        [
                            'input' => 'My name is Şêro',
                            'weight' => 25
                        ]
                    ])
                    ->save();

Search with suggest

    $suggest = $elastic->suggest()
                ->index('my-index')
                ->name('my-index-suggest')
                ->text('My name is ') // it returns "My name is Şêro"
                ->completion([
                    'field' => 'suggest',
                    'skip_duplicates' => true
                ])
                ->search();
                
    return $suggest;
    
You can use multiple suggestion

    $suggest = $elastic->suggest()
                ->index('my-index')
                ->name('my-index-suggest')
                ->text('My name is ') // it returns "My name is Şêro"
                ->completion([
                    'field' => 'suggest',
                    'skip_duplicates' => true
                ])
                ->addSuggest(function(){
                    return $this->index('my-index')
                            ->name('my-index-suggest-2')
                            ->text('Music')
                            ->completion([
                                'field' => 'suggest',
                                'skip_duplicates' => true,
                                'fuzzy' => [
                                    'fuzziness' => 1
                                ]
                            ])
                            ->getMap();
                })
                ->addSuggest(function(){
                    return $this->index('my-index')
                                ->name('my-index-suggest-3')
                                ->text('Music')
                                ->completion([
                                    'field' => 'suggest',
                                    'skip_duplicates' => true
                                ])
                                ->getMap();
                    })
                ->search();
                
    return $suggest;
    
Other functions you can use for suggestion

    $suggest = $elastic->suggest()
                    ->index('my-index')
                    ->name('product-suggestion')
                    ->text('tring out Elasticsearch')
                    ->term(['name' => 'message'])
                    ->input([ "Nevermind", "Nirvana" ])
                    ->weight(34)
                    ->prefix('nir')
                    ->regex('regex')
                    ->completion([
                        'field' => 'suggest',
                        'size'  => 10,
                        'contexts' => [
                            'place_type' => [
                                [
                                    'context' => 'cafe'
                                ],
                                [
                                    'context'   => 'restaurants',
                                    'boost'     => 2
                                ]
                            ]
                        ]
                    ])
                    ->contexts([
                        [
                            "name" => "place_type",
                            "type" => "category"
                        ],
                        [
                            "name" => "location",
                            "type" => "geo",
                            "precision" => 4
                        ],
                    ])
                    ->simplePhrase(function(){
                        return $this
                                ->field('name')
                                ->directGenerator([
                                    [
                                        'field' => 'name',
                                        'suggest_mode'  => 'always'
                                    ],
                                    [
                                        "field" => "title.reverse",
                                        "suggest_mode" => "always",
                                        "pre_filter" => "reverse",
                                        "post_filter" => "reverse"
                                    ]
                                ])
                                ->highlight([
                                    'pre_tag' => "<em>",
                                    'post_tag' => "</em>"
                                ])
                                ->collate([
                                    'source' => [
                                        'match' => [
                                            "{{field_name}}" => "{{suggestion}}" 
                                        ]
                                    ]
                                ])
                                ->smoothing([
                                    'laplace' => [
                                        'alpha' => 0.7
                                    ]
                                ])
                                ->size(2)
                                ->getMap();
                    })
                    ->getMap();

Query
=============

You can use query function for creating, updating, searching etc.
For example:

    $elastic = new ElasticSearch();

    $result = $elastic->query([
        'index' => 'my-index',
        'body' => [
            'query' => [
                'match' => [
                    'name' => [
                        'query' => 'Şêro',
                        'fuzziness' => 1
                    ]
                ]
            ]
        ]
    ])->search();
    
    return $result;
    
    
Testing
============
Run in the terminal

     ./vendor/bin/phpunit tests