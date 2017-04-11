<?php

namespace App\Model;

use Nextras\Orm\Repository\Repository;

final class FeedbacksRepository extends Repository
{
	public static function getEntityClassNames()
	{
		return [Feedback::class];
	}
}
