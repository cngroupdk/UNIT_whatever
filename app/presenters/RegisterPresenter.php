<?php

namespace App\Presenters;

use App\Controls\CreatePollForm\ICreatePollFormControlFactory;
use App\Model\Poll;
use Nette\Security\Identity;


class RegisterPresenter extends BasePresenter
{
	/**
	 * @var ICreatePollFormControlFactory
	 * @inject
	 */
	public $createPollFormControlFactory;


	protected function createComponentCreatePollForm()
	{
		return $this->createPollFormControlFactory->create(null, function (Poll $poll) {
			$this->getUser()->login(new Identity($poll->user->id));
			$this->flashMessage('We have sent you an email with instructions how to set your password.');
			$this->redirect('Admin:detail', ['id' => $poll->id]);
		});
	}
}
