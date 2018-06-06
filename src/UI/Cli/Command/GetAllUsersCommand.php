<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;


use Prooph\EventStore\Projection\ProjectionManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetAllUsersCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this->setName('app:users:all')
            ->setHelp('Fetches all users from event store');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Fetching all users');

        /** @var ProjectionManager $projectionManager */
        $projectionManager = $this->getContainer()->get(ProjectionManager::class);
        $allUsersProjection = $projectionManager->createProjection('all_users');

        $allUsersProjection->fromStream('user')->run(false);
    }
}