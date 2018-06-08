<?php

declare(strict_types=1);

namespace App\Application\Command\ChangeEmailAddress;

use App\Domain\Repository\UserEventRepositoryInterface;
use App\Domain\User;
use App\Domain\ValueObject\Auth\Credentials;
use Exception;
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