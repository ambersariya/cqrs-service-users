<?php

declare(strict_types=1);

namespace App\Domain\User;


use App\Domain\ValueObjectInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UserId implements ValueObjectInterface
{
    /**
     * @var UuidInterface
     */
    public $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function fromString(string $userId)
    {
        return new self(Uuid::fromString($userId));
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function equalTo(ValueObjectInterface $object): bool
    {
        return get_class($this) === get_class($object) && $this->uuid->equals($object->uuid);
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}