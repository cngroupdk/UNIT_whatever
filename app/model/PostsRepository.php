<?php

namespace App\Model;

use Nextras\Orm\Repository\Repository;

final class PostsRepository extends Repository
{
	public static function getEntityClassNames()
	{
		return [Post::class];
	}
}
