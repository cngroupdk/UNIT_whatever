<?php

namespace App\Model;

use Nextras\Orm\Mapper\Dbal\DbalMapper;

class CategoriesMapper extends DbalMapper
{
	public function getTableName()
	{
		return 'categories';
	}
}
