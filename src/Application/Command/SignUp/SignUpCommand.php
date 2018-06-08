<?php

namespace App\Application\Command\SignUp;

use App\Domain\UserId;
use App\Domain\ValueObject\Auth\Credentials;
use App\Domain\ValueObject\Auth\HashedPassword;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Name;
use Assert\Assertion;
use Prooph\Common\Messaging\Command;
use Prooph\Common\Messaging\PayloadConstructable;
use Prooph\Common\Messaging\PayloadTrait;

class SignUpCommand extends Command implements PayloadConstructable
{
    use PayloadTrait;

    public static function with(string $userId, string $email, string $password, string $firstname, string $lastname): SignUpCommand
    {
        return new self([
            'user_id' => $userId,
            'name' => [
                'first_name' => $firstname,
                'last_name' => $lastname,
            ],
            'credentials' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);
    }

    public function userId(): UserId
    {
        return UserId::fromString($this->payload['user_id']);
    }

    public function name(): Name
    {
        return Name::fromString($this->payload['name']['first_name'], $this->payload['name']['last_name']);
    }

    public function email(): Email
    {
        return Email::fromString($this->payload['credentials']['email']);
    }

    public function credentials(): Credentials
    {
        return new Credentials(
            $this->email(),
            $this->password()
        );
    }

    protected function setPayload(array $payload): void
    {
        Assertion::keyExists($payload, 'user_id');
        Assertion::uuid($payload['user_id']);
        Assertion::keyExists($payload, 'name');

        Assertion::isArray($payload['name']);
        Assertion::keyExists($payload['name'], 'first_name');
        Assertion::string($payload['name']['first_name']);

        Assertion::keyExists($payload['name'], 'last_name');
        Assertion::string($payload['name']['last_name']);

        Assertion::keyExists($payload, 'credentials');
        Assertion::isArray($payload['credentials']);

        Assertion::keyExists($payload['credentials'], 'email');
        Assertion::string($payload['credentials']['email']);

        Assertion::keyExists($payload['credentials'], 'password');
        Assertion::string($payload['credentials']['password']);
        Assertion::minLength($payload['credentials']['password'], 6);

        $this->payload = $payload;
    }

    public function password()
    {
        return HashedPassword::encode($this->payload['credentials']['password']);
    }
}
