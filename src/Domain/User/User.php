<?php

namespace App\Domain\User;

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


    public static function create(UuidInterface $uuid, Credentials $credentials, Name $name)
    {
        $user = new self();
//        $user->uuid = $uuid;
//        $user->credentials = $credentials;
//        $user->name = $name;
//        $user->recordThat(new UserWasCreated());

        return $user;
    }

    protected function whenUserWasCreated(): void
    {

    }

    protected function aggregateId(): string
    {
        return $this->uuid->toString();
    }

    /**
     * Apply given event
     */
    protected function apply(AggregateChanged $event): void
    {
        // TODO: Implement apply() method.
    }
}