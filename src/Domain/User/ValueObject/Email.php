<?php

namespace App\Domain\User\ValueObject;

class Email
{
    /**
     * @var string
     */
    public $email;

    private function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Email is invalid');
        }

        $this->email = $email;
    }

    public static function fromString(string $email): self
    {
        return new Email($email);
    }

    public function toString()
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
