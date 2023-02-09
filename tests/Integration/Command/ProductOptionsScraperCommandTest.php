<?php

namespace App\Tests\Integration\Command;

use App\Command\ProductOptionsScraperCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Command\Command;

class ProductOptionsScraperCommandTest extends TestCase
{

    public function testCommandWorksWithSupportedCompany(): void
    {
        $application = new Application();
        $application->add(new ProductOptionsScraperCommand());

        $command = $application->find('app:scrape-product-options');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'company' => 'Acme'
        ]);

        // Assertions to check the output of the command
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
        $output = $commandTester->getDisplay();

        // It is valid json?
        $output = json_decode($output);
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE);

        // Do we have data?
        $this->assertStringContainsString("24GB Data", $output[0]->title);
    }

    public function testCommandWorksWithNoSupportedCompany(): void
    {
        $application = new Application();
        $application->add(new ProductOptionsScraperCommand());

        $command = $application->find('app:scrape-product-options');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'command' => $command->getName(),
            'company' => 'Foo'
        ]);

        // Assertions to check the output of the command
        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
        $output = $commandTester->getDisplay();

        // It is valid json?
        $output = json_decode($output);
        $this->assertTrue(json_last_error() === JSON_ERROR_NONE);

        // Do we have data?
        $this->assertStringContainsString("Company: Foo - Not implemented", $output->error);
    }
}
