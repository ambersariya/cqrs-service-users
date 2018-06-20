<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use Enqueue\Client\Message;
use Enqueue\Client\ProducerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendMessageCommand extends ContainerAwareCommand
{
    public function configure()
    {
        $this->setName('app:send-message');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ProducerInterface $producer * */
        $producer = $this->getContainer()->get(ProducerInterface::class);
        // send event to many consumers
        $producer->sendEvent('app_events', new Message('Something has happened'));
        $output->writeln('notified');
    }
}