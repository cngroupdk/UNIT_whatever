<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;
use Nette\Bridges\ApplicationLatte\Template;


/**
 * Base presenter for all application presenters.
 * @method Template getTemplate()
 */
abstract class BasePresenter extends Presenter
{

	protected function startup()
	{
		parent::startup();

		if ($this->getUser()->isLoggedIn()) {
			if ($this->name === 'Sign' && $this->action !== 'out') {
				$this->redirect('Chat:');
			}
		} else {
			if (!in_array($this->name, ['Homepage', 'Sign', 'Register'], true)) {
				$this->redirect('Sign:in');
			}
		}
	}

}
