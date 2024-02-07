<?php

namespace Goldfinch\Component\Media\Commands;

use Goldfinch\Taz\Console\GeneratorCommand;

#[AsCommand(name: 'vendor:component-media:ext:admin')]
class MediaAdminExtensionCommand extends GeneratorCommand
{
    protected static $defaultName = 'vendor:component-media:ext:admin';

    protected $description = 'Create MediaAdmin extension';

    protected $path = '[psr4]/Extensions';

    protected $type = 'extension';

    protected $stub = './stubs/mediaadmin-extension.stub';

    protected $prefix = 'Extension';
}
