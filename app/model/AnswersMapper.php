<?php

namespace App\Model;

use Nextras\Orm\Mapper\Dbal\DbalMapper;

class AnswersMapper extends DbalMapper
{
	public function getTableName()
	{
		return 'answers';
	}
}
