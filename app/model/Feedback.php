<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * @property int $id {primary}
 * @property Poll $poll {m:1 Poll::$feedbacks}
 * @property \DateTime $createdAt
 * @property OneHasMany|Answer[] $answers {1:m Answer::$feedback}
 */
class Feedback extends Entity
{
}
