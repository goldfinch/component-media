<?php

namespace Goldfinch\Component\Media\Configs;

use Goldfinch\Fielder\Fielder;
use JonoM\SomeConfig\SomeConfig;
use SilverStripe\ORM\DataObject;
use Goldfinch\Fielder\Traits\FielderTrait;
use SilverStripe\View\TemplateGlobalProvider;

class MediaConfig extends DataObject implements TemplateGlobalProvider
{
    use SomeConfig, FielderTrait;

    private static $table_name = 'MediaConfig';

    private static $db = [];

    public function fielder(Fielder $fielder): void
    {
        // ..
    }
}
