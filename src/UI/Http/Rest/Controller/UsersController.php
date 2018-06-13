<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller;

use App\Application\Command\ChangeEmailAddress\ChangeEmailAddressCommand;
use App\Application\Command\SignUp\SignUpCommand;
use App\Application\Query\GetAllUsers\GetAllUsers;
use App\Domain\Exception\UserAlreadyExistsException;
use App\Domain\Projection\UserReadModel;
use App\Domain\UserId;
use App\Domain\ValueObject\Email;
use App\UI\Http\Rest\Exception\ApiProblem;
use App\UI\Http\Rest\Exception\ApiProblemException;
use Prooph\EventStore\Exception\ConcurrencyException;
use Prooph\ServiceBus\CommandBus;
use Prooph\ServiceBus\Exception\CommandDispatchException;
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

        if ($data === null) {
            throw ApiProblemException::with(new ApiProblem(400, 'JSON payload is invalid'));
        }

        try {
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

            return new Response(null, Response::HTTP_CREATED);

        } catch (CommandDispatchException $exception) {

            if ($exception->getPrevious() instanceof ConcurrencyException) {
                $message = sprintf('User already exists with id %s', $data['id']);
            }

            if ($exception->getPrevious() instanceof UserAlreadyExistsException) {
                $message = sprintf('User already exists with email %s', $data['id']);
            }

            throw ApiProblemException::with(new ApiProblem(JsonResponse::HTTP_CONFLICT, $message));

        } catch (\Exception $exception) {
            throw ApiProblemException::with(new ApiProblem(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, $exception->getMessage()));
        }
    }

    public function updateUserAction(Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);

        if ($data === null) {
            throw ApiProblemException::with(new ApiProblem(400, 'JSON payload is invalid'));
        }

        /** @var CommandBus $commandBus */
        $commandBus = $this->container->get('prooph_service_bus.user_command_bus');
        $command = ChangeEmailAddressCommand::with(
            UserId::fromString($data['id']),
            Email::fromString($data['email'])
        );

        $commandBus->dispatch($command);

        return new JsonResponse(null);
    }

    public function meAction()
    {
        $json = $this->container->get('jms_serializer')
            ->serialize($this->getUser(), 'json');

        return new JsonResponse($json, JsonResponse::HTTP_OK);
    }

    public function getUserAction(string $id)
    {
        return new JsonResponse();
    }
}