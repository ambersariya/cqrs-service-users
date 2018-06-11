<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller;

use App\Application\Command\ChangeEmailAddress\ChangeEmailAddressCommand;
use App\Application\Command\SignUp\SignUpCommand;
use App\Application\Query\GetAllUsers\GetAllUsers;
use App\Domain\Projection\UserReadModel;
use App\Domain\UserId;
use App\Domain\ValueObject\Email;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\QueryBus;
use React\Promise\Promise;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

        $json = $this->container->get('jms_serializer')
            ->serialize($response, 'json');

        return new JsonResponse($json, JsonResponse::HTTP_OK, [], true);
    }

    public function newUserAction(Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);

        /** @var CommandBus $commandBus */
        $commandBus = $this->container->get('prooph_service_bus.user_command_bus');
        $command = SignUpCommand::with(
            $data['id'],
            $data['email'],
            $data['password'],
            $data['first_name'],
            $data['last_name']
        );

        $commandBus->dispatch($command);

        return new Response('', Response::HTTP_CREATED);
    }


    public function updateUserAction(Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);

        /** @var CommandBus $commandBus */
        $commandBus = $this->container->get('prooph_service_bus.user_command_bus');
        $command = ChangeEmailAddressCommand::with(
            UserId::fromString($data['id']),
            Email::fromString($data['email'])
        );

        $commandBus->dispatch($command);

        return new Response('', Response::HTTP_OK);
    }
}