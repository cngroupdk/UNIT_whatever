<?php

namespace App\Model;

use Nextras\Orm\Mapper\Dbal\DbalMapper;

class PostsMapper extends DbalMapper
{
	public function getTableName()
	{
		return 'posts';
	}
}
