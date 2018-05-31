<?php

namespace App\Domain\User\Factory;

use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Domain\User\User;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Name;
use Ramsey\Uuid\UuidInterface;
use App\Domain\User\Repository\UserCollectionInterface;

/**
 * Class UserFactory
 * @package App\Domain\User\Factory
 */
class UserFactory
{
    private $userCollection;

    public function __construct(UserCollectionInterface $userCollection)
    {
        $this->userCollection = $userCollection;
    }

    public function create(UuidInterface $uuid, Credentials $credentials, Name $name): User
    {

        if ($this->userCollection->existsEmail($credentials->email)) {

            throw new UserAlreadyExistsException();
        }

        return User::create($uuid, $credentials, $name);

    }
}