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

        // Trying to check an uninstalled module.
        $this->drush('why', ['node'], [], null, null, 1);
        $this->assertStringContainsString('Invalid node module', $this->getErrorOutput());

        // Check also uninstalled modules.
        $this->drush('why', ['node'], ['no-only-installed' => null]);
        $expected = <<<EXPECTED
            node
            ┣━book
            ┣━forum
            ┣━history
            ┃ ┗━forum
            ┣━statistics
            ┣━taxonomy
            ┃ ┗━forum
            ┗━tracker
            EXPECTED;
        $this->assertSame($expected, $this->getOutput());

        // Install node module.
        $this->drush('pm:install', ['node']);

        // No installed dependencies.
        $this->drush('why', ['node']);
        $this->assertSame('[notice] No other module depends on node', $this->getErrorOutput());

        $this->drush('pm:install', ['forum']);
        $this->drush('why', ['node']);
        $expected = <<<EXPECTED
            node
            ┣━forum
            ┣━history
            ┃ ┗━forum
            ┗━taxonomy
              ┗━forum
            EXPECTED;
        $this->assertSame($expected, $this->getOutput());
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown(): void
    {
        $this->drush('entity:delete', ['taxonomy_term']);
        $this->drush('pmu', ['node,forum,taxonomy,history']);
        parent::tearDown();
    }
}
