<?php

namespace App\Domain\User\ValueObject;

class Name
{
    public $firstname;
    /**
     * @var string
     */
    public $lastname;

    private function __construct(string $firstname, string $lastname)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public static function fromString(string $firstname, string $lastname)
    {
        $name = new Name($firstname, $lastname);

        return $name;
    }
}
