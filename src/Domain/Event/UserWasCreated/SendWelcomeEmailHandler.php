<?php

declare(strict_types=1);

namespace App\Domain\Event\UserWasCreated;

use Psr\Log\LoggerInterface;

class SendWelcomeEmailHandler
{
    /**
     * @var LoggerInterface
     */
    public $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(UserWasCreatedEvent $userWasCreatedEvent)
    {
        $this->logger->info(sprintf('Danish - User was created. Sending email ...'));
    }
}