<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * @property int $id {primary}
 * @property string $email
 * @property string $passwordHash
 * @property OneHasMany|Post[] $posts {1:m Post::$author}
 */
class User extends Entity
{
}
