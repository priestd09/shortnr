#!/usr/bin/env php
<?php
// application.php
require __DIR__.'/vendor/autoload.php';

use Shortnr\Command\Redirect\CreateCommand;
use Shortnr\Command\Redirect\DeleteCommand;
use Shortnr\ShortnrServiceProvider;
use Symfony\Component\Console\Application;

// register dependencies
$container = new League\Container\Container;
$container->add('app_dir', __DIR__);
$container->addServiceProvider(new ShortnrServiceProvider());

$application = new Application();
$application->add(new CreateCommand($container->get('filesystem'), $container->get('config')));
$application->add(new DeleteCommand($container->get('filesystem'), $container->get('config')));
$application->run();