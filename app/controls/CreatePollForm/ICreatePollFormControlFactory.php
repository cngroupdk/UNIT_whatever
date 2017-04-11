<?php

namespace App\Controls\CreatePollForm;

use App\Model\User;


interface ICreatePollFormControlFactory
{
	/**
	 * @param User|null $user
	 * @param callable $onSuccess function (Poll $poll)
	 * @return CreatePollFormControl
	 */
	public function create($user, callable $onSuccess);
}
