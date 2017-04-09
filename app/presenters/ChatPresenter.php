<?php

namespace App\Presenters;

use App\Model\Orm;
use Nette\Application\UI\Form;
use Nextras\Orm\Collection\ICollection;


class ChatPresenter extends BasePresenter
{

	/**
	 * @var Orm
	 * @inject
	 */
	public $orm;

	public function renderDefault()
	{
		$template = $this->getTemplate();
		$template->add('posts', $this->orm->posts->findAll()->orderBy('createdAt', ICollection::DESC));
	}

	protected function createComponentPostForm()
	{
		$form = new Form();

		$form->addText('text');

		$form->addSubmit('send', 'Odeslat');

		return $form;
	}

}
