<?php

namespace App\Domain\User\Repository;

/**
 * Interface UserCollectionInterface
 * @package App\Domain\User\Repository
 */
interface UserCollectionInterface
{
    public function existsEmail($email): bool;
}