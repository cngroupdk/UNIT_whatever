<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;

/**
 * @property int $id {primary}
 * @property Poll $poll {m:1 Poll::$categories}
 * @property string $name
 */
class Category extends Entity
{
}
