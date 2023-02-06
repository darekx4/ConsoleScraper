<?php

namespace App\Controller;

use App\Service\Scraper\AcmeScraperService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductOptionScraper extends AbstractController
{
    public function __construct(private readonly AcmeScraperService $service)
    {
    }

    public function scrape(): array
    {
        return $this->service->proceed();
    }
}
