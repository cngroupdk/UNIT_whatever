<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;

/**
 * @property int $id {primary}
 * @property Feedback $feedback {m:1 Feedback::$answers}
 * @property Category $category {m:1 Category, oneSided=true}
 * @property string $text
 */
class Answer extends Entity
{
}
