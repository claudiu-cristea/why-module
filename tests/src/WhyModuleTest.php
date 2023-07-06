<?php

namespace src;

use Drush\TestTraits\DrushTestTrait;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \Drupal\Drush\Commands\WhyModuleDrushCommands
 */
class WhyModuleTest extends TestCase
{
    use DrushTestTrait;

    /**
     * @covers ::why
     */
    public function testWhyModuleCommand(): void
    {
        $this->drush('list');
        $this->assertStringContainsString('pm:why-module (why)', $this->getOutput());
        $this->assertStringContainsString('List the all modules that depend on a given module', $this->getOutput());

        $this->drush('why', ['node']);
        $expected = <<<EXPECTED
            node
             ┣━book
             ┣━forum
             ┣━history
             ┃  ┗━forum
             ┣━statistics
             ┣━taxonomy
             ┃  ┗━forum
             ┗━tracker
            EXPECTED;
        $this->assertSame($expected, $this->getOutput());
    }
}
