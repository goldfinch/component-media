<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'vendor:component-media:config')]
class MediaConfigCommand extends GeneratorCommand
{
    protected static $defaultName = 'vendor:component-media:config';

    protected $description = 'Create Media YML config';

    protected $path = 'app/_config';

    protected $type = 'config';

    protected $stub = './stubs/config.stub';

    protected $extension = '.yml';

    protected function execute($input, $output): int
    {
        parent::execute($input, $output);

        return Command::SUCCESS;
    }
}