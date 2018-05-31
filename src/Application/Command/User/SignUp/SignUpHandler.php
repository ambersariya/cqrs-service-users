<?php

namespace App\Application\Command\User\SignUp;

use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserRepositoryInterface;

class SignUpHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var UserFactory
     */
    private $userFactory;

    public function __construct(UserRepositoryInterface $userRepository, UserFactory $userFactory)
    {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
    }

    public function __invoke(SignUpCommand $signUpCommand): void
    {
        $aggregateRoot = $this->userFactory->create($signUpCommand->userId, $signUpCommand->credentials, $signUpCommand->name);
        $this->userRepository->store($aggregateRoot);
    }
}
