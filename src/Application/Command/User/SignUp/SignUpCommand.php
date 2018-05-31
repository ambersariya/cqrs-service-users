<?php

namespace App\Application\Command\User\SignUp;

use App\Domain\User\UserId;
use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Auth\HashedPassword;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;

class SignUpCommand
{
    /**
     * @var UserId
     */
    public $userId;
    /**
     * @var Credentials
     */
    public $credentials;
    /**
     * @var Name
     */
    public $name;

    public function __construct(string $userId, string $email, string $password, string $firstname, string $lastname)
    {
        $this->userId = UserId::fromString($userId);
        $this->credentials = new Credentials(Email::fromString($email), HashedPassword::encode($password));
        $this->name = Name::fromString($firstname, $lastname);
    }
}
