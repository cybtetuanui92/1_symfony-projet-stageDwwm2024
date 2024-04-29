<?php

namespace App\Command;

use App\Service\ImportCitiesService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:import-cities')]
class ImportCitiesCommand extends Command
{
    public function __construct(
        private ImportCitiesService $importCitiesService
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $this->importCitiesService->importCities($io);

        // Your logic here
        // $output->writeln('Importing cities...');

        // Always return an exit code. Return 0 for success and non-zero for an error.
        return Command::SUCCESS; // Command::SUCCESS is 0, and Command::FAILURE is 1, predefined constants in Symfony 5.3+
    }
}
