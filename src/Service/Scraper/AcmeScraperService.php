<?php

namespace App\Service\Scraper;

use App\Model\Product;
use DOMDocument;
use DOMNodeList;
use DOMXPath;

class AcmeScraperService
{
    private const URL_TO_SCRAPE = 'https://wltest.dns-systems.net';

    public function proceed(): array
    {
        $dom = new DOMDocument();

        // Suppresses  Warning: DOMDocument::loadHTMLFile(): Tag header invalid in https://wltest.dns-systems.net, line: 81
        @$dom->loadHTMLFile(self::URL_TO_SCRAPE);
        $xpath = new DOMXPath($dom);

        $packageNames = $xpath->query("//div[@class='package-name']");
        $packagePrices = $xpath->query("//div[@class='package-price']");

        return array_map(function ($i) use ($xpath, $packagePrices) {
            $product = new Product();
            $product->title = $this->getTitle($xpath, $i);
            $product->description = $this->getDescription($xpath, $i);
            $product->price = $this->getPrice($xpath, $packagePrices, $i);
            $product->discount = $this->getDiscount($xpath, $packagePrices, $i);
            return $product;
        }, range(0, $packageNames->length - 1));
    }

    public function getTitle(DOMXPath $xpath, int $i): ?string
    {
        $title = $xpath->query("//section[@id='subscriptions']//h3");
        return $title->item($i)->nodeValue;
    }

    public function getDescription(DOMXPath $xpath, int $i): ?string
    {
        $description = $xpath->query("//div[@class='package-description']");
        return $description->item($i)->nodeValue;
    }

    public function getPrice(DOMXPath $xpath, DOMNodeList $packagePrices, int $i): float
    {
        $price = $xpath->query("./span[@class='price-big']", $packagePrices->item($i));
        return (float)str_replace("£", "", $price->item(0)->nodeValue);
    }

    public function getDiscount(DOMXPath $xpath, DOMNodeList $packagePrices, int $i): float
    {
        $discountElements = $xpath->query("./p[@style='color: red']", $packagePrices->item($i));
        if ($discountElements->count() > 0) {
            $discount = (float)str_replace('Save £', '', $discountElements->item(0)->nodeValue);
        }

        return $discount ?? (float)null;
    }
}
