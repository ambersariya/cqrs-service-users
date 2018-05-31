<?php

namespace App\Domain\User\Event\UserWasCreated;

use App\Domain\User\UserId;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Name;
use Prooph\EventSourcing\AggregateChanged;

class UserWasCreatedEvent extends AggregateChanged
{
    private $credentials;
    private $name;
    protected $userId;

    public static function withData(UserId $userId, Credentials $credentials, Name $name): UserWasCreatedEvent
    {
        /** @var self $event */
        $event = self::occur($userId->toString(), [
            'name' => $name->toString(),
            'credentials' => [
                'email' => $credentials->email->toString(),
                'password' => $credentials->hashedPassword->toString(),
            ],
        ]);

        $event->userId = $userId;
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
    public function getUserId(): UserId
    {
        return $this->userId;
    }
}