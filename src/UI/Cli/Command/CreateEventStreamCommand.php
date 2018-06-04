<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;

use Prooph\EventStore\EventStore;
use Prooph\EventStore\Stream;
use Prooph\EventStore\StreamName;
use Prooph\ServiceBus\Exception\CommandDispatchException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateEventStreamCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('event-store:event-stream:create')
            ->setDescription('Create event_stream.')
            ->setHelp('This command creates the user event stream');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        try {
            /** @var EventStore $eventStore */
            $eventStore = $this->getContainer()->get('prooph_event_store.user_store');
            $streamName = 'user';
            $eventStore->create(new Stream(new StreamName($streamName), new \ArrayIterator([])));
            $output->writeln('<info>Event stream was created successfully.</info>');

        } catch (CommandDispatchException $ex) {
            $output->writeln(sprintf('<error>%s</error>'), $ex->getPrevious()->getMessage());
        } catch (\Throwable $error) {
            $output->writeln(sprintf('<error>%s</error>'), $error->getMessage());
        }
    }
}
