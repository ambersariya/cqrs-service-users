<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use App\Application\Command\User\SignUp\SignUpCommand as CreateUser;
use App\Domain\User\UserId;
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
        $command = CreateUser::withData(
            $userId->toString(),
            $faker->email,
            $faker->password(6),
            $faker->firstName,
            $faker->lastName
        );

        $commandBus->dispatch($command);
        $output->writeln('Whoa!');
    }
}
