<?php

namespace App\Domain\User\Repository;

use App\Domain\User\User;
use App\Domain\User\UserId;

/**
 * Interface UserRepositoryInterface
 * @package spec\App\Application\Command\User\SignUp
 */
interface UserEventRepositoryInterface
{
    public function store(User $user);

    public function get(UserId $userId): ?User;
}
