<?php

use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Url\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// bootstrap
require __DIR__ . '/vendor/autoload.php';
$config = include __DIR__ . '/config.php';
$request = Request::createFromGlobals();

// trim base dir from request url (when running from subdir)
$basePath = '/' . Url::createFromUrl($config['url'])->getPath();
$key = ltrim( $request->getRequestUri(), $basePath );

// bail if no key given
if( empty( $key ) ) {
	return new Response( 'Nothing here, move along.', 404 );
}

// todo: allow using different storages, like dropbox to manage redirects.
$adapter = new Local(__DIR__ . '/redirects');
$filesystem = new Filesystem($adapter);

// got a redirect file?
if( $filesystem->has( $key ) ) {
	// todo: maybe read lines. First line is redirect URL, second line is number of hits.
	$url = $filesystem->read( $key );
	$response = new RedirectResponse( $url, 302 );
} else {
	// no redirect exists with that key
	$response = new Response( 'Nothing here, move along please.', 404 );
}

// send response and exit
$response->send();
exit;

