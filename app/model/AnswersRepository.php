<?php

namespace App\Model;

use Nextras\Orm\Repository\Repository;

final class AnswersRepository extends Repository
{
	public static function getEntityClassNames()
	{
		return [Answer::class];
	}
}
