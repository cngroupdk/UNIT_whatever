<?php

namespace App\Chat;

use Nette\Utils\Json;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use Tracy\ILogger;


class BroadcastServer implements MessageComponentInterface
{
	/**
	 * @var \SplObjectStorage
	 */
	protected $clients;

	/**
	 * @var ILogger
	 */
	private $logger;


	public function __construct(ILogger $logger)
	{
		$this->clients = new \SplObjectStorage;
		$this->logger = $logger;
	}


	/**
	 * @param ConnectionInterface $connection
	 * @return void
	 */
	public function onOpen(ConnectionInterface $connection)
	{
		$this->logInfo('opened connection.'
			. ' Connection hash: ' . Json::encode(spl_object_hash($connection)));

		$this->clients->attach($connection);
	}


	/**
	 * @param ConnectionInterface $connection
	 * @param string $message
	 * @return void
	 */
	public function onMessage(ConnectionInterface $connection, $message)
	{
		$this->logInfo('received message.'
			. ' Connection hash: ' . Json::encode(spl_object_hash($connection))
			. ' Message: ' . Json::encode($message));

		// ignore
	}


	/**
	 * @param ConnectionInterface $connection
	 * @return void
	 */
	public function onClose(ConnectionInterface $connection)
	{
		$this->logInfo('closed connection.'
			. ' Connection hash: ' . Json::encode(spl_object_hash($connection)));

		$this->clients->detach($connection);
	}


	/**
	 * @param ConnectionInterface $connection
	 * @param \Exception $exception
	 * @return void
	 */
	public function onError(ConnectionInterface $connection, \Exception $exception)
	{
		$this->logInfo('received error.'
			. ' Connection hash: ' . Json::encode(spl_object_hash($connection))
			. ' Exception type: ' . Json::encode(get_class($exception))
			. ' Exception message: ' . Json::encode($exception->getMessage()));

		$connection->close();
	}


	/**
	 * @param string $message
	 * @return void
	 */
	public function broadcast($message)
	{
		/** @var ConnectionInterface $client */
		foreach ($this->clients as $client) {
			$this->sendMessage($client, $message);
		}
	}


	/**
	 * @param ConnectionInterface $connection
	 * @param string $message
	 * @return void
	 */
	private function sendMessage(ConnectionInterface $connection, $message)
	{
		$this->logInfo('sent message.'
			. ' Connection hash: ' . Json::encode(spl_object_hash($connection))
			. ' Message: ' . Json::encode($message));

		$connection->send($message);
	}


	/**
	 * @param string $message
	 * @return void
	 */
	private function logInfo($message)
	{
		$this->logger->log('BroadcastServer: ' . $message);
		echo 'info: ' . $message . "\n";
	}
}
