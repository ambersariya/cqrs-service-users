<?php

namespace spec\App\Domain\User\ValueObject;

use App\Domain\ValueObject\Name;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Name::class);
    }

    function let()
    {
        $this->beConstructedThrough('fromString', ['Bob', 'The Builder']);
    }

    function it_should_have_firstname_and_lastname_set()
    {
        $this->firstname->shouldBeEqualTo('Bob');
        $this->lastname->shouldBeEqualTo('The Builder');
    }
}
