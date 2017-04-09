<?php

namespace App\Chat;

use Bunny\Async\Client;

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
	 * @return Client
	 */
	public function createAsyncClient()
	{
		return new Client($this->options);
	}


	/**
	 * @return Client
	 */
	public function createNonasyncClient()
	{
		return new \Bunny\Client($this->options);
	}
}
