<?php

namespace App\Model;

use Nextras\Orm\Repository\Repository;

final class UsersRepository extends Repository
{
	public static function getEntityClassNames()
	{
		return [User::class];
	}


	/**
	 * @param string $email
	 * @return bool
	 */
	public function isEmailTaken($email)
	{
		return count($this->getBy(['email' => $email])) > 0;
	}
}
