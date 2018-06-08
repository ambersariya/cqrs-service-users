<?php

declare(strict_types=1);

namespace App\Domain\User\Event\ChangedEmailAddress;

use const Fpp\dump;
use Psr\Log\LoggerInterface;

class ChangedEmailAddressEventHandler
{
    /**
     * @var LoggerInterface
     */
    public $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function _invoke(ChangedEmailAddressEvent $event)
    {
        $this->logger->info($event->messageName());
        // send email
        // notify some other service
    }
}