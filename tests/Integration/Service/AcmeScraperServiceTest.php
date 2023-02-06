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
        $expected->title = 'Basic: 500MB Data - 12 Months';
        $expected->description = 'Up to 500MB of data per monthincluding 20 SMS(5p / MB data and 4p / SMS thereafter)';
        $expected->price = 5.99;
        $expected->discount = 0.0;

        $this->assertEquals($expected, $options[0]);
    }
}
