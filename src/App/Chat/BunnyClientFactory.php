<?php

namespace App\Chat;

use Bunny\Async\Client;

class BunnyClientFactory
{

	/**
	 * @var array
	 */
	private $config;

	public function __construct(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @return Client
	 */
	public function createClient()
	{
		return new Client($this->config);
	}
}
