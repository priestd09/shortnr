#!/usr/bin/env php
<?php
// application.php

require __DIR__.'/vendor/autoload.php';

use Shortnr\Command\Redirect\CreateCommand;
use Symfony\Component\Console\Application;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

// create instance dependency for commands
// todo: move to DI container?
$adapter = new Local(__DIR__ . '/redirects');
$filesystem = new Filesystem($adapter);

// load config file (with .env support)
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
$config = include __DIR__ . '/config.php';

$application = new Application();
$application->add(new CreateCommand($filesystem, $config));
$application->run();