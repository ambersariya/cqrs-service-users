<?php

namespace App\Domain\User\ValueObject\Auth;

use App\Domain\User\ValueObject\Email;

class Credentials
{
    /**
     * @var Email
     */
    public $email;
    /**
     * @var HashedPassword
     */
    public $hashedPassword;

    public function __construct(Email $email, HashedPassword $hashedPassword)
    {

        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }
}
