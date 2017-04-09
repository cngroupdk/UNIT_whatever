<?php

namespace App\Chat;

use Bunny\Async\Client;
use Bunny\Channel;
use Bunny\Message;
use Ratchet\Server\IoServer;
use React;


class BroadcastConsumer
{

	/**
	 * @var int
	 */
	private $websocketPort = 3001;

	/**
	 * @var string
	 */
	private $websocketAddress = '0.0.0.0';

	/**
	 * @var string
	 */
	private $queueName = 'broadcasts';

	/**
	 * @var BunnyClientFactory
	 */
	private $bunnyClientFactory;

	/**
	 * @var WebsocketServer
	 */
	private $websocketServer;

	/**
	 * @var IoServer
	 */
	private $ioServer;

	/**
	 * @var React\EventLoop\LoopInterface
	 */
	private $loop;


	public function __construct(BunnyClientFactory $bunnyClientFactory)
	{
		$this->bunnyClientFactory = $bunnyClientFactory;
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

		$socket = new React\Socket\Server($this->loop);
		$socket->listen($this->websocketPort, $this->websocketAddress);
		$this->websocketServer = new WebsocketServer();
		$this->ioServer = new IoServer($this->websocketServer, $socket, $this->loop);

		$this->loop->run();
	}


	/**
	 * @param Message $message
	 * @return void
	 */
	private function handleMessage(Message $message)
	{
		$this->websocketServer->broadcast();
	}
}
