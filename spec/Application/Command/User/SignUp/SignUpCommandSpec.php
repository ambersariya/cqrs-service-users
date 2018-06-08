<?php

namespace spec\App\Application\Command\User\SignUp;

use App\Application\Command\User\SignUp\SignUpCommand;
use App\Domain\UserId;
use PhpSpec\ObjectBehavior;
use Ramsey\Uuid\UuidInterface;

class SignUpCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SignUpCommand::class);
    }

    function let()
    {
        $password = 'password';
        $email = 'email@example.org';
        $userId = '071bed1c-7351-40bc-ba2d-55102fe1e02f';
        $firstname = 'ali';
        $lastname = 'g';
        $this->beConstructedWith([
            'user_id' => $userId,
            'name' => [
                'first_name' => $firstname,
                'last_name' => $lastname,
            ],
            'credentials' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);
    }

    function it_should_have_essential_values_set()
    {
        $this->credentials()->hashedPassword()->match('password')->shouldBeEqualTo(true);
        $this->credentials()->email()->toString()->shouldBeEqualTo('email@example.org');
        $this->userId()->shouldHaveType(UserId::class);
        $this->userId()->toString()->shouldBeEqualTo('071bed1c-7351-40bc-ba2d-55102fe1e02f');
    }
}
