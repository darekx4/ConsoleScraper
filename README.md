Console Scraper
=====
[![License: MIT](https://img.shields.io/badge/License-MIT-limegreen.svg)](https://opensource.org/licenses/MIT)
[![Fee Calculation](https://github.com/darekx4/symfony-console-scraper/actions/workflows/symfony.yml/badge.svg)](https://github.com/darekx4/symfony-console-scraper/actions/workflows/symfony.yml)

The goal of the project is to build a console application that scrapes the following website
url https://wltest.dns-systems.net/ and returns a JSON array of all the product options on the page.

Each element in the JSON results array should contain 'option title', 'description', 'price' and
'discount' keys corresponding to items in the table. The items should be ordered by annual price
with the most expensive package first.

## Tech

Symfony 6.2, PHP 8.1

## Requirements
```
>= PHP 8.1
```

## Installation
```
composer install
```

## Testing
```
composer test
```

## Usage
```
php bin/console app:scrape-product-options Acme
```

## Expected result
```
[
    {
        "title": "Basic: 500MB Data - 12 Months",
        "description": "Up to 500MB of data per monthincluding 20 SMS(5p \/ MB data and 4p \/ SMS thereafter)",
        "price": 5.99,
        "discount": 0
    },
   ....
]
```
## Troubleshooting

If you see following output in console:
```
{
    "error": "Company: Foo - Not implemented"
}
```
You have most likely used company name which is currently not supported by scraper

```
php bin/console app:scrape-product-options Foo

```