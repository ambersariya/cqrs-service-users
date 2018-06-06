<?php

declare(strict_types=1);

namespace App\UI\Cli\Query;


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
    }
}