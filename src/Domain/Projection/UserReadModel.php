<?php

declare(strict_types=1);

namespace App\Domain\Projection;

use App\Domain\Repository\UserReadModelRepositoryInterface;
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
     * @var UserReadModelRepositoryInterface
     */
    public $userRepository;


    public function __construct(UserReadModelRepositoryInterface $userCollection)
    {
        $this->userRepository = $userCollection;
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
        $this->userRepository->deleteAll();
    }

    public function delete(): void
    {
        // TODO: throw an exception to tell the user to run migration down??
    }

    /**
     * @TODO: Refactor this!
     *
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

        $this->userRepository->save($user);
    }

    public function changeEmail(string $id, string $email)
    {
        $user = $this->userRepository->get($id);
        $user->email = $email;
        $user->updatedAt = new \DateTimeImmutable();

        $this->userRepository->save($user);
    }
}