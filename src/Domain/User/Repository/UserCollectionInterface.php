<?php

namespace App\Domain\User\Repository;

use App\Domain\User\ValueObject\Email;

/**
 * Interface UserCollectionInterface
 * @package App\Domain\User\Repository
 */
interface UserCollectionInterface
{
    public function existsEmail(Email $email): bool;
}