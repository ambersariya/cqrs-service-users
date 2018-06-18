<?php

declare(strict_types=1);

namespace App\UI\Cli\Command;


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
        /**
         * @var \Enqueue\AmqpExt\AmqpContext\AmqpContext                  $context
         * @var \Symfony\Component\DependencyInjection\ContainerInterface $container
         */
        $context = $this->getContainer()->get('enqueue.transport.context');
        $queue = $context->createQueue('app_events');
        $context->declareQueue($queue);
        $message = $context->createMessage(json_encode(['hello' => 'world']));
        $context->createProducer()->send($queue, $message);
    }
}