<?php

namespace App\Application\Command\User\SignUp;

use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserEventRepositoryInterface;
use Psr\Log\LoggerInterface;

class SignUpHandler
{
    /**
     * @var LoggerInterface
     */
    public $logger;
    /**
     * @var UserEventRepositoryInterface
     */
    private $userRepository;
    /**
     * @var UserFactory
     */
    private $userFactory;

    public function __construct(UserEventRepositoryInterface $userRepository, UserFactory $userFactory, LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
        $this->logger = $logger;
    }

    public function __invoke(SignUpCommand $signUpCommand): void
    {
        $aggregateRoot = $this->userFactory->create($signUpCommand->userId(), $signUpCommand->credentials(), $signUpCommand->name());
        $this->userRepository->store($aggregateRoot);
    }
}
