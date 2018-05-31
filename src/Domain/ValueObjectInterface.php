<?php

declare(strict_types=1);

namespace App\Domain;

interface ValueObjectInterface
{
    public function equalTo(ValueObjectInterface $object): bool;

    public function toString(): string;

    public function __toString(): string;
}