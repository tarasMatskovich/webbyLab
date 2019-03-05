<?php

return [
	'/' => 'index/index',
	'list' => 'film/index',
	'film/([0-9]+)' => 'film/show/$1',
	'add' => 'film/add',
	'addFilm' => 'film/addFilm',
	'delete/([0-9]+)' => 'film/delete/$1',
	'search' => 'search/search',
	'actors/search' => 'search/actors',
	'searchByActor' => 'search/searchByActor',
	'import' => 'import/index',
	'store/import' => 'import/store'
];