<?php

namespace App\Console;

use App\Chat\BroadcastConsumer;
use App\Model\Orm;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class BroadcastConsumerCommand extends Command
{
	/**
	 * @var Orm
	 * @inject
	 */
	public $orm;

	/**
	 * @var BroadcastConsumer
	 * @inject
	 */
	public $broadcastConsumer;


	protected function configure()
	{
		$this->setName('broadcast-consumer');
		$this->setDescription('Runs a broadcast consumer');
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->broadcastConsumer->run();
	}
}
