<?php

namespace App\Tests\Unit\Service;

use App\Service\Scraper\AcmeScraperService;
use DOMDocument;
use DOMXPath;
use PHPUnit\Framework\TestCase;

class AcmeScraperServiceTest extends TestCase
{

    public function testGetTitle()
    {
        $html = <<<HTML
         <section id="subscriptions">
                <h3>Product 1</h3>
                <h3>Product 2</h3>
         </section>
    HTML;

        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'HTML5 is not supported by libxml2, therefore any HTML5 - eg. section tag will fail.'
        );

    }

    public function testGetDescription()
    {
        $html = <<<'HTML'
        <div class="package-description">
            Description 1
        </div>
        <div class="package-description">
            Description 2
        </div>
        HTML;

        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $xpath = new DOMXPath($dom);

        $scraper = new AcmeScraperService();
        $result1 = $scraper->getDescription($xpath, 0);
        $result2 = $scraper->getDescription($xpath, 1);

        $this->assertStringContainsString("Description 1", $result1);
        $this->assertStringContainsString("Description 2", $result2);
    }

    public function testGetPrice()
    {
        $html = '<div class="package-price">
                 <span class="price-big">£5.99</span>
                 <br>(inc. VAT)<br>Per Month
                 </div>';
        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new DOMXPath($dom);
        $packagePrices = $xpath->query("//div[@class='package-price']");

        $scraper = new AcmeScraperService();
        $result = $scraper->getPrice($xpath, $packagePrices, 0);

        $this->assertEquals(5.99, $result);
    }

    public function testGetDiscountReturnsCorrectDiscount()
    {
        // Set up the input
        $html = '<html><body>
                  <div class="package-prices">
                    <p style="color: red">Save £10</p>
                  </div>
                  </body></html>';
        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));
        $xpath = new DOMXPath($dom);

        $packagePrices = $xpath->query("//div[@class='package-prices']");

        // Create an instance of the class being tested
        $scraper = new AcmeScraperService();

        // Call the method being tested
        $discount = $scraper->getDiscount($xpath, $packagePrices, 0);

        // Assert that the correct discount is returned
        $this->assertEquals(10.0, $discount);
    }
}
