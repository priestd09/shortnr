<?php

$config = [
	'url' => 'http://shortnr.com/',
	'storage' => 'dropbox', // choose between "local" or "dropbox"

	'local' => [
		'dir' => __DIR__
	],
	
	'dropbox' => [
		'access_token' => getenv('DROPBOX_ACCESS_TOKEN'),
		'app_secret' => getenv('DROPBOX_APP_SECRET')
	]
];

return $config;