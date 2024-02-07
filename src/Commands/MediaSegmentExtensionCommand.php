<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;

#[AsCommand(name: 'vendor:component-media:ext:segment')]
class MediaSegmentExtensionCommand extends GeneratorCommand
{
    protected static $defaultName = 'vendor:component-media:ext:segment';

    protected $description = 'Create MediaSegment extension';

    protected $path = '[psr4]/Extensions';

    protected $type = 'extension';

    protected $stub = './stubs/mediasegment-extension.stub';

    protected $suffix = 'Extension';
}
