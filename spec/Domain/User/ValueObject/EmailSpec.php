<?php

namespace spec\App\Domain\User\ValueObject;

use App\Domain\User\ValueObject\Email;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmailSpec extends ObjectBehavior
{
    private $email = 'email@example.org';

    function it_is_initializable()
    {
        $this->shouldHaveType(Email::class);
    }

    function let()
    {
        $this->beConstructedThrough('fromString', [$this->email]);
    }

    function it_should_have_email_field_set()
    {
        $this->toString()->shouldBeEqualTo($this->email);
        $this->__toString()->shouldBeEqualTo($this->email);
    }

    function it_should_throw_an_exception_when_email_is_invalid()
    {
        $this->shouldThrow(\InvalidArgumentException::class)->duringFromString('test');
    }
}
