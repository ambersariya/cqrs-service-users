<?php

namespace App\Domain\ValueObject;

class Name
{
    public $firstname;
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

    public function toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function firstname(): string
    {
        return $this->firstname;
    }

    public function lastname(): string
    {
        return $this->lastname;
    }
}
