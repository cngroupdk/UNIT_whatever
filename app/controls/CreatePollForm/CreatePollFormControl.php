<?php

namespace App\Controls\CreatePollForm;

use App\Controls\BaseControl;
use App\Model\Category;
use App\Model\Orm;
use App\Model\Poll;
use App\Model\User;
use App\Users\EmailAlreadyTakenException;
use App\Users\UserCreator;
use Nette\Application\UI\Form;


class CreatePollFormControl extends BaseControl
{
	/**
	 * @var User|null
	 */
	private $user;

	/**
	 * @var callable function (Poll $poll)
	 */
	private $onSuccess;

	/**
	 * @var Orm
	 */
	private $orm;

	/**
	 * @var UserCreator
	 */
	private $userCreator;


	/**
	 * @param User|null $user
	 * @param callable $onSuccess function (Poll $poll)
	 * @param Orm $orm
	 * @param UserCreator $userCreator
	 */
	public function __construct($user, callable $onSuccess, Orm $orm, UserCreator $userCreator)
	{
		parent::__construct();
		$this->user = $user;
		$this->onSuccess = $onSuccess;
		$this->orm = $orm;
		$this->userCreator = $userCreator;
	}


	public function render()
	{
		$params = [
			'currentUser' => $this->user,
			'createNewUser' => $this->user === null,
			'categories' => $this->getCategories(),
		];

		$this->getTemplate()->render(__DIR__ . '/default.latte', $params);
	}


	protected function createComponentForm()
	{
		$form = new Form();

		$form->addProtection();

		$form->addText('name')
			->addRule(Form::FILLED, 'Please enter a questionnaire name.');

		$form->addTextArea('description')
			->addRule(Form::FILLED, 'Please enter a questionnaire description.');

		if ($this->user	=== null) {
			$form->addText('email')
				->addRule(Form::FILLED, 'Please enter your email address.')
				->addRule(Form::EMAIL, 'Please enter a valid email address.');
		}

		$form->addSubmit('submit');

		$form->onSuccess[] = function (Form $form) {
			$this->handleSuccess($form);
		};

		return $form;
	}


	/**
	 * @param Form $form
	 * @return void
	 */
	private function handleSuccess(Form $form)
	{
		$values = $form->getValues();
		$user = $this->user;

		if ($user === null) {
			try {
				$user = $this->userCreator->createUserAndSendAuthEmail($values->email);
			} catch (EmailAlreadyTakenException $e) {
				$form->addError('User with this email address already exists.');
				return;
			}
		}

		$poll = new Poll();
		$poll->user = $user;
		$poll->name = $values->name;
		$poll->description = $values->description;

		foreach ($this->getCategories() as $categoryName) {
			$category = new Category();
			$category->name = $categoryName;
			$poll->categories->add($category);
		}

		$this->orm->persistAndFlush($poll);
		call_user_func($this->onSuccess, $poll);
	}


	/**
	 * @return string[]
	 */
	private function getCategories()
	{
		/** @var Form $form */
		$form = $this['form'];
		$categories = $form->getHttpData($form::DATA_LINE, 'categories[]');

		return array_filter($categories, function ($value) {
			return trim($value) !== '';
		});
	}
}
