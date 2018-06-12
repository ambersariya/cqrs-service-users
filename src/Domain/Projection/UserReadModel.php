<?php

declare(strict_types=1);

namespace App\Domain\Projection;

use App\Domain\Repository\UserReadModelRepositoryInterface;
use Prooph\EventStore\Projection\AbstractReadModel;
use Symfony\Component\Security\Core\User\UserInterface;

class UserReadModel extends AbstractReadModel implements UserInterface
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

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
        return ['ROLE_USER', 'ROLE_ADMIN'];
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}