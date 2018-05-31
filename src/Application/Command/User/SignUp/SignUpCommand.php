<?php

namespace App\Application\Command\User\SignUp;

use App\Domain\User\ValueObject\Auth\Credentials;
use App\Domain\User\ValueObject\Auth\HashedPassword;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use Ramsey\Uuid\Uuid;

class SignUpCommand
{
    /**
     * @var string
     */
    public $uuid;
    /**
     * @var Credentials
     */
    public $credentials;
    /**
     * @var Name
     */
    public $name;

    public function __construct(string $uuid, string $email, string $password, string $firstname, string $lastname)
    {
        $this->uuid = Uuid::fromString($uuid);
        $this->credentials = new Credentials(Email::fromString($email), HashedPassword::encode($password));
        $this->name = Name::fromString($firstname, $lastname);
    }
}
