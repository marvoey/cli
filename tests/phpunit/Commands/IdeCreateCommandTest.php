
<?php

namespace Acquia\Ads\Tests;

use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Tester\CommandTester;

class IdeCreateCommandTest extends CommandTestBase
{

    /**
     * Tests the 'lint' command.
     *
     * @dataProvider getValueProvider
     */
    public function testLint($file, $expected_output, $expected_exit_code): void
    {
        $this->application->add(new LintCommand());

        $command = $this->application->find('lint');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
          'command'  => $command->getName(),
          'filename' => $file
        ), ['verbosity' => Output::VERBOSITY_VERBOSE]);

        $output = $commandTester->getDisplay();
        $this->assertContains($expected_output, $output);
        $this->assertEquals($expected_exit_code, $commandTester->getStatusCode());
    }

    /**
     * Provides values to testLint().
     *
     * @return array
     *   An array of values to test.
     */
    public function getValueProvider()
    {

        return [
          ['tests/resources/good.yml', "The file tests/resources/good.yml contains valid YAML.", 0],
          ['tests/resources/bad.yml', "There was an error parsing tests/resources/bad.yml. The contents are not valid YAML.", 1],
          ['missing.yml', "The file missing.yml does not exist.", 1],
        ];
    }
}
