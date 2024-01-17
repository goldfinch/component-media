<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'config:component-media')]
class ComponentMediaConfigCommand extends GeneratorCommand
{
    protected static $defaultName = 'config:component-media';

    protected $description = 'Create component-media config';

    protected $path = 'app/_config';

    protected $type = 'component-media yml config';

    protected $stub = 'mediaconfig.stub';

    protected $extension = '.yml';

    protected function execute($input, $output): int
    {
        parent::execute($input, $output);

        return Command::SUCCESS;
    }
}
