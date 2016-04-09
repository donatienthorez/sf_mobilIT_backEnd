<?php

namespace MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportSectionsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('main:import-sections')
            ->setDescription('Import the sections from the sections.json file')
            ->addOption(
                'country',
                '--country',
                InputOption::VALUE_OPTIONAL,
                'Specify a country and it will update all his sections'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Please wait ...');

        $dispatcher = $this->getContainer()->get('event_dispatcher');

        $dispatcher->addListener(
            'display.message',
            function (GenericEvent $event) use ($output) {
                $output->writeLn($event->getSubject());
            }
        );

        $this
            ->getContainer()
            ->get('main.import_sections.service')
            ->importSections($input->getOption("country"));

        $output->writeln('SUCCESSFULL ! All the sections are updated.');
    }
}
