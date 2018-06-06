<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Query\MySql;

use App\Domain\User\Repository\UserCollectionInterface;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\ValueObject\Email;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class MysqlUserReadModelRepository implements UserCollectionInterface
{
    /** @var EntityRepository */
    protected $repository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get(UserId $userId): ?User
    {
        return $this->getAggregateRoot($userId->toString());
    }

    public function existsEmail(Email $email): bool
    {
        return false;
    }

    public function register($model): void
    {
        $this->entityManager->persist($model);
        $this->apply();
    }

    public function apply(): void
    {
        $this->entityManager->flush();
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function deleteAll(): void
    {
        // TODO: Implement deleteAll() method.
    }

    public function save($obj): void
    {
        $this->entityManager->persist($obj);
        $this->apply();
    }
}