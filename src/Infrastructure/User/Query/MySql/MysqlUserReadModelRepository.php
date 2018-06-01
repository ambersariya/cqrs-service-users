<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Query\MySql;


use App\Domain\User\Repository\UserCollectionInterface;

class MysqlUserReadModelRepository implements UserCollectionInterface
{

    public function existsEmail($email): bool
    {
        // TODO: Implement existsEmail() method.
        return false;
    }
}