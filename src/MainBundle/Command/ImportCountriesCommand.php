<?php

namespace MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCountriesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('main:import-countries')
            ->setDescription('Import the countries from the countries.json file')
            ->addArgument(
                'update',
                InputArgument::OPTIONAL,
                'Do you also want to update the content ?'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Please wait...");

        $update = $input->getArgument('update') ? true : false;

        $dispatcher = $this->getContainer()->get('event_dispatcher');

        $dispatcher->addListener(
            'display.message',
            function (GenericEvent $event) use ($output) {
                $output->writeLn($event->getSubject());
            }
        );

        $this
            ->getContainer()
            ->get('main.import_countries.service')
            ->importCountries($update);

        $output->writeln("SUCCESSFULL ! The countries are imported.");
    }
}
