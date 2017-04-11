<?php

namespace App\Presenters;


final class AdminPresenter extends BasePresenter
{
	/**
	 * List of Polls
	 */
	public function actionDefault()
	{
		assert($this->currentUser !== null);
		$this->getTemplate()->add('polls', $this->orm->polls->findBy(['user' => $this->currentUser])->fetchAll());
	}


	/**
	 * List of feedbacks of some Poll
	 *
	 * @param $pollId
	 */
	public function actionFeedbacks($pollId)
	{
		assert($this->currentUser !== null);
		$poll = $this->orm->polls->getById($pollId);

		$feedbacks = $this->orm->feedbacks->findBy(['poll' => $poll])->fetchAll();
		$this->getTemplate()->add('feedbacks', $feedbacks);
	}
}
