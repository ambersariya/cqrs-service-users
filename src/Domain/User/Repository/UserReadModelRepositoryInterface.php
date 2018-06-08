<?php

declare(strict_types=1);

namespace App\Domain\User\Repository;


use App\Domain\User\Projection\User\UserReadModel;

interface UserReadModelRepositoryInterface
{
    public function existsEmail(string $email): bool;

    public function save(UserReadModel $user): void;

    public function deleteAll(): void;

    public function get(string $id): UserReadModel;

    public function findAll(): array;
}