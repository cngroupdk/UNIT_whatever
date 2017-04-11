<?php

namespace App\Model;

use Nextras\Orm\Repository\Repository;

final class CategoriesRepository extends Repository
{
	public static function getEntityClassNames()
	{
		return [Category::class];
	}
}
