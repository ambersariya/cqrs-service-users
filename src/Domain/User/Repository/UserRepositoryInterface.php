<?php

namespace App\Domain\User\Repository;

use App\Domain\User\User;

/**
 * Interface UserRepositoryInterface
 * @package spec\App\Application\Command\User\SignUp
 */
interface UserRepositoryInterface
{
    public function store(User $user);
}
