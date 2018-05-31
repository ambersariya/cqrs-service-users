<?php

namespace App\Domain\User\Event\UserWasCreated;

use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Name;
use Prooph\EventSourcing\AggregateChanged;
use Ramsey\Uuid\UuidInterface;

class UserWasCreatedEvent extends AggregateChanged
{
    private $credentials;
    private $name;
    protected $uuid;

    public static function withData(UuidInterface $uuid, Credentials $credentials, Name $name): UserWasCreatedEvent
    {
        /** @var self $event */
        $event = self::occur($uuid->toString(), [
            'name' => $name->toString(),
            'credentials' => [
                'email' => $credentials->email->toString(),
                'password' => $credentials->hashedPassword->toString(),
            ],
        ]);

        $event->uuid = $uuid;
        $event->name = $name;
        $event->credentials = $credentials;

        return $event;
    }

    /**
     * @return mixed
     */
    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    /**
     * @return mixed
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

}