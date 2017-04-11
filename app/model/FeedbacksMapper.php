<?php

namespace App\Model;

use Nextras\Orm\Mapper\Dbal\DbalMapper;

class FeedbacksMapper extends DbalMapper
{
	public function getTableName()
	{
		return 'feedbacks';
	}
}
