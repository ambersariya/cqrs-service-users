<?php

namespace spec\App\Domain\User\ValueObject\Auth;

use App\Domain\ValueObject\Auth\HashedPassword;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HashedPasswordSpec extends ObjectBehavior
{
    private $password  = 'password123';
    private $hashedPassword;
    function it_is_initializable()
    {
        $this->shouldHaveType(HashedPassword::class);
    }

    function let()
    {
        $this->beConstructedThrough('encode', [$this->password]);
        $this->hashedPassword = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 12]);
    }

    function it_should_not_be_plain_text()
    {
        $this->toString()->shouldNotBeEqualTo($this->password);
    }

    function it_should_match_passwords()
    {
        $this->match($this->password)->shouldBeEqualTo(True);
    }
}
