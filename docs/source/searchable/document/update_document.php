<?php

$elastic = new ElasticSearch();

$update = $elastic->find('my-index', 'Lpkpd53YBR6XiqYGx3M98')->update([
    'name' => 'Şêro'
]);

return $update;
