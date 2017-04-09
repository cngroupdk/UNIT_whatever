<?php

namespace App\Model;

use Nextras\Orm\Mapper\Dbal\DbalMapper;

class UsersMapper extends DbalMapper
{
	public function getTableName()
	{
		return 'users';
	}
}
