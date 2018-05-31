<?php

namespace spec\App\Domain\User\Event;

use App\Domain\User\Event\UserWasCreated;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Auth\HashedPassword;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserWasCreatedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserWasCreated::class);
    }

    function let()
    {
        $uuid = Uuid::fromString('cd480598-489a-4255-953d-925493b6c9f3');
        $credentials = new Credentials(Email::fromString('test@bob.com'), HashedPassword::encode('password123'));
        $name = Name::fromString('bob', 'the builder');
        $this->beConstructedThrough('withData', [$uuid, $credentials, $name]);
    }
}
