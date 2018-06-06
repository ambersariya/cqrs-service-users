<?php

namespace App\Domain\User;

use App\Domain\User\Event\UserWasCreated\UserWasCreatedEvent;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Name;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

class User extends AggregateRoot
{
    /**
     * @var UserId
     */
    public $userId;
    public $credentials;
    public $name;

    public static function create(UserId $userId, Credentials $credentials, Name $name): self
    {
        $user = new self();
        $user->recordThat(UserWasCreatedEvent::withData($userId, $credentials, $name));

        return $user;
    }

    protected function whenUserWasCreated(UserWasCreatedEvent $event): void
    {
        $this->userId = $event->userId();
        $this->credentials = $event->credentials();
        $this->name = $event->name();
    }

    protected function aggregateId(): string
    {
        return $this->userId->toString();
    }

    /**
     * Apply given event
     *
     * @param AggregateChanged $e
     */
    protected function apply(AggregateChanged $e): void
    {
        $handler = $this->determineEventHandlerMethodFor($e);
        if (!method_exists($this, $handler)) {
            throw new \RuntimeException(sprintf(
                'Missing event handler method %s for aggregate root %s',
                $handler,
                get_class($this)
            ));
        }
        $this->{$handler}($e);
    }

    protected function determineEventHandlerMethodFor(AggregateChanged $e): string
    {
        $eventClass = str_replace('Event', '', array_slice(explode('\\', get_class($e)), -1));

        return 'when' . implode($eventClass);
    }
}