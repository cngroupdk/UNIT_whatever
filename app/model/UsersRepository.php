<?php

namespace App\Model;

use Nextras\Orm\Repository\Repository;

final class UsersRepository extends Repository
{
	public static function getEntityClassNames()
	{
		return [User::class];
	}
}
