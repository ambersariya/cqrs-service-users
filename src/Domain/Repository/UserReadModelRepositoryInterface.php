<?php

declare(strict_types=1);

namespace App\Domain\Repository;


use App\Domain\Projection\UserReadModel;

interface UserReadModelRepositoryInterface
{
    public function existsEmail(string $email): bool;

    public function save(UserReadModel $user): void;

    public function deleteAll(): void;

    public function get(string $id): UserReadModel;

    public function findAll(): array;
}