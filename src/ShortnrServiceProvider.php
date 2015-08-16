<?php

namespace Shortnr;

use Dropbox\Client;
use League\Container\ServiceProvider;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;
use Dotenv\Dotenv;

class ShortnrServiceProvider extends ServiceProvider
{
	/**
	 * This array allows the container to be aware of
	 * what your service provider actually provides,
	 * this should contain all alias names that
	 * you plan to register with the container
	 *
	 * @var array
	 */
	protected $provides = [
		'config',
		'filesystem'
	];

	/**
	 * This is where the magic happens, within the method you can
	 * access the container and register or retrieve anything
	 * that you need to
	 */
	public function register()
	{
		$container = $this->getContainer();

		$container->add('config', function() use($container){
			// load config file (with .env support)
			$dotenv = new Dotenv($container['app_dir']);
			$dotenv->load();
			$config = include $container['app_dir'] . '/config.php';
			return $config;
		});

		$container->add('storage.local', function() use($container) {
			$config = $container->get('config');
			$adapter = new Local($config['local']['dir'] . '/redirects');
			return $adapter;
		});

		$container->add('storage.dropbox', function() use($container) {
			$config = $container->get('config');
			$client = new Client($config['dropbox']['access_token'], $config['dropbox']['app_secret']);
			$adapter = new DropboxAdapter($client);
			return $adapter;
		});

		$container->add('filesystem', function() use($container) {
			$config = $container->get('config');
			return new Filesystem( $container->get( 'storage.' . $config['storage'] ) );
		});

	}
}