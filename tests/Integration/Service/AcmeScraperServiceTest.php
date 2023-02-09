<?php

namespace App\Tests\Integration\Service;

use App\Model\Product;
use App\Service\Scraper\AcmeScraperService;
use PHPUnit\Framework\TestCase;

class AcmeScraperServiceTest extends TestCase
{
    public function testExpectedNumberOfOptions(): void
    {
        $scraper = new AcmeScraperService();
        $options = $scraper->proceed();

        $this->assertCount(6, $options);
    }

    public function testCorrectDataForOption(): void
    {
        $scraper = new AcmeScraperService();
        $options = $scraper->proceed();

        $expected = new Product();
        $expected->title = 'Optimum: 24GB Data - 1 Year';
        $expected->description = 'Up to 12GB of data per year including 480 SMS(5p / MB data and 4p / SMS thereafter)';
        $expected->price = 174.0;
        $expected->discount = 17.9;

        $this->assertEquals($expected, $options[0]);
    }
}
