<?php

namespace spec\App\Application\Command\User\SignUp;

use App\Application\Command\User\SignUp\SignUpCommand;
use App\Application\Command\User\SignUp\SignUpHandler;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Ramsey\Uuid\UuidInterface;

class SignUpHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SignUpHandler::class);
    }

    function let(
        UserRepositoryInterface $userRepository,
        UserFactory $userFactory
    ) {
        $this->beConstructedWith($userRepository, $userFactory);
    }

    public function it_should_handle_user_signup_command_on_invocation(
        UserRepositoryInterface $userRepository,
        UserFactory $userFactory,
        User $user
    ) {
        $email = 'test@example.org';
        $password = 'test1234';
        $firstname = 'alice';
        $lastname = 'test';

        $signUpCommand = new SignUpCommand('385af148-f046-4697-ba0f-61f76e69dc10', $email, $password, $firstname, $lastname);

        $userFactory->create(
            Argument::type(UuidInterface::class),
            Argument::type(Credentials::class),
            Argument::type(Name::class)
        )->shouldBeCalled()->willReturn($user);

        $userRepository->store($user)->shouldBeCalled();

        $this($signUpCommand)->shouldReturn(null);
    }
}
