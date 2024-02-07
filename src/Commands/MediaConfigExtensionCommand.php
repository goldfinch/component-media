<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;

#[AsCommand(name: 'vendor:component-media:ext:config')]
class MediaConfigExtensionCommand extends GeneratorCommand
{
    protected static $defaultName = 'vendor:component-media:ext:config';

    protected $description = 'Create MediaConfig extension';

    protected $path = '[psr4]/Extensions';

    protected $type = 'extension';

    protected $stub = './stubs/mediaconfig-extension.stub';

    protected $prefix = 'Extension';
}
