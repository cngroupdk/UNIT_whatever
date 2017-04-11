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
		// TODO: Implement actionFeedbacks() method
		throw new \BadMethodCallException('Method ' . __METHOD__ . '() is not implemented.');
	}
}
