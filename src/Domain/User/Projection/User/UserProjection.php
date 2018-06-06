<?php

declare(strict_types=1);

namespace App\Domain\User\Projection\User;

use App\Domain\User\Event\UserWasCreated\UserWasCreatedEvent;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;

class UserProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStream('user')
            ->when([
                UserWasCreatedEvent::class => function ($state, UserWasCreatedEvent $event) {
                    /** @var UserReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack('insert', [
                        'id' => $event->userId()->toString(),
                        'first_name' => $event->name()->firstname(),
                        'last_name' => $event->name()->lastname(),
                        'email' => $event->credentials()->email()->toString(),
                        'password' => $event->credentials()->hashedPassword()->toString(),
                    ]);
                },
            ]);

        return $projector;
    }
}