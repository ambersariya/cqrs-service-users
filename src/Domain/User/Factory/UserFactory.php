<?php

namespace App\Domain\User\Factory;

use App\Domain\User\User;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Name;
use Ramsey\Uuid\UuidInterface;

/**
 * Class UserFactory
 * @package App\Domain\User\Factory
 */
class UserFactory
{
    public function create(UuidInterface $uuid, Credentials $credentials, Name $name): User
    {
    }
}