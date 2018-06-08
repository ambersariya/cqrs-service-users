<?php

declare(strict_types=1);

namespace App\UI\Cli\Query;

use App\Application\Query\User\GetAllUsers\GetAllUsers;
use App\Domain\User\Projection\User\UserReadModel;
use Prooph\ServiceBus\QueryBus;
use React\Promise\Promise;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchUsers extends ContainerAwareCommand
{
    const NAME = 'app:users:fetch-all';

    protected function configure()
    {
        $this->setName(self::NAME)
            ->setDescription('Fetches all users');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Fetching all users from projection</info>');

        /** @var QueryBus $queryBus */
        $queryBus = $this->getContainer()->get('prooph_service_bus.read_users_query_bus');

        /** @var Promise $promise */
        $promise = $queryBus->dispatch(new GetAllUsers());
        $promise->done(function ($result) {
            /** @var UserReadModel $user */
            foreach ($result as $user) {
                dump($user->email);
            }
        }, function ($reason) {
            echo $reason . PHP_EOL;
        });
    }
}