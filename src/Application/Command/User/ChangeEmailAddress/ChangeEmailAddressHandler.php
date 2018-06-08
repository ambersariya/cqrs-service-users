<?php

declare(strict_types=1);

namespace App\Application\Command\User\ChangeEmailAddress;

use App\Domain\User\Repository\UserEventRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\ValueObject\Auth\Credentials;
use Exception;
use const Fpp\dump;
use Psr\Log\LoggerInterface;

class ChangeEmailAddressHandler
{
    /**
     * @var UserEventRepositoryInterface
     */
    public $userRepository;
    /**
     * @var LoggerInterface
     */
    public $logger;

    public function __construct(UserEventRepositoryInterface $userRepository, LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->logger = $logger;
    }

    public function __invoke(ChangeEmailAddressCommand $changeEmailAddressCommand)
    {


        /** @var User $user */
        $user = $this->userRepository->get($changeEmailAddressCommand->userId());
        if (!$user) {
            throw new Exception('User not found');
        }

        $user->changeCredentials(
            $changeEmailAddressCommand->userId(),
            New Credentials($changeEmailAddressCommand->email(), $user->credentials->hashedPassword())
        );

        $this->userRepository->store($user);
    }
}