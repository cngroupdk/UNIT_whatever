<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * @property int $id {primary}
 * @property User $user {m:1 User::$polls}
 * @property string $name
 * @property string $description
 * @property string $type {enum self::TYPE_*}
 * @property OneHasMany|Category[] $categories {1:m Category::$poll, orderBy=id}
 * @property OneHasMany|Feedback[] $feedbacks {1:m Feedback::$poll, orderBy=[createdAt=DESC]}
 */
class Poll extends Entity
{
	const TYPE_SINGLE_CATEGORY = 'single_category';
	const TYPE_MULTIPLE_CATEGORY = 'multiple_category';
	const TYPE_RATINGS = 'ratings';
}
