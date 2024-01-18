<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'vendor:component-media:mediaconfig')]
class MediaConfigExtensionCommand extends GeneratorCommand
{
    protected static $defaultName = 'vendor:component-media:mediaconfig';

    protected $description = 'Create MediaConfig extension';

    protected $path = '[psr4]/Extensions';

    protected $type = 'component-media config extension';

    protected $stub = 'mediaconfig-extension.stub';

    protected $prefix = 'Extension';

    protected function execute($input, $output): int
    {
        parent::execute($input, $output);

        return Command::SUCCESS;
    }
}
