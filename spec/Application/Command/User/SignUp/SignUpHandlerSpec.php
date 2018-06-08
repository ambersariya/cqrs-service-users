<?php

namespace spec\App\Application\Command\User\SignUp;

use App\Application\Command\User\SignUp\SignUpCommand;
use App\Application\Command\User\SignUp\SignUpHandler;
use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Repository\UserEventRepositoryInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SignUpHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SignUpHandler::class);
    }

    function let(
        UserEventRepositoryInterface $userRepository,
        UserFactory $userFactory
    ) {
        $this->beConstructedWith($userRepository, $userFactory);
    }

    public function it_should_handle_user_signup_command_on_invocation(
        UserEventRepositoryInterface $userRepository,
        UserFactory $userFactory,
        User $user
    ) {
        $email = 'test@example.org';
        $password = 'test1234';
        $firstname = 'alice';
        $lastname = 'test';
        $payload = [
            'user_id' => '071bed1c-7351-40bc-ba2d-55102fe1e02f',
            'name' => [
                'first_name' => $firstname,
                'last_name' => $lastname,
            ],
            'credentials' => [
                'email' => $email,
                'password' => $password,
            ],
        ];

        $signUpCommand = new SignUpCommand($payload);

        $userFactory->create(
            Argument::type(UserId::class),
            Argument::type(Credentials::class),
            Argument::type(Name::class)
        )->shouldBeCalled()->willReturn($user);

        $userRepository->store($user)->shouldBeCalled();

        $this($signUpCommand)->shouldReturn(null);
    }
}
