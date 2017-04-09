<?php

namespace App\Chat;


interface IBroadcastServerFactory
{

	/**
	 * @return BroadcastServer
	 */
	public function create();

}
