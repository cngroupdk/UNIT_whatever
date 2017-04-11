<?php

namespace App\Model;

use Nextras\Orm\Repository\Repository;

final class PollsRepository extends Repository
{
	public static function getEntityClassNames()
	{
		return [Poll::class];
	}
}
