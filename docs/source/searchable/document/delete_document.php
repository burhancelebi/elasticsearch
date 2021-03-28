<?php

$elastic = new ElasticSearch();

$delete = $elastic->find('my-index', 'Lpkpd53YBR6XiqYGx3M98')->delete();

return $delete;
