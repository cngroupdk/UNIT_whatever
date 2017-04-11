<?php

namespace App\Presenters;

use App\Model\Poll;


final class AdminPresenter extends BasePresenter
{
	public function actionDefault()
	{
		assert($this->currentUser !== null);
		$this->getTemplate()->add('polls', $this->currentUser->polls);
	}


	/**
	 * @param int $id
	 */
	public function actionDetail($id)
	{
		/** @var Poll|null $poll */
		$poll = $this->orm->polls->getById($id);

		if (!$poll) {
			$this->flashMessage('Poll not found', 'warning');
			$this->redirect('default');
		}

		assert($this->currentUser !== null);

		if ($poll->user->id !== $this->currentUser->id) {
			$this->flashMessage('Access denied', 'error');
			$this->redirect('default');
		}

		$this->getTemplate()->add('poll', $poll);
	}
}
