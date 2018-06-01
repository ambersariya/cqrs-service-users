<?php

namespace spec\App\Infrastructure\User\Repository;

use App\Infrastructure\User\Repository\EventStoreUserCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventStoreUserCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EventStoreUserCollection::class);
    }
}
