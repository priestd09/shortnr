<?php

namespace Shortnr\Command\Redirect;

use League\Flysystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends Command
{

	public function __construct(Filesystem $filesystem) {
		$this->filesystem = $filesystem;

		parent::__construct();
	}

	protected function configure()
	{
		$this
			->setName('redirects:create')
			->setDescription('Create a new redirect.')
			->addArgument(
				'url',
				InputArgument::REQUIRED,
				'The url to which you want to redirect.'
			)
			->addOption(
				'key',
				'k',
				InputOption::VALUE_OPTIONAL,
				'Key for this redirect'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{

		$url = $input->getArgument('url');
		$key = $input->getOption('key');

		// create key
		$this->filesystem->put($key,$url);

		$output->writeln("Redirect created!");
	}
}