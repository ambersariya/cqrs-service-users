<?php

namespace App\Domain\ValueObject\Auth;

use Assert\Assertion;

class HashedPassword
{
    const COST = 12;
    private $hashedPassword;

    private function __construct()
    {
    }

    public static function fromHash(string $hashedPassword): self
    {
        $pass = new self;

        $pass->hashedPassword = $hashedPassword;

        return $pass;
    }

    public static function encode($password): self
    {
        $hashedPassword = new self();
        $hashedPassword->validate($password);
        $hashedPassword->hash($password);

        return $hashedPassword;
    }

    private function hash($password)
    {
        $this->validate($password);
        $this->hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => self::COST]);
    }

    public function match($password)
    {
        return password_verify($password, $this->hashedPassword);
    }

    private function validate(string $raw): void
    {
        Assertion::minLength($raw, 6, 'Min 6 characters password');
    }

    public function toString(): string
    {
        return $this->hashedPassword;
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }
}
