<?php

namespace App\Presenters;

use App\Model\Orm;
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

}
