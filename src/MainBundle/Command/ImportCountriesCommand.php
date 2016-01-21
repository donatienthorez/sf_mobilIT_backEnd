<?php

namespace MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCountriesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('main:import-countries')
            ->setDescription('Import the countries from the countries.json file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Please wait...");
        $this
            ->getContainer()
            ->get('main.import_countries.service')
            ->importCountries();
        $output->writeln("SUCCESSFULL ! The countries are imported.");
    }
}
