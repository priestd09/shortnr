<?php

namespace Shortnr\Command\Redirect;

use League\Flysystem\FileNotFoundException;
use League\Flysystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteCommand extends Command
{

	/**
	 * @var Filesystem
	 */
	protected $filesystem;

	/**
	 * @var array
	 */
	protected $config;

	/**
	 * @param Filesystem $filesystem
	 * @param array $config
	 */
	public function __construct(Filesystem $filesystem, array $config ) {
		$this->filesystem = $filesystem;
		$this->config = $config;

		parent::__construct();
	}

	protected function configure()
	{
		$this
			->setName('redirects:delete')
			->setDescription('Delete a redirect.')
			->addArgument(
				'key',
				InputArgument::REQUIRED,
				'The key of the redirect which you want to delete.'
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$key = $input->getArgument('key');

		try{
			$url = $this->filesystem->readAndDelete($key);
			$output->writeln(sprintf( "<info>Success! Redirect to %s is deleted.</info>", $url));
		} catch( FileNotFoundException $exception ) {
			$output->writeln(sprintf("<error>No redirect found with key %s.", $key));
		}
	}
}