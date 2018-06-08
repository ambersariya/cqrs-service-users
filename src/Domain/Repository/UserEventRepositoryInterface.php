<?php

namespace App\Domain\Repository;

use App\Domain\User;
use App\Domain\UserId;

/**
 * Interface UserRepositoryInterface
 * @package spec\App\Application\Command\User\SignUp
 */
interface UserEventRepositoryInterface
{
    public function store(User $user);

    public function get(UserId $userId): ?User;
}
