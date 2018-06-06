<?php

namespace spec\App\Domain\User\Event\UserWasCreated;

use App\Domain\User\Event\UserWasCreated\UserWasCreatedEvent;
use App\Domain\User\UserId;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Auth\HashedPassword;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use PhpSpec\ObjectBehavior;

class UserWasCreatedEventSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserWasCreatedEvent::class);
    }

    function let()
    {
        $userId = UserId::fromString('cd480598-489a-4255-953d-925493b6c9f3');
        $credentials = new Credentials(
            Email::fromString('test@bob.com'),
            HashedPassword::encode('password123')
        );

        $name = Name::fromString('bob', 'the builder');
        $this->beConstructedThrough('withData', [$userId, $credentials, $name]);
    }

    function it_should_have_uuid()
    {
        $this->userId()->toString()->shouldBeEqualTo('cd480598-489a-4255-953d-925493b6c9f3');
    }

    function it_should_have_email()
    {
        $this->credentials()->email()->toString()->shouldBeEqualTo('test@bob.com');
    }

    function it_should_have_name()
    {
        $this->name()->toString()->shouldBeEqualTo('bob the builder');
    }
}
