<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'vendor:component-media-mediablock')]
class MediaBlockExtensionCommand extends GeneratorCommand
{
    protected static $defaultName = 'vendor:component-media-mediablock';

    protected $description = 'Create MediaBlock extension';

    protected $path = '[psr4]/Extensions';

    protected $type = 'component-media block extension';

    protected $stub = 'mediablock-extension.stub';

    protected $prefix = 'Extension';

    protected function execute($input, $output): int
    {
        parent::execute($input, $output);

        return Command::SUCCESS;
    }
}
