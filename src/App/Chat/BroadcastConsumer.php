<?php

namespace App\Chat;

use Bunny\Async\Client;
use Bunny\Channel;
use Bunny\Message;
use Ratchet;
use React;


class BroadcastConsumer
{

	/**
	 * @var string
	 */
	private $websocketHost = 'localhost';

	/**
	 * @var string
	 */
	private $websocketAddress = '127.0.0.1';

	/**
	 * @var int
	 */
	private $websocketPort = 3001;

	/**
	 * @var string
	 */
	private $queueName = 'broadcasts';

	/**
	 * @var BunnyClientFactory
	 */
	private $bunnyClientFactory;

	/**
	 * @var IBroadcastServerFactory
	 */
	private $broadcastServerFactory;

	/**
	 * @var BroadcastServer
	 */
	private $broadcastServer;

	/**
	 * @var React\EventLoop\LoopInterface
	 */
	private $loop;


	public function __construct(BunnyClientFactory $bunnyClientFactory, IBroadcastServerFactory $broadcastServerFactory)
	{
		$this->bunnyClientFactory = $bunnyClientFactory;
		$this->broadcastServerFactory = $broadcastServerFactory;
	}


	/**
	 * @return void
	 */
	public function run()
	{
		$this->loop = React\EventLoop\Factory::create();

		$bunny = $this->bunnyClientFactory->createAsyncClient($this->loop);

		$bunny->connect()->then(function (Client $client) {
			return $client->channel();

		})->then(function (Channel $channel) {
			return $channel->qos(0, 5)->then(function () use ($channel) {
				return $channel;
			});

		})->then(function (Channel $channel) {
			$channel->consume(
				function (Message $message, Channel $channel, Client $client) {
					$this->handleMessage($message);
					$channel->ack($message);
				},
				$this->queueName
			);
		});

		$this->broadcastServer = $this->broadcastServerFactory->create();

		$app = new Ratchet\App($this->websocketHost, $this->websocketPort, $this->websocketAddress, $this->loop);
		$app->route('/broadcast', $this->broadcastServer);

		$this->loop->run();
	}


	/**
	 * @param Message $message
	 * @return void
	 */
	private function handleMessage(Message $message)
	{
		$this->broadcastServer->broadcast('refresh');
	}
}
