<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;

#[AsCommand(name: 'vendor:component-media:ext:block')]
class MediaBlockExtensionCommand extends GeneratorCommand
{
    protected static $defaultName = 'vendor:component-media:ext:block';

    protected $description = 'Create MediaBlock extension';

    protected $path = '[psr4]/Extensions';

    protected $type = 'extension';

    protected $stub = './stubs/mediablock-extension.stub';

    protected $prefix = 'Extension';
}
