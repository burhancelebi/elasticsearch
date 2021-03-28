Aggregation
=======================

An aggregation summarizes your data as metrics, statistics, or other analytics. Aggregations help you answer questions like:

- What’s the average load time for my website?
- Who are my most valuable customers based on transaction volume?
- What would be considered a large file on my network?
- How many products are in each product category?


**A sample search**

.. literalinclude:: sample.php
   :language: php
   :linenos:

**Terms Aggregation**

.. literalinclude:: terms_aggs.php
   :language: php
   :linenos:

**Add custom metadata**

.. literalinclude:: metadata.php
   :language: php
   :linenos:


**Return only aggregation results**

By default, searches containing an aggregation return both search hits and aggregation results. To return only aggregation results, set size to 0.

.. literalinclude:: size_result.php
   :language: php
   :linenos:

**Run multiple aggregations**

You can use multiple aggregations in the same request.

.. literalinclude:: multiple_aggregations.php
   :language: php
   :linenos:

**Run sub-aggregations**

Bucket aggregations support bucket or metric sub-aggregations. There is no level or depth limit for nesting sub-aggregations.

.. literalinclude:: sub-aggregations.php
   :language: php
   :linenos:



