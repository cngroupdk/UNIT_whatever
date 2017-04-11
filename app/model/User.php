<?php

namespace App\Model;

use Nette\Security\Passwords;
use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * @property int $id {primary}
 * @property string $email
 * @property string|null $passwordHash
 * @property string|null $token
 * @property OneHasMany|Poll[] $polls {1:m Poll::$user, orderBy=name}
 */
class User extends Entity
{
	/**
	 * @param string $password
	 * @return void
	 */
	public function setPassword($password)
	{
		$this->passwordHash = Passwords::hash($password);
	}


	/**
	 * @param string $password
	 * @return bool
	 */
	public function passwordEquals($password)
	{
		return Passwords::verify($password, $this->passwordHash);
	}
}
