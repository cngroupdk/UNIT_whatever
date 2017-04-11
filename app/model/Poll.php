<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * @property int $id {primary}
 * @property User $user {m:1 User::$polls}
 * @property string $name
 * @property OneHasMany|Category[] $categories {1:m Category::$poll}
 * @property OneHasMany|Feedback[] $feedbacks {1:m Feedback::$poll}
 */
class Poll extends Entity
{
}
