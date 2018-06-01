<?php

namespace App\Infrastructure\User\Repository;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use Prooph\EventSourcing\Aggregate\AggregateRepository;

class EventStoreUserCollection extends AggregateRepository implements UserRepositoryInterface
{
    public function store(User $user)
    {
        $this->saveAggregateRoot($user);
    }
}
