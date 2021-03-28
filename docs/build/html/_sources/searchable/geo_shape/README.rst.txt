Geo Shape
==================

The geo_shape data type facilitates the indexing of and searching with arbitrary geo shapes such as rectangles and polygons. It should be used when either the data being indexed or the queries being executed contain shapes other than just points.

Firstly you have to set index mappings for geo_shape if you haven't set:

.. literalinclude:: mapping.php
   :language: php
   :linenos:

Save a document to search it

.. literalinclude:: saving.php
   :language: php
   :linenos:

Lets do a CIRCLE example:

.. literalinclude:: circle.php
   :language: php
   :linenos:


For more information:  https://www.elastic.co/guide/en/elasticsearch/reference/current/geo-shape.html
