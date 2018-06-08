<?php

namespace spec\App\Domain\User\Factory;

use App\Domain\Exception\UserAlreadyExistsException;
use App\Domain\Factory\UserFactory;
use App\Domain\Repository\UserEventRepositoryInterface;
use App\Domain\User;
use App\Domain\UserId;
use App\Domain\ValueObject\Auth\Credentials;
use App\Domain\ValueObject\Auth\HashedPassword;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use PhpSpec\ObjectBehavior;

class UserFactorySpec extends ObjectBehavior
{
    function let(UserEventRepositoryInterface $userCollection)
    {
        $this->beConstructedWith($userCollection);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserFactory::class);
    }

    function it_should_return_user_object(UserEventRepositoryInterface $userCollection)
    {
        $userId = UserId::fromString('cd480598-489a-4255-953d-925493b6c9f3');
        $credentials = new Credentials(Email::fromString('test@bob.com'), HashedPassword::encode('bob.com'));
        $name = Name::fromString('bob', 'the builder');
        $userCollection->existsEmail($credentials->email())->shouldBeCalled()->willReturn(false);

        $this->create($userId, $credentials, $name)->shouldBeAnInstanceOf(User::class);
    }

    function it_should_throw_exception_if_user_already_exists(
        UserId $userId,
        Name $name,
        UserEventRepositoryInterface $userCollection
    ) {
        $credentials = new Credentials(Email::fromString('test@bob.com'), HashedPassword::encode('bob.com'));

        $userCollection->existsEmail($credentials->email())->shouldBeCalled()->willReturn(true);

        $this->shouldThrow(UserAlreadyExistsException::class)->duringCreate($userId, $credentials, $name);
    }
}
