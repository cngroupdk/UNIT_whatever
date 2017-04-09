<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;

/**
 * @property int $id {primary}
 * @property User $author {m:1 User::$posts}
 * @property string $text
 * @property \DateTime $createdAt
 */
class Post extends Entity
{
}
