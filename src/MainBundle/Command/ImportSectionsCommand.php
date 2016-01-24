<?php

namespace MainBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportSectionsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('main:import-sections')
            ->setDescription('Import the sections from the sections.json file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Please wait...");
        $this
            ->getContainer()
            ->get('main.import_sections.service')
            ->importSections();
        $output->writeln("SUCCESSFULL ! The sections are imported.");
    }
}
