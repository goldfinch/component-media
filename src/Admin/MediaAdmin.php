<?php

namespace Goldfinch\Component\Media\Admin;

use SilverStripe\Admin\ModelAdmin;
use JonoM\SomeConfig\SomeConfigAdmin;
use Goldfinch\Component\Media\Blocks\MediaBlock;
use Goldfinch\Component\Media\Configs\MediaConfig;
use Goldfinch\Component\Media\Models\MediaSegment;

class MediaAdmin extends ModelAdmin
{
    use SomeConfigAdmin;

    private static $url_segment = 'media';
    private static $menu_title = 'Media';
    private static $menu_icon_class = 'font-icon-block-carousel';
    // private static $menu_priority = -0.5;

    private static $managed_models = [
        MediaSegment::class => [
            'title' => 'Segments',
        ],
        MediaBlock::class => [
            'title' => 'Blocks',
        ],
        MediaConfig::class => [
            'title' => 'Settings',
        ],
    ];

    public function getManagedModels()
    {
        $models = parent::getManagedModels();

        $cfg = MediaConfig::current_config();

        if (!class_exists('DNADesign\Elemental\Models\BaseElement')) {
            unset($models[MediaBlock::class]);
        }

        if (empty($cfg->config('db')->db)) {
            unset($models[MediaConfig::class]);
        }

        return $models;
    }
}
