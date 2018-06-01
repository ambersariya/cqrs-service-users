<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;


use Prooph\ServiceBus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SignUpCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:sign-up')->setDescription('Signs a user up')->setHelp('no help for you');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        /** @var CommandBus $commandBus */
        $commandBus = $this->getContainer()->get('prooph_service_bus.user_command_bus');

        $command = \App\Application\Command\User\SignUp\SignUpCommand::withData('c92978c8-9ff5-44db-9dbc-11e73ef2da27', 'bob@test.com', 'password123',
            'bob', 'thebuilder');
        $commandBus->dispatch($command);

        // outputs a message followed by a "\n"
        $output->writeln('Whoa!');
    }
}
