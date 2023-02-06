<?php

namespace App\Command;

use App\Controller\ProductOptionScraper;
use App\Service\Scraper\AcmeScraperService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:scrape-product-options',
    description: 'Scrapes product options',
    aliases: ['app:scrape-product-options'],
    hidden: false
)]

class ProductOptionsScraperCommand extends Command
{
    protected function configure(): void
    {
        $this->setDescription('Scrapes product options from a website and outputs the results as JSON');

        $this
            ->addArgument('company', InputArgument::REQUIRED, 'What company you want to scrape?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $company = $input->getArgument('company');

        if (strtolower($company) == 'acme') {
            $scraper = new ProductOptionScraper(new AcmeScraperService());
            $options = $scraper->scrape();

            $output->write(json_encode($options, JSON_PRETTY_PRINT));

            return Command::SUCCESS;
        }

        $output->write(json_encode(['error' => 'Company: ' . $company . ' - Not implemented'], JSON_PRETTY_PRINT));

        return Command::FAILURE;
    }
}
