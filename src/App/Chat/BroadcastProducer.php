<?php

namespace App\Chat;

use Nette\Utils\Json;


class BroadcastProducer
{

	private $queueName = 'broadcasts';

	/**
	 * @var BunnyClientFactory
	 */
	private $bunnyClientFactory;


	public function __construct(BunnyClientFactory $bunnyClientFactory)
	{
		$this->bunnyClientFactory = $bunnyClientFactory;
	}


	public function broadcast()
	{
		$bunny = $this->bunnyClientFactory->createNonasyncClient();
		$bunny->connect();

		$channel = $bunny->channel();
		$channel->queueDeclare($this->queueName);

		$channel->publish(Json::encode([]), [], '', $this->queueName);
	}
}
