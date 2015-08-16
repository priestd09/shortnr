<?php

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require __DIR__ . '/vendor/autoload.php';

$adapter = new Local(__DIR__ . '/redirects');
$filesystem = new Filesystem($adapter);

$request = Request::createFromGlobals();
$key = trim( $request->getRequestUri(), '/' );

// nothing found with that key
if( ! $filesystem->has( $key ) ) {
	$response = new Response( 'Nothing here, move along please.', 404 );
	$response->send();
	exit;
}

// todo: read lines. First line is redirect URL, second line is number of hits.
$url = $filesystem->read( $key );
$response = new RedirectResponse( $url, 302 );
$response->send();
exit;

