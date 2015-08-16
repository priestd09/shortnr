<?php

namespace Shortnr\Command\Redirect;

use League\Flysystem\Filesystem;
use League\Url\Url;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateCommand extends Command
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
				'Key for this redirect',
				''
			)
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$key = $input->getOption('key');
		$url = Url::createFromUrl( $input->getArgument('url') );

		// if url is missing a protocol, add http://
		if('' === $url->getScheme()->getUriComponent()) {
			$url->setScheme('http');
			$output->writeln("<comment>Scheme of target URL missing, assuming \"http\"</comment>.");
		}

		// was a key argument given?
		if( '' === $key ) {
			// create key based on host and path
			$key = str_replace(
				array('.', '/', 'a', 'e', 'o', 'i'),
				'',
				$url->getHost() . $url->getPath()
			);
		}

		// create redirect file
		$this->filesystem->put($key,$url);

		// output feedback
		$output->writeln(sprintf( "<info>Success! Redirect to %s created at %s.</info>", $url, $this->config['url'] . $key));
	}
}