<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use App\Application\Command\ChangeEmailAddress\ChangeEmailAddressCommand;
use App\Domain\UserId;
use App\Domain\ValueObject\Email;
use Prooph\ServiceBus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeEmailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app:change-email')->setDescription('Signs a user up')->setHelp('no help for you');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'User Editor',
            '============',
            '',
        ]);

//        $faker = \Faker\Factory::create();
        /** @var CommandBus $commandBus */
        $commandBus = $this->getContainer()->get('prooph_service_bus.user_command_bus');
        $userId = 'b2ce9c68-1814-48c9-bd13-5293f3559f30';
        $command = ChangeEmailAddressCommand::with(
            UserId::fromString($userId),
            Email::fromString('bob.builder2@example.org')
        );

        $commandBus->dispatch($command);
        $output->writeln('Whoa!');
    }
}
