<?php

use League\Flysystem\FileNotFoundException;
use League\Url\Url;
use Shortnr\ShortnrServiceProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// bootstrap
require __DIR__ . '/vendor/autoload.php';

// register dependencies
$container = new League\Container\Container;
$container->add('app_dir', __DIR__);
$container->addServiceProvider(new ShortnrServiceProvider());

// create request object
$request = Request::createFromGlobals();

// trim base dir from request url (when running from subdir)
$basePath = '/' . Url::createFromUrl($config['url'])->getPath();
$key = ltrim($request->getRequestUri(), $basePath);
$key = preg_replace('/[^\w-]/', '', $key);

// bail if no key given
if( empty( $key ) ) {
	$response = new Response( 'Nothing here, move along.', 404 );
	$response->send();
	exit;
}

$filesystem = $container->get('filesystem');

try {
	// todo: maybe read lines. First line is redirect URL, second line is number of hits.
	$url = $filesystem->read( $key );
	$response = new RedirectResponse( $url, 302 );
} catch( FileNotFoundException $exception ) {
	// no redirect exists with that key
	$response = new Response( 'Nothing here, move along please.', 404 );
}

// send response and exit
$response->send();
exit;

