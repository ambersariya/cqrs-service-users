<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller;

use App\Application\Query\GetAllUsers\GetAllUsers;
use App\Domain\Projection\UserReadModel;
use Prooph\ServiceBus\QueryBus;
use React\Promise\Promise;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends Controller
{
    public function allUsersAction()
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->container->get('prooph_service_bus.read_users_query_bus');
        /** @var Promise $promise */
        $promise = $queryBus->dispatch(new GetAllUsers());
        $response = null;
        $promise->done(function ($result) use (&$response) {
            /** @var UserReadModel $user */
            $response = $result;
        }, function ($reason) {
            echo $reason . PHP_EOL;
        });

        return $this->container->get('jms_serializer')
            ->serialize($response, 'json');
//        return new JsonResponse($data);
    }
}