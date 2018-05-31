<?php

namespace spec\App\Domain\User;

use App\Domain\User\User;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Auth\HashedPassword;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserSpec extends ObjectBehavior
{
    function let()
    {
        $uuid = Uuid::fromString('cd480598-489a-4255-953d-925493b6c9f3');
        $credentials = new Credentials(Email::fromString('test@bob.com'), HashedPassword::encode('password123'));
        $name = Name::fromString('bob', 'the builder');
        $this->beConstructedThrough('create', [$uuid, $credentials, $name]);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }


//    function it_should_have_email()
//    {
//        $this->credentials->email->toString()->shouldBeEqualTo('test@bob.com');
//    }
//    function it_should_have_hashedpassword()
//    {
//        $this->credentials->hashedPassword->toString()->shouldNotBeEqualTo('password123');
//    }
//    function it_should_have_name()
//    {
//        $this->name->toString()->shouldBeEqualTo('bob the builder');
//    }
//    function it_should_have_uuid()
//    {
//        $this->uuid->toString()->shouldBeEqualTo('cd480598-489a-4255-953d-925493b6c9f3');
//    }
}
