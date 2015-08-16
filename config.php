<?php

$config = [
	'url' => 'http://shortnr.com/',
	'storage' => 'local', // this isn't actually working yet

	'dropbox' => [
		'access_token' => getenv('DROPBOX_ACCESS_TOKEN'),
		'app_secret' => getenv('DROPBOX_APP_SECRET')
	]

];

return $config;