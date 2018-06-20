<?php

declare(strict_types=1);

namespace App\Domain\Event\UserWasCreated;

use Enqueue\Client\ProducerInterface;
use Psr\Log\LoggerInterface;

class NotifyUserWasCreatedEventHandler
{
    /**
     * @var LoggerInterface
     */
    public $logger;
    /**
     * @var ProducerInterface
     */
    public $producer;

    public function __construct(LoggerInterface $logger, ProducerInterface $producer)
    {
        $this->logger = $logger;
        $this->producer = $producer;
    }

    public function __invoke(UserWasCreatedEvent $userWasCreatedEvent)
    {
        $this->producer->sendEvent('app_events', json_encode($userWasCreatedEvent->toArray()));
        $this->logger->debug('Notifying other services of user creation ', $userWasCreatedEvent->toArray());
    }
}