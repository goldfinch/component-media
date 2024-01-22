<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'vendor:component-media:ext:segment')]
class MediaSegmentExtensionCommand extends GeneratorCommand
{
    protected static $defaultName = 'vendor:component-media:ext:segment';

    protected $description = 'Create MediaSegment extension';

    protected $path = '[psr4]/Extensions';

    protected $type = 'component-media item extension';

    protected $stub = './stubs/mediasegment-extension.stub';

    protected $prefix = 'Extension';

    protected function execute($input, $output): int
    {
        parent::execute($input, $output);

        return Command::SUCCESS;
    }
}
