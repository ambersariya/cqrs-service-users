<?php

namespace App\Domain\ValueObject\Auth;

use App\Domain\ValueObject\Email;

class Credentials
{
    /**
     * @var Email
     */
    private $email;

    /**
     * @return Email
     */
    public function email(): Email
    {
        return $this->email;
    }

    /**
     * @return HashedPassword
     */
    public function hashedPassword(): HashedPassword
    {
        return $this->hashedPassword;
    }

    /**
     * @var HashedPassword
     */
    private $hashedPassword;

    public function __construct(Email $email, HashedPassword $hashedPassword)
    {
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }
}
