<?php

namespace App\Chat;

use Bunny;
use React\EventLoop\LoopInterface;


class BunnyClientFactory
{
	/**
	 * @var array
	 */
	private $options;


	public function __construct(array $options)
	{
		$this->options = $options;
	}


	/**
	 * @param LoopInterface $eventLoop
	 * @return Bunny\Async\Client
	 */
	public function createAsyncClient(LoopInterface $eventLoop)
	{
		return new Bunny\Async\Client($eventLoop, $this->options);
	}


	/**
	 * @return Bunny\Client
	 */
	public function createNonasyncClient()
	{
		return new Bunny\Client($this->options);
	}
}
