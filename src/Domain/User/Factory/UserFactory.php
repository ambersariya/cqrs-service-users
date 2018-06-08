<?php

namespace App\Domain\User\Factory;

use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Domain\User\Repository\UserEventRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Name;

/**
 * Class UserFactory
 * @package App\Domain\User\Factory
 */
class UserFactory
{
    private $userCollection;

    public function __construct(UserEventRepositoryInterface $userCollection)
    {
        $this->userCollection = $userCollection;
    }

    public function create(UserId $userId, Credentials $credentials, Name $name): User
    {
        if ($this->userCollection->existsEmail($credentials->email())) {
            throw new UserAlreadyExistsException(sprintf('User with email %s already exists', $credentials->email()));
        }

        return User::create($userId, $credentials, $name);
    }
}