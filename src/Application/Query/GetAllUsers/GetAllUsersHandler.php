<?php

declare(strict_types=1);

namespace App\Application\Query\GetAllUsers;

use App\Domain\Repository\UserReadModelRepositoryInterface;
use React\Promise\Deferred;

final class GetAllUsersHandler
{
    /**
     * @var UserReadModelRepositoryInterface
     */
    public $userReadModelRepository;

    public function __construct(UserReadModelRepositoryInterface $userReadModelRepository)
    {
        $this->userReadModelRepository = $userReadModelRepository;
    }

    public function __invoke(GetAllUsers $getAllUsers, Deferred $deferred)
    {
        $results = $this->userReadModelRepository->findAll();
        if (count($results)) {
            $deferred->resolve($results);
        } else {
            $deferred->reject("Out of luck");
        }
    }
}
