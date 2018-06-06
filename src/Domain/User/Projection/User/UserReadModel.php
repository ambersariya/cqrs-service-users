<?php

declare(strict_types=1);

namespace App\Domain\User\Projection\User;

use App\Domain\User\Repository\UserCollectionInterface;
use App\Domain\User\Repository\UserRepositoryInterface;
use Prooph\EventStore\Projection\AbstractReadModel;

class UserReadModel extends AbstractReadModel
{
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $password;
    public $createdAt;
    public $updatedAt;
    public $deletedAt;
    /**
     * @var UserRepositoryInterface
     */
    public $userRepository;
    /**
     * @var UserCollectionInterface
     */
    public $userCollection;

    public function __construct(UserCollectionInterface $userCollection)
    {
        $this->userCollection = $userCollection;
    }

    public function init(): void
    {

    }

    public function isInitialized(): bool
    {
        return true;
    }

    public function reset(): void
    {
        // TODO: Implement reset() method.
        $this->userCollection->deleteAll();
    }

    public function delete(): void
    {
        // TODO: throw an exception to tell the user to run migration down??
    }

    /**
     * @TODO: Refactor this!
     * @param $data
     *
     * @throws \Exception
     */
    public function insert($data)
    {
        $user = clone $this;
        $user->id = $data['id'];
        $user->firstName = $data['first_name'];
        $user->lastName = $data['last_name'];
        $user->email = $data['email'];
        $user->password = $data['password'];

        $user->createdAt = new \DateTimeImmutable();
        $user->updatedAt = new \DateTimeImmutable();

        $this->userCollection->save($user);
    }
}