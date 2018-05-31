<?php

namespace spec\App\Domain\User\Factory;

use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserCollectionInterface;
use App\Domain\User\User;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class UserFactorySpec extends ObjectBehavior
{
    function let(UserCollectionInterface $userCollection)
    {
        $this->beConstructedWith($userCollection);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(UserFactory::class);
    }

    function it_should_return_user_object(UuidInterface $uuid, Credentials $credentials, Name $name, UserCollectionInterface $userCollection)
    {
        $credentials->email = Email::fromString('test@bob.com');

        $userCollection->existsEmail($credentials->email)->shouldBeCalled()->willReturn(false);
        $this->create($uuid, $credentials, $name)->shouldBeAnInstanceOf(User::class);
    }

    function it_should_throw_exception_if_user_already_exists(UuidInterface $uuid, Credentials $credentials, Name $name, UserCollectionInterface $userCollection)
    {
        $credentials->email = Email::fromString('test@bob.com');

        $userCollection->existsEmail($credentials->email)->shouldBeCalled()->willReturn(true);
        $this->shouldThrow(UserAlreadyExistsException::class)->duringCreate($uuid, $credentials, $name);
    }
}
