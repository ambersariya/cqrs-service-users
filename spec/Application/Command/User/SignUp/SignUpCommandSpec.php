<?php

namespace spec\App\Application\Command\User\SignUp;

use App\Application\Command\User\SignUp\SignUpCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
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
        $uuid = '071bed1c-7351-40bc-ba2d-55102fe1e02f';
        $firstname = 'ali';
        $lastname = 'g';
        $this->beConstructedWith($uuid, $email, $password, $firstname, $lastname);
    }

    function it_should_have_essential_values_set()
    {
        $this->credentials->hashedPassword->match('password')->shouldBeEqualTo(true);
        $this->credentials->email->toString()->shouldBeEqualTo('email@example.org');
        $this->uuid->shouldHaveType(UuidInterface::class);
        $this->uuid->toString()->shouldBeEqualTo('071bed1c-7351-40bc-ba2d-55102fe1e02f');
    }
}
