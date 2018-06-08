<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Query\MySql;

use App\Domain\User\Projection\User\UserReadModel;
use App\Domain\User\Repository\UserReadModelRepositoryInterface;
use App\Domain\User\ValueObject\Email;
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
}