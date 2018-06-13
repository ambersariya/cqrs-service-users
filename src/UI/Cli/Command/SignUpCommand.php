<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use App\Application\Command\SignUp\SignUpCommand as CreateUser;
use App\Domain\UserId;
use Prooph\ServiceBus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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

        $faker = \Faker\Factory::create();

        /** @var CommandBus $commandBus */
        $commandBus = $this->getContainer()->get('prooph_service_bus.user_command_bus');
        $userId = UserId::generate();
        $password = $faker->password(6);
        $email = $faker->email;
        $firstname = $faker->firstName;
        $lastName = $faker->lastName;
        $output->writeln(sprintf('<info>Email: %s</info>', $email));
        $output->writeln(sprintf('<info>Plaintext Password: %s</info>', $password));
        $output->writeln(sprintf('<info>First Name: %s</info>', $firstname));
        $output->writeln(sprintf('<info>Last Name: %s</info>', $lastName));
        $command = CreateUser::with(
            $userId->toString(),
            $email,
            $password,
            $firstname,
            $lastName
        );

        $commandBus->dispatch($command);

        $output->writeln('OK');
    }
}
