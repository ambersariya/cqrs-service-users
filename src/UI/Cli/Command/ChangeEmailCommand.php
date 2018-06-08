<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use App\Application\Command\User\ChangeEmailAddress\ChangeEmailAddressCommand;
use App\Domain\User\UserId;
use App\Domain\User\ValueObject\Email;
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
        $userId = '28f1efe6-36e7-4f26-8ea7-ed76550bd9b6';
        $command = ChangeEmailAddressCommand::with(
            UserId::fromString($userId),
            Email::fromString('bob.builder2@example.org')
        );

        $commandBus->dispatch($command);
        $output->writeln('Whoa!');
    }
}
