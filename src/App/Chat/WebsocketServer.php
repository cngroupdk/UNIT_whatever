<?php

namespace App\Chat;

use Nette\Utils\Json;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;


class WebsocketServer implements MessageComponentInterface
{
	/**
	 * @var \SplObjectStorage
	 */
	protected $clients;


	public function __construct()
	{
		$this->clients = new \SplObjectStorage;
	}


	public function onOpen(ConnectionInterface $connection)
	{
		$this->clients->attach($connection);
	}


	public function onMessage(ConnectionInterface $connection, $message)
	{
		// ignore
	}


	public function onClose(ConnectionInterface $connection)
	{
		$this->clients->detach($connection);
	}


	public function onError(ConnectionInterface $connection, \Exception $exception)
	{
		$connection->close();
	}


	public function broadcast()
	{
		/** @var ConnectionInterface $client */
		foreach ($this->clients as $client) {
			$client->send(Json::encode([]));
		}
	}
}
