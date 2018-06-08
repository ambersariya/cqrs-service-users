<?php

namespace spec\App\Domain\User\ValueObject\Auth;

use App\Domain\ValueObject\Auth\Credentials;
use App\Domain\ValueObject\Auth\HashedPassword;
use App\Domain\ValueObject\Email;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CredentialsSpec extends ObjectBehavior
{
    private $email;
    private $hashedPassword;
    function it_is_initializable()
    {
        $this->shouldHaveType(Credentials::class);
    }

    function let()
    {
        $this->email = Email::fromString('bob@test.com');
        $this->hashedPassword = HashedPassword::encode('password123');
        $this->beConstructedWith($this->email, $this->hashedPassword);
    }
}
