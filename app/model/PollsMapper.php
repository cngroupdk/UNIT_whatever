<?php

namespace App\Model;

use Nextras\Orm\Mapper\Dbal\DbalMapper;

class PollsMapper extends DbalMapper
{
	public function getTableName()
	{
		return 'polls';
	}
}
