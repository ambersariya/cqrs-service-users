<?php

namespace spec\App\Domain\User;

use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Auth\HashedPassword;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    function let()
    {
        $uuid = UserId::fromString('cd480598-489a-4255-953d-925493b6c9f3');
        $credentials = new Credentials(Email::fromString('test@bob.com'), HashedPassword::encode('password123'));
        $name = Name::fromString('bob', 'the builder');
        $this->beConstructedThrough('create', [$uuid, $credentials, $name]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }
}
