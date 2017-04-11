<?php

namespace App\Presenters;

use App\Model\Orm;
use App\Model\User;
use Nette\Application\UI\Presenter;
use Nette\Bridges\ApplicationLatte\Template;


/**
 * Base presenter for all application presenters.
 * @method Template getTemplate()
 */
abstract class BasePresenter extends Presenter
{
	/**
	 * @var Orm
	 * @inject
	 */
	public $orm;

	/**
	 * @var User|null User if logged in, NULL if not logged in
	 */
	protected $currentUser;

	protected function startup()
	{
		parent::startup();

		if ($this->getUser()->isLoggedIn()) {
			if ($this->name === 'Sign' && $this->action !== 'out') {
				$this->redirect('Chat:');
			}
		} else {
			if (!in_array($this->name, ['Homepage', 'Sign', 'Register', 'Feedback'], true)) {
				$this->redirect('Sign:in');
			}
		}

		if ($this->getUser()->isLoggedIn()) {
			$this->currentUser = $this->orm->users->getById($this->getUser()->getId());
		}
	}

}
