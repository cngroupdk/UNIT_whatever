<?php

namespace App\Presenters;

use App\Model\Orm;
use App\Model\User;
use App\Forms;
use Nette\Application\UI\Form;
use Nette\Forms\Controls\TextInput;
use Nette\Security\AuthenticationException;
use Nette\Utils\ArrayHash;
use Nextras\Dbal\UniqueConstraintViolationException;


class SignPresenter extends BasePresenter
{
	/**
	 * @var Orm
	 * @inject
	 */
	public $orm;


	protected function createComponentSignInForm()
	{
		$form = new Form();

		$form->addText('email', 'Email:')
			->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('send', 'Sign in');

		$form->onSuccess[] = function (Form $form, $values) {
			try {
				$this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
				$this->user->login($values->email, $values->password);
			} catch (AuthenticationException $e) {
				$form->addError('The username or password you entered is incorrect.');
				return;
			}

			$this->redirect('Chat:');
		};

		return $form;
	}


	protected function createComponentSignUpForm()
	{
		$form = new Form();

		$form->addEmail('email', 'Email:')
			->setRequired('Please enter your email.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please provide a password.');

		$form->addSubmit('send', 'Sign up');

		$form->onSuccess[] = function (Form $form, ArrayHash $values) {
			try {
				$user = new User();
				$user->email = $values->email;
				$user->setPassword($values->password);
				$this->orm->persistAndFlush($user);
			} catch (UniqueConstraintViolationException $e) {
				/** @var TextInput $emailControl */
				$emailControl = $form['email'];
				$emailControl->addError('User with this email address already exists.');
				return;
			}

			$this->redirect('Chat:');
		};

		return $form;
	}


	public function actionOut()
	{
		$this->getUser()->logout();
		$this->flashMessage('You have been signed out.');
		$this->redirect('Sign:in');
	}

}
