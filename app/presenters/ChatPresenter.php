<?php

namespace App\Presenters;

use App\Model\Orm;
use App\Model\Post;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
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

		$form->onSuccess[] = function (Form $form, ArrayHash $values) {
			$post = new Post();
			$post->author = $this->orm->users->getById(1);
			$post->text = $values->text;
			$post->createdAt = new \DateTime();
			$this->orm->persistAndFlush($post);
			$this->redirect('this');
		};

		return $form;
	}

}
