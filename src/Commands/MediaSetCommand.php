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

    protected $no_arguments = true;

    protected function execute($input, $output): int
    {
        $command = $this->getApplication()->find('vendor:component-media:ext:admin');
        $command->run(new ArrayInput(['name' => 'MediaAdmin']), $output);

        $command = $this->getApplication()->find('vendor:component-media:ext:config');
        $command->run(new ArrayInput(['name' => 'MediaConfig']), $output);

        $command = $this->getApplication()->find('vendor:component-media:ext:block');
        $command->run(new ArrayInput(['name' => 'MediaBlock']), $output);

        $command = $this->getApplication()->find('vendor:component-media:ext:segment');
        $command->run(new ArrayInput(['name' => 'MediaSegment']), $output);

        $command = $this->getApplication()->find('vendor:component-media:config');
        $command->run(new ArrayInput(['name' => 'component-media']), $output);

        $command = $this->getApplication()->find('vendor:component-media:templates');
        $command->run(new ArrayInput([]), $output);

        return Command::SUCCESS;
    }
}
