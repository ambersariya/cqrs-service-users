<?php

namespace App\Domain\User;

use App\Domain\User\Event\UserWasCreated\UserWasCreatedEvent;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Name;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;
use Ramsey\Uuid\UuidInterface;

class User extends AggregateRoot
{
    /**
     * @var UuidInterface
     */
    public $uuid;
    public $credentials;
    public $name;
    
    public static function create(UuidInterface $uuid, Credentials $credentials, Name $name): self
    {
        $user = new self();
        $user->recordThat(UserWasCreatedEvent::withData($uuid, $credentials, $name));

        return $user;
    }

    protected function whenUserWasCreated(UserWasCreatedEvent $event): void
    {

        $this->uuid = $event->getUuid();
        $this->credentials = $event->getCredentials();
        $this->name = $event->getName();

    }

    protected function aggregateId(): string
    {
        return $this->uuid->toString();
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