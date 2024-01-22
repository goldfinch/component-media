<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;

#[AsCommand(name: 'vendor:component-media')]
class MediaSetCommand extends GeneratorCommand
{
    protected static $defaultName = 'vendor:component-media';

    protected $description = 'Set of all [goldfinch/component-media] commands';

    protected function execute($input, $output): int
    {
        $command = $this->getApplication()->find(
            'vendor:component-media:ext:admin',
        );
        $input = new ArrayInput(['name' => 'MediaAdmin']);
        $command->run($input, $output);

        $command = $this->getApplication()->find(
            'vendor:component-media:ext:config',
        );
        $input = new ArrayInput(['name' => 'MediaConfig']);
        $command->run($input, $output);

        $command = $this->getApplication()->find(
            'vendor:component-media:ext:block',
        );
        $input = new ArrayInput(['name' => 'MediaBlock']);
        $command->run($input, $output);

        $command = $this->getApplication()->find(
            'vendor:component-media:ext:segment',
        );
        $input = new ArrayInput(['name' => 'MediaSegment']);
        $command->run($input, $output);

        $command = $this->getApplication()->find('vendor:component-media:config');
        $input = new ArrayInput(['name' => 'component-media']);
        $command->run($input, $output);

        $command = $this->getApplication()->find('vendor:component-media:templates');
        $input = new ArrayInput([]);
        $command->run($input, $output);

        return Command::SUCCESS;
    }
}
