<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Query\MySql;

use App\Domain\Projection\UserReadModel;
use App\Domain\Repository\UserReadModelRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class MysqlUserReadModelRepository implements UserReadModelRepositoryInterface
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

    public function existsEmail(string $email): bool
    {
        $user = $this->entityManager->getRepository(UserReadModel::class)->findOneBy([
            'email' => $email,
        ]);

        return $user instanceof UserReadModel;
    }


    public function deleteAll(): void
    {
        // TODO: Implement deleteAll() method.
    }

    public function save(UserReadModel $obj): void
    {
        $this->entityManager->persist($obj);
        $this->entityManager->flush();
    }

    public function get(string $id): UserReadModel
    {
        return $this->entityManager->getRepository(UserReadModel::class)
            ->findOneBy([
                'id' => $id,
            ]);
    }

    public function findAll(): array
    {
        return $this->entityManager->getRepository(UserReadModel::class)->findAll();
    }
}