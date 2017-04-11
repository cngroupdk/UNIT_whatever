<?php

namespace App\Presenters;

use App\Model\User;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\Identity;
use Nette\Utils\ArrayHash;


class SignPresenter extends BasePresenter
{
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

			$this->redirect('Admin:');
		};

		return $form;
	}


	/** @var User */
	private $userFromToken;


	public function actionUp(string $token)
	{
		$this->userFromToken = $this->orm->users->getBy(['token' => $token]);
		if ($this->userFromToken === null) {
			$this->flashMessage('Token is invalid', 'error');
			$this->redirect('Sign:in');
		}

		$this->getTemplate()->add('userFromToken', $this->userFromToken);
	}


	protected function createComponentSignUpForm()
	{
		assert($this->userFromToken !== null);

		$form = new Form();

		$form->addPassword('password', 'Password:')
			->setRequired('Please provide a password.');

		$form->addSubmit('send', 'Set password');

		$form->onSuccess[] = function (Form $form, ArrayHash $values) {
			$this->userFromToken->setPassword($values->password);
			$this->userFromToken->token = null;
			$this->orm->persistAndFlush($this->userFromToken);

			$this->flashMessage('Password was successfully set. You are logged in.', 'success');
			$this->getUser()->login(new Identity($this->userFromToken->id));

			$this->redirect('Admin:');
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
