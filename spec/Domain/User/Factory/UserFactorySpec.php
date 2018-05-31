<?php

namespace spec\App\Domain\User\Factory;

use App\Domain\User\Exception\UserAlreadyExistsException;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserCollectionInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Auth\HashedPassword;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use PhpSpec\ObjectBehavior;

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

    function it_should_return_user_object(Credentials $credentials, UserCollectionInterface $userCollection)
    {
        $userId = UserId::fromString('cd480598-489a-4255-953d-925493b6c9f3');
        $credentials->email = Email::fromString('test@bob.com');
        $credentials->hashedPassword = HashedPassword::encode('bob.com');
        $name = Name::fromString('bob', 'the builder');
        $userCollection->existsEmail($credentials->email)->shouldBeCalled()->willReturn(false);

        $this->create($userId, $credentials, $name)->shouldBeAnInstanceOf(User::class);
    }

    function it_should_throw_exception_if_user_already_exists(
        UserId $userId,
        Credentials $credentials,
        Name $name,
        UserCollectionInterface $userCollection
    ) {
        $credentials->email = Email::fromString('test@bob.com');
        $userCollection->existsEmail($credentials->email)->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(UserAlreadyExistsException::class)->duringCreate($userId, $credentials, $name);
    }
}
