<?php

$query = $elastic->query()
		 ->cat()
		 ->aliases();

return $query;
