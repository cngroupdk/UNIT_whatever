<?php

namespace App\Model;

use Nette\Security\Passwords;
use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * @property int $id {primary}
 * @property string $email
 * @property string $passwordHash
 * @property OneHasMany|Post[] $posts {1:m Post::$author}
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
