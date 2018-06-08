<?php

namespace App\Domain\Factory;

use App\Domain\Exception\UserAlreadyExistsException;
use App\Domain\Repository\UserReadModelRepositoryInterface;
use App\Domain\User;
use App\Domain\UserId;
use App\Domain\ValueObject\Auth\Credentials;
use App\Domain\ValueObject\Name;

/**
 * Class UserFactory
 * @package App\Domain\User\Factory
 */
class UserFactory
{
    private $userReadModelRepository;

    public function __construct(UserReadModelRepositoryInterface $userReadModelRepository)
    {
        $this->userReadModelRepository = $userReadModelRepository;
    }

    public function create(UserId $userId, Credentials $credentials, Name $name): User
    {
        if ($this->userReadModelRepository->existsEmail($credentials->email())) {
            throw new UserAlreadyExistsException(sprintf('User with email %s already exists', $credentials->email()));
        }

        return User::create($userId, $credentials, $name);
    }
}