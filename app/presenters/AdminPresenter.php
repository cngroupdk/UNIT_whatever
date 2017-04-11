<?php

namespace App\Presenters;

use App\Model\Poll;


final class AdminPresenter extends BasePresenter
{
	const VIEW_FEEDBACKS = 'feedbacks';
	const VIEW_SHARING = 'sharing';


	public function actionDefault()
	{
		assert($this->currentUser !== null);
		$this->getTemplate()->add('polls', $this->currentUser->polls);
	}


	/**
	 * @param int $id
	 * @param string|null $view
	 */
	public function actionDetail($id, $view = null)
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

		if ($view === null || !in_array($view, [self::VIEW_FEEDBACKS, self::VIEW_SHARING], true)) {
			$view = $poll->feedbacks->countStored() > 0 ? self::VIEW_FEEDBACKS : self::VIEW_SHARING;
		}

		$template = $this->getTemplate();
		$template->add('poll', $poll);
		$template->add('view', $view);
	}
}
