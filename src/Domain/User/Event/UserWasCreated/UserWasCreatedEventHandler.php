<?php

declare(strict_types=1);

namespace App\Domain\User\Event\UserWasCreated;


use Monolog\Logger;
use Psr\Log\LoggerInterface;

class UserWasCreatedEventHandler
{
    /**
     * @var LoggerInterface
     */
    public $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function _invoke(UserWasCreatedEvent $userWasCreatedEvent)
    {
        $this->logger->info($userWasCreatedEvent->messageName());
    }
}